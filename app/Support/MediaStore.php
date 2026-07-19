<?php

namespace App\Support;

use App\Models\Medium;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Uploads land in public/uploads under a content-addressed-ish random name.
 * Replacing a file deletes the old one so the directory does not grow
 * unbounded on a shared-hosting disk quota.
 */
class MediaStore
{
    public const IMAGE_MIMES = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'];

    public const VIDEO_MIMES = ['mp4', 'webm', 'mov'];

    /** Store an upload and return its path relative to public/uploads. */
    public static function put(UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'bin');
        $name = Str::random(20).'.'.$ext;

        Storage::disk('uploads')->putFileAs('', $file, $name);

        return $name;
    }

    public static function delete(?string $path): void
    {
        if ($path) {
            Storage::disk('uploads')->delete($path);
        }
    }

    /** Swap the file behind a named slot, cleaning up the previous one. */
    public static function putSlot(string $slot, UploadedFile $file): string
    {
        $medium = Medium::firstWhere('slot', $slot);
        $path = static::put($file);

        if ($medium) {
            static::delete($medium->path);
            $medium->update(['path' => $path]);
        } else {
            Medium::create(['slot' => $slot, 'path' => $path]);
        }

        Medium::flush();
        SiteContent::flush();

        return $path;
    }

    public static function clearSlot(string $slot): void
    {
        if ($medium = Medium::firstWhere('slot', $slot)) {
            static::delete($medium->path);
            $medium->delete();
        }

        Medium::flush();
        SiteContent::flush();
    }

    /**
     * Replace the image on a collection row (product, post, gallery tile,
     * testimonial), deleting whatever it pointed at before.
     */
    public static function putOn(object $model, UploadedFile $file, string $column = 'image_path'): string
    {
        static::delete($model->{$column});
        $path = static::put($file);
        $model->update([$column => $path]);

        return $path;
    }

    public static function url(?string $path): ?string
    {
        return $path ? '/uploads/'.ltrim($path, '/') : null;
    }

    /**
     * Intrinsic [width, height] of an upload, or null if it is not a readable
     * image. Lets a layout reserve the right box before the file loads.
     *
     * Cached forever on purpose: put() names every upload randomly, so a given
     * path always refers to the same bytes and can never go stale.
     *
     * @return array{0:int,1:int}|null
     */
    public static function size(?string $path): ?array
    {
        if (! $path) {
            return null;
        }

        return Cache::rememberForever('media.size.'.$path, function () use ($path) {
            $file = public_path('uploads/'.ltrim($path, '/'));

            if (! is_file($file)) {
                return null;
            }

            $info = @getimagesize($file);

            return $info ? [$info[0], $info[1]] : null;
        });
    }
}

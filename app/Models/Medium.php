<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * A named image/video slot. `slot` matches the ids the design used for its
 * drag-and-drop <image-slot> elements, e.g. hero-slide-1, about-photo.
 */
class Medium extends Model
{
    protected $table = 'media';

    protected $fillable = ['slot', 'path'];

    public const CACHE_KEY = 'vka.media';

    /** slot => path */
    public static function map(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, fn () => static::query()->pluck('path', 'slot')->all());
    }

    /** Public URL for a slot, or null when nothing has been uploaded yet. */
    public static function url(string $slot): ?string
    {
        $path = static::map()[$slot] ?? null;

        return $path ? '/uploads/'.ltrim($path, '/') : null;
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /** Slots the admin exposes, with the human label + accepted mime group. */
    public static function slots(): array
    {
        return [
            'logo' => ['label' => 'Site logo', 'accept' => 'image'],
            'hero-slide-1' => ['label' => 'Hero slide 1', 'accept' => 'image'],
            'hero-slide-2' => ['label' => 'Hero slide 2', 'accept' => 'image'],
            'hero-slide-3' => ['label' => 'Hero slide 3', 'accept' => 'image'],
            'about-photo' => ['label' => 'About photo', 'accept' => 'image'],
            'video-poster' => ['label' => 'Video poster', 'accept' => 'image'],
            'facility-video' => ['label' => 'Facility video', 'accept' => 'video'],
            'contact-map' => ['label' => 'Contact map', 'accept' => 'image'],
        ];
    }
}

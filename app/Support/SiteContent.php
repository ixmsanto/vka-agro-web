<?php

namespace App\Support;

use App\Models\GalleryItem;
use App\Models\Medium;
use App\Models\Post;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Testimonial;

/**
 * Everything the public page renders.
 *
 * Only plain-array data (settings, media map) is cached — see Setting/Medium.
 * The collections are queried fresh each request: caching Eloquent models in
 * the file store deserializes them into incomplete-class objects, and the
 * whole marketing site is a single request over a handful of indexed SQLite
 * reads, so there is nothing to gain by caching them.
 */
class SiteContent
{
    public static function all(): array
    {
        return [
            'hero' => Setting::group('hero'),
            'video' => Setting::group('video'),
            'contact' => static::contact(),
            'products' => Product::with('specs')->ordered()->get(),
            'gallery' => GalleryItem::ordered()->get(),
            'testimonials' => Testimonial::ordered()->get(),
            'posts' => Post::ordered()->get(),
        ];
    }

    protected static function contact(): array
    {
        $contact = Setting::group('contact');

        // tel: / wa.me links need the bare digits.
        $digits = preg_replace('/[^0-9+]/', '', (string) ($contact['phone'] ?? ''));
        $contact['phoneHref'] = $digits;
        $contact['whatsapp'] = ltrim($digits, '+');

        return $contact;
    }

    /** Bust the plain-array caches the settings/media layers keep. */
    public static function flush(): void
    {
        Setting::flush();
        Medium::flush();
    }
}

<?php

namespace App\Support;

use App\Models\GalleryItem;
use App\Models\Post;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Model;

/**
 * The four ordered collections the admin edits. Keeping them in one registry
 * lets a single controller serve add / reorder / delete / autosave / upload
 * for all of them, exactly as the design's data-coll + data-op buttons did.
 */
class AdminResources
{
    public static function map(): array
    {
        return [
            'products' => [
                'model' => Product::class,
                'crumb' => 'Catalogue',
                'title' => 'Products',
                'singular' => 'product',
                'defaults' => ['tag' => 'New category', 'title' => 'New product', 'description' => ''],
            ],
            'blog' => [
                'model' => Post::class,
                'crumb' => 'Content',
                'title' => 'Blog & insights',
                'singular' => 'article',
                'defaults' => ['category' => 'Guides', 'read_time' => '5 min read', 'title' => 'New article', 'excerpt' => ''],
            ],
            'gallery' => [
                'model' => GalleryItem::class,
                'crumb' => 'Media',
                'title' => 'Gallery',
                'singular' => 'gallery tile',
                'defaults' => ['caption' => 'New tile', 'col_span' => 1, 'row_span' => 1],
            ],
            'testimonials' => [
                'model' => Testimonial::class,
                'crumb' => 'Social proof',
                'title' => 'Testimonials',
                'singular' => 'testimonial',
                'defaults' => ['quote' => '', 'name' => 'New customer', 'role' => ''],
            ],
        ];
    }

    public static function config(string $resource): array
    {
        return static::map()[$resource] ?? abort(404);
    }

    /** @return class-string<Model> */
    public static function model(string $resource): string
    {
        return static::config($resource)['model'];
    }

    public static function find(string $resource, int|string $id): Model
    {
        return static::model($resource)::query()->findOrFail($id);
    }

    /**
     * A fresh row. Products get the next zero-padded number so the design's
     * "01 / 02 / 03" rail keeps counting.
     */
    public static function make(string $resource): Model
    {
        $class = static::model($resource);
        $attributes = static::config($resource)['defaults'];
        $attributes['position'] = $class::nextPosition();

        if ($resource === 'products') {
            $attributes['num'] = str_pad((string) ($class::count() + 1), 2, '0', STR_PAD_LEFT);
        }

        return $class::create($attributes);
    }
}

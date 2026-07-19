<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Key/value store for the singleton content groups: hero, video, contact.
 * Reads are cached forever and busted on write, so the public page costs
 * one query on a cold cache and none afterwards.
 */
class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    protected $casts = ['value' => 'array'];

    public const CACHE_KEY = 'vka.settings';

    /** All groups, keyed by group name. */
    public static function all_groups(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, fn () => static::query()
            ->pluck('value', 'key')
            ->map(fn ($v) => is_array($v) ? $v : [])
            ->all());
    }

    /** One group, merged over its defaults so a missing key never explodes a view. */
    public static function group(string $key): array
    {
        return array_merge(
            static::defaults()[$key] ?? [],
            static::all_groups()[$key] ?? [],
        );
    }

    public static function putGroup(string $key, array $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        static::flush();
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Shape + fallback copy for each group. Also the source of truth for which
     * fields the admin is allowed to write (see SettingController).
     */
    public static function defaults(): array
    {
        return [
            'hero' => [
                'badge' => 'Premium Coco Peat Manufacturer',
                'titleLine1' => 'Coco pith that',
                'titleAccent' => 'grows better',
                'titleLine3' => 'harvests.',
                'subtitle' => 'High-quality coco peat blocks, briquettes and grow bags engineered for superior water retention, healthier roots and higher crop yields.',
            ],
            'video' => [
                'badge' => 'Inside VKAAgroproducts',
                'headingPre' => 'From coconut husk to ',
                'headingAccent' => 'global container',
                'subtitle' => 'Take a two-minute walk through our facility — washing, buffering, drying and pressing coir into export-grade coco peat.',
                'caption' => 'Facility walkthrough · 2:14',
            ],
            'contact' => [
                'address' => 'VKAAgroproducts Exports, Pollachi, Tamil Nadu 642001, India',
                'email' => 'export@vkaagro.com',
                'phone' => '+91 98765 43210',
                'intro' => "Tell us your crop, volumes and target specification — we'll reply within one business day with pricing and availability.",
            ],
        ];
    }
}

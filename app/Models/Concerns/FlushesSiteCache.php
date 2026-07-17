<?php

namespace App\Models\Concerns;

use App\Support\SiteContent;

trait FlushesSiteCache
{
    protected static function bootFlushesSiteCache(): void
    {
        static::saved(fn () => SiteContent::flush());
        static::deleted(fn () => SiteContent::flush());
    }
}

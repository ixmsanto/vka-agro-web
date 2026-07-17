<?php

namespace App\Support;

/**
 * Cache-busting token for the hand-written css/js. There is no bundler to
 * fingerprint filenames, so the newest mtime across the assets stands in.
 * Deploys over FTP update mtimes, which is exactly when we want a new token.
 */
class Assets
{
    protected const FILES = ['css/site.css', 'css/admin.css', 'js/site.js', 'js/admin.js'];

    protected static ?string $version = null;

    public static function version(): string
    {
        if (static::$version !== null) {
            return static::$version;
        }

        $newest = 0;

        foreach (static::FILES as $file) {
            $path = public_path($file);

            if (is_file($path)) {
                $newest = max($newest, (int) filemtime($path));
            }
        }

        return static::$version = (string) ($newest ?: 1);
    }
}

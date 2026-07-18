<?php

/**
 * Shared-hosting front controller for VKA Agro.
 *
 * The Laravel application lives in ./laravel/ (a subfolder of public_html).
 * The laravel/ directory is protected from direct browser access via .htaccess.
 * This is a drop-in replacement for the stock public/index.php with the paths
 * repointed to the sibling laravel/ folder.
 *
 * If your app folder is named something other than "laravel", change
 * $app_base below to match.
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// The Laravel app lives inside public_html/laravel/ (protected by .htaccess).
$app_base = __DIR__.'/laravel';

// Maintenance mode...
if (file_exists($maintenance = $app_base.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $app_base.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $app_base.'/bootstrap/app.php';

$app->handleRequest(Request::capture());

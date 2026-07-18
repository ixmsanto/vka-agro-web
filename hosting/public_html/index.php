<?php

/**
 * Shared-hosting front controller for VKA Agro.
 *
 * The Laravel application lives in ./vka-app/ (a subfolder of public_html).
 * The vka-app/ directory is protected from direct browser access via .htaccess.
 * This is a drop-in replacement for the stock public/index.php with the paths
 * repointed to the sibling vka-app/ folder.
 *
 * If your app folder is named something other than "vka-app", change
 * $app_base below to match.
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// The Laravel app lives inside public_html/vka-app/ (protected by .htaccess).
$app_base = __DIR__.'/vka-app';

// Maintenance mode...
if (file_exists($maintenance = $app_base.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $app_base.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $app_base.'/bootstrap/app.php';

$app->handleRequest(Request::capture());

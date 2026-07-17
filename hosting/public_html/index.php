<?php

/**
 * Shared-hosting front controller for VKA Agro.
 *
 * The Laravel application lives OUTSIDE the web root (in ../vka-app), so that
 * only this file and the compiled assets under public_html are web-reachable.
 * This is a drop-in replacement for the stock public/index.php with the paths
 * repointed one directory up-and-over.
 *
 * If your app folder is named something other than "vka-app", change
 * $app_base below to match.
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// public_html and vka-app are siblings in the account home directory.
$app_base = __DIR__.'/../vka-app';

// Maintenance mode...
if (file_exists($maintenance = $app_base.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $app_base.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $app_base.'/bootstrap/app.php';

$app->handleRequest(Request::capture());

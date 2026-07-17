<?php

namespace App\Providers;

use App\Support\Assets;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::share('assetVersion', Assets::version());

        // Shared hosting terminates TLS at the proxy; without this, asset() and
        // route() emit http:// URLs on an https:// page and browsers block them.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}

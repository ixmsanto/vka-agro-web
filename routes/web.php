<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SpecController;
use App\Http\Controllers\DeployController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/* -------------------------------- public -------------------------------- */

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/inquiry', [InquiryController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('inquiry.store');

// Post-deploy hook (token-guarded; 404s unless DEPLOY_TOKEN is set). Not CSRF
// protected — it authenticates with the shared secret instead of a session.
Route::post('/__deploy', [DeployController::class, 'run'])->name('deploy.run');

/* --------------------------------- admin -------------------------------- */

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'create'])->name('login');
        Route::post('login', [AuthController::class, 'store'])->middleware('throttle:10,1')->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Singleton content groups: hero, video, contact.
        Route::get('settings/{group}', [SettingController::class, 'edit'])
            ->whereIn('group', ['hero', 'video', 'contact'])
            ->name('settings.edit');
        Route::put('settings/{group}', [SettingController::class, 'update'])
            ->whereIn('group', ['hero', 'video', 'contact'])
            ->name('settings.update');

        // Named image/video slots: logo, hero slides, about photo, poster, map.
        Route::get('media', [MediaController::class, 'index'])->name('media.index');
        Route::post('media/{slot}', [MediaController::class, 'store'])->name('media.store');
        Route::delete('media/{slot}', [MediaController::class, 'destroy'])->name('media.destroy');

        // Product spec rows. Declared before the {resource} routes so that
        // "products/{product}/specs" is not swallowed by "{resource}/{id}".
        Route::post('products/{product}/specs', [SpecController::class, 'store'])->name('specs.store');
        Route::patch('specs/{spec}', [SpecController::class, 'update'])->name('specs.update');
        Route::delete('specs/{spec}', [SpecController::class, 'destroy'])->name('specs.destroy');

        // Contact-form submissions.
        Route::get('inquiries', [AdminInquiryController::class, 'index'])->name('inquiries.index');
        Route::delete('inquiries/{inquiry}', [AdminInquiryController::class, 'destroy'])->name('inquiries.destroy');

        // Ordered collections: products, blog, gallery, testimonials.
        Route::whereIn('resource', ['products', 'blog', 'gallery', 'testimonials'])->group(function () {
            Route::get('{resource}', [CollectionController::class, 'index'])->name('collection.index');
            Route::post('{resource}', [CollectionController::class, 'store'])->name('collection.store');
            Route::patch('{resource}/{id}', [CollectionController::class, 'update'])->name('collection.update');
            Route::delete('{resource}/{id}', [CollectionController::class, 'destroy'])->name('collection.destroy');
            Route::post('{resource}/{id}/move', [CollectionController::class, 'move'])->name('collection.move');
            Route::post('{resource}/{id}/image', [CollectionController::class, 'image'])->name('collection.image');
            Route::delete('{resource}/{id}/image', [CollectionController::class, 'clearImage'])->name('collection.image.destroy');
        });

        /* -------------------- artisan / maintenance -------------------- */
        Route::prefix('artisan')->name('artisan.')->group(function () {

            // ------ Cache ------
            Route::get('cache-clear', function () {
                Artisan::call('cache:clear');
                return response()->json(['status' => 'ok', 'message' => Artisan::output()]);
            })->name('cache.clear');

            Route::get('cache-all', function () {
                Artisan::call('config:cache');
                Artisan::call('route:cache');
                Artisan::call('view:cache');
                return response()->json(['status' => 'ok', 'message' => 'config + route + view cached.']);
            })->name('cache.all');

            Route::get('clear-all', function () {
                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('route:clear');
                Artisan::call('view:clear');
                Artisan::call('event:clear');
                return response()->json(['status' => 'ok', 'message' => 'All caches cleared.']);
            })->name('clear.all');

            // ------ Config ------
            Route::get('config-cache', function () {
                Artisan::call('config:cache');
                return response()->json(['status' => 'ok', 'message' => Artisan::output()]);
            })->name('config.cache');

            Route::get('config-clear', function () {
                Artisan::call('config:clear');
                return response()->json(['status' => 'ok', 'message' => Artisan::output()]);
            })->name('config.clear');

            // ------ Routes ------
            Route::get('route-cache', function () {
                Artisan::call('route:cache');
                return response()->json(['status' => 'ok', 'message' => Artisan::output()]);
            })->name('route.cache');

            Route::get('route-clear', function () {
                Artisan::call('route:clear');
                return response()->json(['status' => 'ok', 'message' => Artisan::output()]);
            })->name('route.clear');

            // ------ Views ------
            Route::get('view-cache', function () {
                Artisan::call('view:cache');
                return response()->json(['status' => 'ok', 'message' => Artisan::output()]);
            })->name('view.cache');

            Route::get('view-clear', function () {
                Artisan::call('view:clear');
                return response()->json(['status' => 'ok', 'message' => Artisan::output()]);
            })->name('view.clear');

            // ------ Storage ------
            Route::get('storage-link', function () {
                Artisan::call('storage:link');
                return response()->json(['status' => 'ok', 'message' => Artisan::output()]);
            })->name('storage.link');

            // ------ Optimize ------
            Route::get('optimize', function () {
                Artisan::call('optimize');
                return response()->json(['status' => 'ok', 'message' => Artisan::output()]);
            })->name('optimize');

            Route::get('optimize-clear', function () {
                Artisan::call('optimize:clear');
                return response()->json(['status' => 'ok', 'message' => Artisan::output()]);
            })->name('optimize.clear');

            // ------ Migrations ------
            Route::get('migrate', function () {
                Artisan::call('migrate', ['--force' => true]);
                return response()->json(['status' => 'ok', 'message' => Artisan::output()]);
            })->name('migrate');

            Route::get('migrate-status', function () {
                Artisan::call('migrate:status');
                return response()->json(['status' => 'ok', 'message' => Artisan::output()]);
            })->name('migrate.status');

            // ------ Queue ------
            Route::get('queue-restart', function () {
                Artisan::call('queue:restart');
                return response()->json(['status' => 'ok', 'message' => Artisan::output()]);
            })->name('queue.restart');

            // ------ Symlink / App key ------
            Route::get('key-generate', function () {
                Artisan::call('key:generate', ['--force' => true]);
                return response()->json(['status' => 'ok', 'message' => Artisan::output()]);
            })->name('key.generate');

        });
    });
});

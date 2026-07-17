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
    });
});

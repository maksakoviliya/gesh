<?php

declare(strict_types=1);

use App\Http\Controllers\Account\AccountIndexController;
use App\Http\Controllers\Account\AccountProfileController;
use App\Http\Controllers\Account\Apartments\CalendarController;
use App\Http\Controllers\Account\Apartments\UpdateCalendarController;
use App\Http\Controllers\Account\Apartments\UpdatePriceController;
use App\Http\Controllers\Account\Apartments\CreateController;
use App\Http\Controllers\Account\Apartments\ListController;
use App\Http\Controllers\Account\Apartments\PendingController;
use App\Http\Controllers\Account\Apartments\StepController;
use App\Http\Controllers\Account\Apartments\StoreController;
use App\Http\Controllers\Apartments\ChatController;
use App\Http\Controllers\ApartmentShowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Social\SocialCallbackController;
use App\Http\Controllers\Social\SocialRedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/apartments/{apartment}', ApartmentShowController::class)->name('apartment');

// Social Auth
Route::get('/auth/redirect/{provider}', SocialRedirectController::class)->name('social_redirect');
Route::get('/auth/callback/{provider}', SocialCallbackController::class);

Route::middleware('auth:sanctum')->group(function () {
    // Account
    Route::prefix('account')->as('account.')->group(function () {
        Route::get('/', AccountIndexController::class)->name('index');
        Route::get('profile', AccountProfileController::class)->name('profile');

        Route::prefix('apartments')
            ->as('apartments.')
            ->namespace('App\\Http\\Controllers\\Account\\Apartments\\')
            ->group(function () {
                Route::get('/', ListController::class)->name('list');
                Route::get('create', CreateController::class)->name('create');
                Route::get('{apartment}/step/{step}', StepController::class)->name('step');
                Route::post('{apartment}/store', StoreController::class)->name('store');
                Route::get('{apartment}/pending', PendingController::class)->name('pending');
                Route::get('{apartment}/calendar', CalendarController::class)->name('calendar');
                Route::post('{apartment}/calendar/update', UpdateCalendarController::class)->name('calendar.update');
                Route::post('{apartment}/price/update', UpdatePriceController::class)->name('price.update');
            });
    });

    // Apartments
    Route::prefix('apartments')->as('apartments.')->group(function () {
        Route::get('{apartment}/chat', ChatController::class)->name('chat');
    });
});
//Route::middleware([
//    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified',
//])->group(function () {
//    Route::get('/dashboard', function () {
//        return Inertia::render('Dashboard');
//    })->name('dashboard');
//});

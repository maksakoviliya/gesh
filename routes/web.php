<?php

declare(strict_types=1);

use App\Http\Controllers\Account\AccountIndexController;
use App\Http\Controllers\Account\AccountProfileController;
use App\Http\Controllers\Account\AccountStoreApartmentsController;
use App\Http\Controllers\Account\Apartments\AccountApartmentsController;
use App\Http\Controllers\Account\Apartments\AccountCreateApartmentsController;
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

        Route::prefix('apartments')->group(function () {
            Route::get('/', AccountApartmentsController::class)->name('apartments');
            Route::get('create', AccountCreateApartmentsController::class)->name('apartments.create');
            Route::post('store', AccountStoreApartmentsController::class)->name('apartments.store');
        });
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

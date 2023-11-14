<?php

declare(strict_types=1);

use App\Http\Controllers\ApartmentShowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Social\SocialCallbackController;
use App\Http\Controllers\Social\SocialRedirectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', HomeController::class)->name('home');
Route::get('/apartments/{apartment}', ApartmentShowController::class)->name('apartment');

Route::get('/auth/redirect/{provider}', SocialRedirectController::class)->name('social_redirect');
Route::get('/auth/callback/{provider}', SocialCallbackController::class);
//Route::middleware([
//    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified',
//])->group(function () {
//    Route::get('/dashboard', function () {
//        return Inertia::render('Dashboard');
//    })->name('dashboard');
//});

<?php

declare(strict_types=1);

use App\Http\Controllers\Payments\PaymentCallbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::match(['post', 'get'], 'payment-callback', PaymentCallbackController::class);

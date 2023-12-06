<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\PaymentServiceContract;
use App\Services\YooKassaPaymentService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentServiceContract::class, function ($app) {
            return new YooKassaPaymentService();
        });
    }

    public function boot(): void
    {
        //
    }
}

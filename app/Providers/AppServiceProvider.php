<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\PaymentServiceContract;
use App\Services\Transfer\Conversation\ConversationManager;
use App\Services\Transfer\TelegramMessageBuilder;
use App\Services\Transfer\TelegramWebhookHandler;
use App\Services\YooKassaPaymentService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentServiceContract::class, function ($app) {
            return new YooKassaPaymentService;
        });

        $this->app->singleton(TelegramWebhookHandler::class);
        $this->app->singleton(ConversationManager::class);
        $this->app->singleton(TelegramMessageBuilder::class);
    }

    public function boot(): void {}
}

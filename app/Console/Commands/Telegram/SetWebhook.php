<?php

declare(strict_types=1);

namespace App\Console\Commands\Telegram;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

final class SetWebhook extends Command
{
    protected $signature = 'set-webhook';

    protected $description = 'Set webhook for telegram bot';

    public function handle(): int
    {
        $url = 'https://3f23-46-138-184-71.ngrok-free.app/tg_bot_token_123/webhook';
        Log::info('Setting webhook: '.$url);
        $response = Telegram::setWebhook(['url' => $url]);
        Log::info('Response: '.json_encode($response));

        return parent::SUCCESS;
    }
}

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
        //        $url = sprintf('%s/%s/webhook', env('NGROK_URL'), env('TG_WEBHOOK_TOKEN', 'tg_bot_token_123'));
        //        Log::info('Setting webhook: '.$url);
        //        $response = Telegram::setWebhook(['url' => $url]);
        //        Log::info('Response: '.json_encode($response));
        //        $this->info(json_encode($response));

        $url = env('TELEGRAM_TRANSFER_BOT_WEBHOOK_URL');
        $this->info("Setting transfer tg bot webhook: $url");
        $response = Telegram::bot('transferBot')->setWebhook(['url' => $url]);
        $this->info(json_encode($response));

        return parent::SUCCESS;
    }
}

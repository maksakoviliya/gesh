<?php

declare(strict_types=1);

namespace App\Console\Commands\Telegram;

use App\Services\Transfer\TelegramWebhookHandler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use Throwable;

final class PollTransferBot extends Command
{
    protected $signature = 'transfer-bot:poll {--timeout=25 : Long polling timeout, seconds}';

    protected $description = 'Receive transfer bot updates via long polling (instead of webhook)';

    public function handle(TelegramWebhookHandler $handler): int
    {
        $bot = Telegram::bot('transferBot');

        // getUpdates returns 409 Conflict while a webhook is set
        $bot->deleteWebhook();
        $this->info('Webhook removed, polling transfer bot...');

        $offset = 0;

        while (true) {
            try {
                $updates = $bot->getUpdates([
                    'offset' => $offset,
                    'timeout' => (int) $this->option('timeout'),
                    'allowed_updates' => ['message', 'callback_query'],
                ]);
            } catch (Throwable $e) {
                Log::warning('Transfer bot polling failed', ['error' => $e->getMessage()]);
                sleep(5);

                continue;
            }

            foreach ($updates as $update) {
                // Advance before handling so a poison update can't block the queue.
                $offset = $update->updateId + 1;
                $handler->handle($update);
            }
        }
    }
}

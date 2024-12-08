<?php

declare(strict_types=1);

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Services\Transfer\TelegramService;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;

final class TelegramBotController extends Controller
{
    /**
     * @throws TelegramSDKException
     */
    public function processWebhook(TelegramService $telegramService): string
    {
        $updates = Telegram::bot('transferBot')->commandsHandler(true);

        $telegramService->processUpdates($updates);

        return 'ok';
    }
}

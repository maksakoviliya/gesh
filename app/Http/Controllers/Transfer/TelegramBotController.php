<?php

declare(strict_types=1);

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Services\Transfer\TelegramService;
use App\Services\Transfer\TelegramWebhookHandler;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Telegram\Bot\Laravel\Facades\Telegram;

final class TelegramBotController extends Controller
{
    /**
     * @throws Exception
     */
    public function processWebhook(TelegramService $telegramService): \Illuminate\Foundation\Application|Response|Application|ResponseFactory
    {
        $update = Telegram::bot('transferBot')->getWebhookUpdate();

        app(TelegramWebhookHandler::class)->handle($update);

        return response('ok');
    }
}

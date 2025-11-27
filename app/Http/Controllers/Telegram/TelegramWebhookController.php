<?php

declare(strict_types=1);

namespace App\Http\Controllers\Telegram;

use App\Enums\Telegram\EntityType;
use App\Http\Controllers\Controller;
use App\Services\Telegram\CallBackQueryService;
use App\Services\Telegram\ProcessTextService;
use App\Services\Telegram\TelegramWebhookProcessor;
use Arr;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Str;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;
use Throwable;

class TelegramWebhookController extends Controller
{
	public function __construct(
		private readonly TelegramWebhookProcessor $processor
	) {}
	
    public function __invoke(Request $request, CallBackQueryService $callback_service, ProcessTextService $service): JsonResponse
    {
	    try {
		    // Логируем входящий запрос для отладки
		    Log::debug('Telegram webhook received', [
			    'payload' => $request->all(),
			    'timestamp' => now()->toISOString(),
		    ]);

		    // Получаем Update объект через SDK
		    $update = Telegram::commandsHandler(true);

		    // Делегируем всю обработку специализированному сервису
		    $this->processor->process($update);

		    // Telegram требует ответ 200 OK
		    return response()->json(['ok' => true]);

	    } catch (TelegramSDKException $e) {
		    Log::error('Telegram SDK error', [
			    'message' => $e->getMessage(),
			    'code' => $e->getCode(),
		    ]);

		    // Даже при ошибке возвращаем 200, чтобы Telegram не повторял запрос
		    return response()->json(['ok' => true]);

	    } catch (Throwable $e) {
		    Log::error('Webhook processing error', [
			    'message' => $e->getMessage(),
			    'trace' => $e->getTraceAsString(),
		    ]);

		    return response()->json(['ok' => true]);
	    }
    }
}

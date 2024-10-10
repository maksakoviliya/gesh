<?php

namespace App\Http\Controllers\Telegram;

use App\Enums\Telegram\EntityType;
use App\Http\Controllers\Controller;
use App\Services\Telegram\CallBackQueryService;
use App\Services\Telegram\ProcessTextService;
use Arr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Str;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramWebhookController extends Controller
{
    public function __invoke(Request $request, CallBackQueryService $callback_service, ProcessTextService $service): string
    {
        Log::info(Carbon::now()->format('d.m.Y H:i:s').': '.json_encode($request->all()));
        $updates = Telegram::commandsHandler(true);
        Log::info('Updates: '.json_encode($updates));
        try {
            $type = json_encode(Arr::get($request->all(), 'message.entities.0.type'));
            $callback_query = Arr::get($request->all(), 'callback_query');
            $chat_id = Arr::get($request->all(), 'message.chat.id');

            Log::info('Type: '.json_encode($type));
            Log::info('Callback Query: '.json_encode($callback_query));
            Log::info('$chat_id: '.$chat_id);
            if ($callback_query) {
                $callback_service->process($callback_query);
            } else {
                if (Str::contains($type, EntityType::PhoneNumber->value)) {
                    Log::info('$service->processPhone');
                    $service->processPhone(
                        Arr::get($request->all(), 'message.text'),
                        $chat_id,
                    );
                } elseif (Str::contains($type, EntityType::BotCommand->value)) {
                    Log::info('work with command handler');
                } else {
                    Log::info('$service->processText');
                    $service->processText(
                        Arr::get($request->all(), 'message.text'),
                        $chat_id,
                    );
                }
            }
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());
        } finally {
            return 'ok';
        }

    }
}

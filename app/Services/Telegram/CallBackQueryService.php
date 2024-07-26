<?php

namespace App\Services\Telegram;

use App\Enums\Telegram\CallbackDataKeyEnum;
use App\Models\Telegram\ActionSetDisabledDates;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class CallBackQueryService
{
    public function process(array $callback_data): bool
    {
        $data = Arr::get($callback_data, 'data');

        $key = Arr::first(explode(':', $data));
        $value = Arr::last(explode(':', $data));

        $chat_id = Arr::get($callback_data, 'message.chat.id');

        Log::info('Caht id: '.$chat_id);

        if (! $chat_id) {
            Log::info('Chat id not found');
        }

        if ($key === CallbackDataKeyEnum::SetApartmentForDisablingDate->value) {
            $user = User::query()
                ->where('telegram_chat_id', $chat_id)
                ->first();

            if (! $user) {
                Log::info('User not found');

                return false;
            }

            ActionSetDisabledDates::query()
                ->firstOrCreate([
                    'user_id' => $user->id,
                    'apartment_id' => $value,
                ]);

            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Введите даты в формате дд.мм.гггг, которые хотите закрыть для бронирования. Уазывать нужно через тире. Например, 22.10.2024 - 25.10.2024',
            ]);
        }
    }
}

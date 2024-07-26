<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use App\Models\Telegram\ActionSetDisabledDates;
use App\Models\TelegramAuthCode;
use App\Models\User;
use App\Notifications\Telegram\NewTelegramAuthCodeGeneratedNotification;
use App\Notifications\Telegram\WelcomeToTelegramBotNotification;
use Illuminate\Support\Facades\Log;
use Propaganistas\LaravelPhone\PhoneNumber;
use Telegram\Bot\Laravel\Facades\Telegram;

final class ProcessTextService
{
    public function processPhone(string $text, string $chat_id): void
    {
        $phone = new PhoneNumber($text, 'RU');
        Log::info('Phone: '.$phone->formatE164());
        if (! $phone->isValid()) {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Ошибка при обработке номера, попробуйте еще раз...',
            ]);

            return;
        }
        $user = User::query()
            ->where('phone', $phone->formatE164())
            ->first();
        Log::info('user: '.json_encode($user));
        if (! $user) {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Пользователь с таким номером телефона не обнаружен.',
            ]);

            return;
        }

        $code = $user->generateTelegramCode($chat_id);
        $user = User::query()
            ->find($user->id);
        Log::info('Tg chat ID: '.$user->telegram_chat_id);
        $user->notify(new NewTelegramAuthCodeGeneratedNotification($code));
    }

    public function processText(string $text, string $chat_id): void
    {
        Log::info('Process text: '.$text);

        $user = User::query()
            ->where('telegram_chat_id', $chat_id)
            ->first();

        $actionSetDisabledDates = ActionSetDisabledDates::query()
            ->where('user_id', $user->id)
            ->first();
        if ($actionSetDisabledDates) {
            $message = $actionSetDisabledDates->processDatesText($text)
                ? 'Спасибо. Ваш запрос обработан.'
                : 'Ошибка. Что-то пошло не так.';

            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => $message,
            ]);

            return;
        }

        if (strlen($text) === 4) {
            $user = TelegramAuthCode::processCode($text, $chat_id);
            Log::info('User: '.json_encode($user));
            if (! $user) {
                return;
            }
            $user->notify(new WelcomeToTelegramBotNotification());
        }
    }
}

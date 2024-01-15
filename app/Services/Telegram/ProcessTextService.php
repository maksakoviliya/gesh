<?php

namespace App\Services\Telegram;

use App\Models\TelegramAuthCode;
use App\Models\User;
use App\Notifications\Telegram\NewTelegramAuthCodeGeneratedNotification;
use App\Notifications\Telegram\WelcomeToTelegramBotNotification;
use Propaganistas\LaravelPhone\PhoneNumber;
use Telegram\Bot\Laravel\Facades\Telegram;

class ProcessTextService
{
    public function processPhone(string $text, string $chat_id): void
    {
        $phone = new PhoneNumber($text, 'RU');
        if (!$phone->isValid()) {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Ошибка при обработке номера, попробуйте еще раз...',
            ]);
            return;
        }
        $user = User::query()
            ->where('phone', $phone->formatE164())
            ->first();
        if (!$user) {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Пользователь с таким номером телефона не обнаружен.',
            ]);
            return;
        }

        $code = $user->generateTelegramCode($chat_id);
        $user->notify(new NewTelegramAuthCodeGeneratedNotification($code));
    }

    public function processText(string $text, string $chat_id)
    {
        \Log::info('Process text: ' . $text);
        if (strlen($text) === 4) {
           $user = TelegramAuthCode::processCode($text, $chat_id);
           \Log::info('User: ' . json_encode($user));
           if (!$user) {
               return;
           }
           $user->notify(new WelcomeToTelegramBotNotification());
        }
    }
}

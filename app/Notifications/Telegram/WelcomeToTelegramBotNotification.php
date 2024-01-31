<?php

declare(strict_types=1);

namespace App\Notifications\Telegram;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use JsonException;
use Log;
use NotificationChannels\Telegram\TelegramMessage;

final class WelcomeToTelegramBotNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        Log::info('toTelegram');
        if (! $notifiable->telegram_chat_id) {
            Log::info('User has no Telegram chat!');
        }
        return TelegramMessage::create()
            ->content('Отлично! Теперь вы сможете видеть уведомления в этом боте.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

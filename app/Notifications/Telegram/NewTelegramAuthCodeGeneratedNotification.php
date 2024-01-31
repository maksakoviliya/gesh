<?php

declare(strict_types=1);

namespace App\Notifications\Telegram;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use JsonException;
use NotificationChannels\Telegram\TelegramMessage;

final class NewTelegramAuthCodeGeneratedNotification extends Notification
{
    use Queueable;

    public function __construct(public int $code)
    {
    }

    public function via($notifiable): array
    {
        return ['database', 'telegram'];
    }

    /**
     * @throws JsonException
     */
    public function toTelegram($notifiable)
    {
        Log::info('Notifiallble: ' . json_encode($notifiable));
        if (!$notifiable->telegram_chat_id) {
            Log::info('No telegram_chat_id provided');
        }
        $url = route('account.notifications.index');

        $message = TelegramMessage::create()
            ->content('Введите код для авторизации.')
            ->line('Найти его можно на сайте, в разделе уведомления.')
            ->button('Все уведомления', $url);

        Log::info(json_encode($message));

        return $message;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'code' => $this->code,
        ];
    }
}

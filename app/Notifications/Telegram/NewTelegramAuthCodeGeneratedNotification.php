<?php

declare(strict_types=1);

namespace App\Notifications\Telegram;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

final class NewTelegramAuthCodeGeneratedNotification extends Notification
{
    use Queueable;

    public function __construct(public int $code)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'telegram'];
    }

    public function toTelegram()
    {
        $url = route('account.notifications.index');
        return TelegramMessage::create()
            ->content("Код для авторизации отправлен вам в приложении.")
            ->button('Все уведомления', $url);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'code' => $this->code,
        ];
    }
}

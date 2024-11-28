<?php

namespace App\Notifications\Admin\Transfer;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class ScheduleNotification extends Notification
{
    use Queueable;

    public function __construct(public string $name, public string $phone) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Трансфер')
            ->line('Пользователь хочет забронировать трансфер.')
            ->line('Пользователь: '.$this->name)
            ->line('Телефон: '.$this->phone);
    }

    //    public function toTelegram($notifiable)
    //    {
    //        return TelegramMessage::create()
    //            ->to(env('CHAT_ID'))
    //            ->content("Запрос на трансфер!")
    //            ->line('Пользователь: ' . $this->name)
    //            ->line('Телефон: ' . $this->phone);
    //    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

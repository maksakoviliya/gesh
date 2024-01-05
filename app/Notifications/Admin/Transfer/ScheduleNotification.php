<?php

namespace App\Notifications\Admin\Transfer;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ScheduleNotification extends Notification
{
    use Queueable;

    public function __construct(public string $name, public string $phone)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->theme('Трансфер')
            ->line('Пользователь хочет забронировать трансфер.')
            ->line('Пользователь: '.$this->name)
            ->line('Телефон: '.$this->phone);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

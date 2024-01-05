<?php

declare(strict_types=1);

namespace App\Notifications\Admin\Instructors;

use App\Models\Instructor;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class ScheduleNotification extends Notification
{
    use Queueable;

    public function __construct(public Instructor $instructor, public string $name, public string $phone)
    {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->theme('Инструктор')
            ->line('Пользователь хочет забронировать инструктора.')
            ->line('Инструктор ID: '.$this->instructor->id)
            ->line('Инструктор имя: '.$this->instructor->name)
            ->line('Пользователь: '.$this->name)
            ->line('Телефон: '.$this->phone);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'instructor_id' => $this->instructor->id,
        ];
    }
}

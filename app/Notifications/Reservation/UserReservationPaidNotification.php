<?php

declare(strict_types=1);

namespace App\Notifications\Reservation;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class UserReservationPaidNotification extends Notification
{
    use Queueable;

    public function __construct(public Reservation $reservation)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Бронирование предоплачено')
            ->line('Вы оплатили бронирование');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'reservation_id'
        ];
    }
}

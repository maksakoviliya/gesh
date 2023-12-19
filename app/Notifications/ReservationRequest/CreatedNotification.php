<?php

declare(strict_types=1);

namespace App\Notifications\ReservationRequest;

use App\Models\ReservationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreatedNotification extends Notification
{
    use Queueable;

    public function __construct(public ReservationRequest $reservationRequest)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Ваше жилье хотят забронировать')
            ->line('Ваше жилье хотят забронировать');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'reservation_request_id' => $this->reservationRequest->id,
        ];
    }
}

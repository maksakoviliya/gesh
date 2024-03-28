<?php

declare(strict_types=1);

namespace App\Notifications\ReservationRequest;

use App\Models\Chat\Chat;
use App\Models\ReservationRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use JsonException;
use NotificationChannels\Telegram\TelegramMessage;

class CreatedNotification extends Notification
{
    use Queueable;

    public function __construct(public ReservationRequest $reservationRequest)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'telegram'];
    }

    /**
     * @throws JsonException
     */
    public function toTelegram(User $notifiable): TelegramMessage
    {
        if (! $notifiable->telegram_chat_id) {
            throw new JsonException('User has no Telegram chat!');
        }

        $chat = Chat::query()
            ->where('apartment_id', $this->reservationRequest?->apartment_id)
            ->where('user_id', $this->reservationRequest?->user?->id)
            ->first();

        $url = route('account.apartments.owner.chat', [
            'apartment' => $this->reservationRequest?->apartment_id,
            'chat' => $chat->id,
        ]);

        return TelegramMessage::create()
            ->content("*Новый запрос на бронирование!*\n")
            ->line('Объект: '.$this->reservationRequest?->apartment->city.', '.$this->reservationRequest?->apartment->street.', '.$this->reservationRequest?->apartment->building)
            ->line('Гость: '.$this->reservationRequest?->user->name)
            ->line('Даты: '.$this->reservationRequest?->start->format('d\.m\.Y').' - '.$this->reservationRequest?->end->format('d\.m\.Y'))
            ->line('Цена для клиента: '.$this->reservationRequest?->price.', Первоначальный платеж: '.$this->reservationRequest?->first_payment)
            ->line('Гости: '.$this->reservationRequest?->total_guests)
            ->button(
                'К диалогу',
                config('app.env') === 'production' ? $url : 'https://google.com'
            );

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

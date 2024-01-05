<?php

declare(strict_types=1);

namespace App\Listeners\ReservationRequest;

use App\Actions\TelegramNotifications\SendMessageToAdminGroup;
use App\Events\ReservationRequest\CreatedEvent;
use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use App\Notifications\ReservationRequest\CreatedNotification;
use Illuminate\Support\Facades\Auth;

final class CreatedListener
{
    protected SendMessageToAdminGroup $telegram;

    public function __construct()
    {
        $this->telegram = new SendMessageToAdminGroup();
    }

    public function handle(CreatedEvent $event): void
    {
        $reservation_request = $event->reservationRequest;
        $apartment = $reservation_request->apartment;
        $chat = Chat::query()
            ->firstOrCreate([
                'apartment_id' => $apartment->id,
                'user_id' => Auth::id(),
            ]);
        Message::query()->firstOrCreate([
            'chat_id' => $chat->id,
            'user_id' => Auth::id(),
            'reservation_request_id' => $reservation_request->id,
        ]);

        $owner = $apartment->user;

        $owner->notify(new CreatedNotification($reservation_request));

        $this->telegram->sendNewReservationRequestMessage($reservation_request);
    }
}

<?php

namespace App\Listeners\ReservationRequest;

use App\Events\ReservationRequest\CreatedEvent;
use App\Models\User;
use App\Notifications\ReservationRequest\CreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreatedListener
{
    public function __construct()
    {}

    public function handle(CreatedEvent $event): void
    {
        /** @var User $owner */
        $owner = $event->reservationRequest->apartment->user;

        $owner->notify(new CreatedNotification($event->reservationRequest));
    }
}

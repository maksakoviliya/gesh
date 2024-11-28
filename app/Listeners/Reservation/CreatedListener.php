<?php

declare(strict_types=1);

namespace App\Listeners\Reservation;

use App\Events\Reservation\CreatedEvent;
use App\Notifications\Reservation\CreatedNotification;

final class CreatedListener
{
    public function __construct() {}

    public function handle(CreatedEvent $event): void
    {
        /** @var User $user */
        $user = $event->reservation->user;

        $user->notify(new CreatedNotification($event->reservation));
    }
}

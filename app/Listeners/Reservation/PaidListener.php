<?php

declare(strict_types=1);

namespace App\Listeners\Reservation;

use App\Events\Reservation\PaidEvent;
use App\Notifications\Reservation\OwnerReservationPaidNotification;
use App\Notifications\Reservation\UserReservationPaidNotification;

final class PaidListener
{
    public function __construct() {}

    public function handle(PaidEvent $event): void
    {
        $user = $event->reservation->user;
        $owner = $event->reservation->apartment->user;

        $user->notify(new UserReservationPaidNotification($event->reservation));
        $owner->notify(new OwnerReservationPaidNotification($event->reservation));
    }
}

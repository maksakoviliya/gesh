<?php

declare(strict_types=1);

namespace App\Events\Reservation;

use App\Models\Reservation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class CreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Reservation $reservation)
    {}
}

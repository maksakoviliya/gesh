<?php

declare(strict_types=1);

namespace App\Events\ReservationRequest;

use App\Models\ReservationRequest;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class CreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public ReservationRequest $reservationRequest) {}
}

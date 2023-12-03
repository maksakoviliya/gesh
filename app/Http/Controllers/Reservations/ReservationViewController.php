<?php

declare(strict_types=1);

namespace App\Http\Controllers\Reservations;

use App\Enums\Reservation\Status;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class ReservationViewController extends Controller
{
    public function __invoke(Request $request, Reservation $reservation): Response
    {
        $page = 'Reservations/Reservation';
        if ($reservation->status === Status::Pending->value) {
            $page = 'Reservations/Payment';
        }
        return Inertia::render($page, [
            'reservation' => new ReservationResource($reservation)
        ]);
    }
}

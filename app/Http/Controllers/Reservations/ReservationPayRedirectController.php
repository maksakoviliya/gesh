<?php

declare(strict_types=1);

namespace App\Http\Controllers\Reservations;

use App\Enums\Reservation\Status;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

final class ReservationPayRedirectController extends Controller
{
    public function __invoke(Request $request, Reservation $reservation): Response
    {
        if ($reservation->status === Status::Pending) {
            $reservation->setStatus(Status::PaymentWaiting);
        }

        return Inertia::location(route('account.reservations.view', [
            'reservation' => $reservation->id,
        ]));
    }
}

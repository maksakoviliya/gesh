<?php

declare(strict_types=1);

namespace App\Http\Controllers\Reservations;

use App\Enums\Reservation\Status;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Services\PaymentServiceContract;
use Error;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

final class ReservationPayController extends Controller
{
    public function __invoke(Request $request, Reservation $reservation, PaymentServiceContract $paymentService): Response
    {
        $redirectUrl = $paymentService->createPayment(
            $reservation->getFirstPaymentAmount(),
            route('account.reservations.view', [
                'reservation' => $reservation->id,
            ]),
            "Бронирование #{$reservation->id}. C {$reservation->start->format('d.m.Y')} по {$reservation->end->format('d.m.Y')}"
            );

        if (! $redirectUrl) {
            throw new Error('PaymentService Error');
        }

        $reservation->setStatus(Status::FirstPayment);

        return Inertia::location($redirectUrl);
    }
}

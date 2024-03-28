<?php

declare(strict_types=1);

namespace App\Http\Controllers\Reservations;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
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
            $reservation->first_payment,
            route('account.reservations.pay.redirect', [
                'reservation' => $reservation->id,
            ]),
            $reservation
        );

        if (! $redirectUrl) {
            throw new Error('PaymentService Error');
        }

        return Inertia::location($redirectUrl);
    }
}

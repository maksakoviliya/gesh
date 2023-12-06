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
        $transaction = Transaction::createForReservation($reservation);

        $redirectUrl = $paymentService->createPayment($reservation->price, [
            'reservation_id' => $reservation->id,
            'transaction_id' => $transaction->id,
        ]);

        if (!$redirectUrl) {
            throw new Error('PaymentService Error');
        }

        $reservation->setStatus(Status::Paid);

        return Inertia::location($redirectUrl);
    }
}

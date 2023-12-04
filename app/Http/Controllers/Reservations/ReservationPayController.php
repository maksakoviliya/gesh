<?php

declare(strict_types=1);

namespace App\Http\Controllers\Reservations;

use App\Enums\Reservation\Status;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Transaction;
use Illuminate\Http\Request;

final class ReservationPayController extends Controller
{
    public function __invoke(Request $request, Reservation $reservation)
    {
        $transaction = Transaction::createForReservation($reservation);
        if ($transaction->amount >= $reservation->price) {
            $reservation->setStatus(Status::Paid);
        }
        return redirect()->route('account.reservations.view', [
            'reservation' => $reservation->id
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

final class ReservationVoucherController extends Controller
{
    public function __invoke(Request $request, Reservation $reservation)
    {
        $price = $reservation->price;
        $commission = $reservation::getCommission($price);
        $total = $price + $commission;
        $first_payment = ceil(($total) * 0.3);
        $remainder = $total - $first_payment;
        $data = [
                'id' => $reservation->id,
                'date' => $reservation->created_at->locale('ru')->translatedFormat('d F Y'),
                'user' => [
                    'name' => $reservation->user->name,
                    'email' => $reservation->user->email,
                    'phone' => $reservation->user->phone,
                ],
                'dates' => $reservation->start->locale('ru')->translatedFormat('d F Y') . ' - ' . $reservation->end->locale('ru')->translatedFormat('d F Y'),
                'range' => trans_choice('nights', $reservation->range, ['count' => $reservation->range]),
                'price' => \Number::currency($total, 'RUB', 'ru'),
                'first_payment' => \Number::currency($first_payment, 'RUB', 'ru'),
                'remainder' => \Number::currency($remainder, 'RUB', 'ru'),
        ];
        $pdf = Pdf::loadView('pdfs.voucher', compact('data'));
        return $pdf->stream('voucher.pdf');
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\VoucherRequest;
use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

final class ReservationVoucherController extends Controller
{
    public function __invoke(VoucherRequest $request, Reservation $reservation)
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
            'apartment' => [
                'address' => $reservation->apartment->full_address,
                'user' => [
                    'name' => $reservation->apartment->user->name,
                    'email' => $reservation->apartment->user->email,
                    'phone' => $reservation->apartment->user->phone,
                ]
            ],
            'dates' => 'c ' . $reservation->start->locale('ru')->translatedFormat('d F Y').' 15:00 по '.$reservation->end->locale('ru')->translatedFormat('d F Y') . ' 12:00',
            'range' => trans_choice('nights', $reservation->range, ['count' => $reservation->range]),
            'price' => \Number::currency($total, 'RUB', 'ru'),
            'guests' =>[
                'total_guests' => $reservation->total_guests,
                'guests' => $reservation->guests,
                'children' => $reservation->children,
            ],
            'first_payment' => \Number::currency($first_payment, 'RUB', 'ru'),
            'remainder' => \Number::currency($remainder, 'RUB', 'ru'),
        ];
        $pdf = Pdf::loadView('pdfs.voucher', compact('data'));

        return $pdf->stream('voucher.pdf');
    }
}

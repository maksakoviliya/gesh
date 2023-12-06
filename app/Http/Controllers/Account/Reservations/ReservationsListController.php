<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Reservations;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

final class ReservationsListController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $reservations = Reservation::query()
            ->where('user_id', Auth::id())
            ->get();

        return Inertia::render('Account/Reservations/List', [
            'reservations' => ReservationResource::collection($reservations),
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\ReservationRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest\SubmitRequest;
use App\Models\Reservation;
use App\Models\ReservationRequest;
use Illuminate\Http\JsonResponse;

final class ReservationRequestSubmitController extends Controller
{
    public function __invoke(SubmitRequest $request, ReservationRequest $reservationRequest): JsonResponse
    {
        $reservation = Reservation::createFromReservationRequest($reservationRequest);

        $reservationRequest->submit($reservation);
        /** @var ReservationRequest $reservationRequest */
        $reservationRequest = ReservationRequest::query()
            ->find($reservationRequest->id);

        return response()->json([
            'success' => true,
            'status' => $reservationRequest->status,
        ], 201);
    }
}

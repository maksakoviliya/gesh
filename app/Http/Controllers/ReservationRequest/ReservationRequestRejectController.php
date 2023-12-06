<?php

declare(strict_types=1);

namespace App\Http\Controllers\ReservationRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest\RejectRequest;
use App\Models\ReservationRequest;

final class ReservationRequestRejectController extends Controller
{
    public function __invoke(RejectRequest $request, ReservationRequest $reservationRequest)
    {
        $reservationRequest->reject($request->validated('status_text'));
        $reservationRequest = ReservationRequest::query()->find($reservationRequest->id);

        return response()->json([
            'success' => true,
            'status' => $reservationRequest->status,
            'status_text' => $reservationRequest->status_text,
        ], 201);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\ReservationRequest;

use App\Events\ReservationRequest\CreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest\StoreRequest;
use App\Models\Apartment;
use App\Models\ReservationRequest;
use Illuminate\Http\RedirectResponse;

final class ReservationRequestStoreController extends Controller
{
    public function __invoke(StoreRequest $request, Apartment $apartment): RedirectResponse
    {
        $reservation_request = ReservationRequest::createFromArray($request->validated(), $apartment);

        CreatedEvent::dispatch($reservation_request);

        return to_route('account.apartments.chat', [
            'apartment' => $apartment->id,
        ]);
    }
}

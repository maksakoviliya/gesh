<?php

declare(strict_types=1);

namespace App\Http\Controllers\ReservationRequest;

use App\Events\ReservationRequest\CreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest\StoreRequest;
use App\Models\Apartment;
use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use App\Models\ReservationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

final class ReservationRequestStoreController extends Controller
{
    public function __invoke(StoreRequest $request, Apartment $apartment): RedirectResponse
    {
        $chat = Chat::query()
            ->firstOrCreate([
                'apartment_id' => $apartment->id,
                'user_id' => Auth::id(),
            ]);
        $reservation_request = ReservationRequest::createFromArray($request->validated(), $apartment);
        Message::query()->firstOrCreate([
            'chat_id' => $chat->id,
            'user_id' => Auth::id(),
            'reservation_request_id' => $reservation_request->id,
        ]);

        CreatedEvent::dispatch($reservation_request);

        return to_route('account.apartments.chat', [
            'apartment' => $apartment->id,
        ]);
    }
}

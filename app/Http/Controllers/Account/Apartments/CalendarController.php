<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApartmentResource;
use App\Models\Apartment;
use App\Models\Reservation;
use App\Models\ReservationRequest;
use App\Models\SideReservation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class CalendarController extends Controller
{
    public function __invoke(Request $request, Apartment $apartment): Response
    {
        $apartment = $apartment->load([
            'datePrices',
            'ICalLinks',
        ]);
        $reservationRequests = collect(ReservationRequest::query()
            ->where('apartment_id', $apartment->id)
            ->whereNull('reservation_id')
            ->get()
            ->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => 'Запрос',
                    'start' => $item->start,
                    'end' => $item->end,
                    'allDay' => true,
                    'className' => 'bg-red-200 border-red-200 px-2',
                ];
            }));
        $reservations = collect(Reservation::query()
            ->where('apartment_id', $apartment->id)
            ->get()
            ->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => 'Резерв',
                    'start' => $item->start,
                    'end' => $item->end,
                    'allDay' => true,
                    'className' => 'bg-blue-500 border-green-200 px-2',
                ];
            }));
        $side_reservations = collect(SideReservation::query()
            ->where('apartment_id', $apartment->id)
            ->get()
            ->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->summary,
                    'start' => $item->start,
                    'end' => $item->end,
                    'allDay' => true,
                    'className' => 'bg-yellow-500 border-yellow-200 px-2 opacity-80 hover:opacity-100',
                ];
            }));
        $events = $reservationRequests->merge($reservations);
        $events = $events->merge($side_reservations);

        return Inertia::render('Account/Apartments/Calendar', [
            'apartment' => new ApartmentResource($apartment),
            'events' => $events,
        ]);
    }
}

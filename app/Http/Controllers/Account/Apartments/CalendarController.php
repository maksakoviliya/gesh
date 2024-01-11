<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApartmentResource;
use App\Models\Apartment;
use App\Models\DisabledDate;
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
            'disabledDates',
        ]);
        $reservationRequests = collect(ReservationRequest::query()
            ->with(['user', 'apartment'])
            ->where('apartment_id', $apartment->id)
            ->whereNull('reservation_id')
            ->get()
            ->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => 'Запрос',
                    'start' => $item->start->format('d.m.Y'),
                    'end' => $item->end->addDay()->format('d.m.Y'),
                    'type' => ReservationRequest::class,
                    'allDay' => true,
                    'className' => 'reservation_request_event',
                    'data' => [
                        'reservation_request' => $item,
                    ],
                ];
            }));
        $reservations = collect(Reservation::query()
            ->where('apartment_id', $apartment->id)
            ->get()
            ->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => 'Резерв',
                    'start' => $item->start->format('d.m.Y'),
                    'type' => Reservation::class,
                    'end' => $item->end->addDay()->format('d.m.Y'),
                    'allDay' => true,
                    'className' => 'reservation_event',
                    'data' => [
                        'reservation' => $item,
                    ],
                ];
            }));
        $side_reservations = collect(SideReservation::query()
            ->where('apartment_id', $apartment->id)
            ->get()
            ->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->summary,
                    'start' => $item->start->format('d.m.Y'),
                    'type' => SideReservation::class,
                    'end' => $item->end->addDay()->format('d.m.Y'),
                    'allDay' => true,
                    'className' => 'side_reservation_event',
                    'data' => [
                        'side_reservation' => $item,
                    ],
                ];
            }));
        $disabled_dates = collect(DisabledDate::query()
            ->where('apartment_id', $apartment->id)
            ->get()
            ->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'start' => $item->date->format('d.m.Y'),
                    'end' => $item->date->format('d.m.Y'),
                    'type' => DisabledDate::class,
                    'allDay' => true,
                    'display' => 'background',
                    'className' => 'disabled_date_event',
                ];
            }));
        $events = $reservationRequests->merge($reservations);
        $events = $events->merge($side_reservations);
        $events = $events->merge($disabled_dates);

        return Inertia::render('Account/Apartments/Calendar', [
            'apartment' => new ApartmentResource($apartment),
            'eventsData' => $events,
        ]);
    }
}

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
            'disabledDates'
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
                    'start' => $item->start->setTime(15, 0),
                    'end' => $item->end->setTime(12, 0),
                    'type' => ReservationRequest::class,
                    'allDay' => true,
                    'className' => 'bg-red-200 border-red-200 px-2',
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
                    'start' => $item->start->setTime(15, 0),
                    'type' => Reservation::class,
                    'end' => $item->end->setTime(12, 0),
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
                    'start' => $item->start->setTime(15, 0),
                    'type' => SideReservation::class,
                    'end' => $item->end->setTime(12, 0),
                    'allDay' => true,
                    'className' => 'side_reservation_event',
                ];
            }));
        $disabled_dates = collect(DisabledDate::query()
            ->where('apartment_id', $apartment->id)
            ->get()
            ->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'start' => $item->date,
                    'end' => $item->date,
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

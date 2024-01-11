<?php

namespace App\Filament\Resources\ApartmentResource\Widgets;

use App\Models\DisabledDate;
use App\Models\Reservation;
use App\Models\ReservationRequest;
use App\Models\SideReservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public string|int|null|Model $record = null;

    /**
     * FullCalendar will call this function whenever it needs new event data.
     * This is triggered when the user clicks prev/next or switches views on the calendar.
     */
    public function fetchEvents(array $fetchInfo): array
    {
        return [];
        $apartment = $this->record;
        $reservationRequests = collect(ReservationRequest::query()
            ->with(['user', 'apartment'])
            ->where('apartment_id', $apartment->id)
            ->whereNull('reservation_id')
            ->get()
            ->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => 'Запрос',
                    'start' => $item->start->setTime(15, 0)->format('d.m.Y'),
                    'end' => $item->end->setTime(12, 0)->format('d.m.Y'),
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
                    'start' => $item->start->setTime(15, 0)->format('d.m.Y'),
                    'type' => Reservation::class,
                    'end' => $item->end->setTime(12, 0)->format('d.m.Y'),
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
                    'start' => $item->start->setTime(15, 0)->format('d.m.Y'),
                    'type' => SideReservation::class,
                    'end' => $item->end->setTime(12, 0)->format('d.m.Y'),
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
        $events = $events->map(fn ($event) => EventData::make()
            ->id($event['id'])
            ->title($event['id'])
            ->allDay()
            ->start(Carbon::now())
            ->end(Carbon::now()->addDays(3))
        )
            ->all();

        return $events;
    }
}

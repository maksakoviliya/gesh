<?php

namespace App\Filament\Resources\NoResource\Widgets;

use App\Models\Apartment;
use App\Models\Reservation;
use App\Models\ReservationRequest;
use Carbon\Carbon;
use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ApartmentsChart extends ChartWidget
{
    protected static ?string $heading = 'Жилье';

    protected int|string|array $columnSpan = 2;

    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $data = Trend::model(Apartment::class)
            ->between(
                start: now()->startOfMonth(),
                end: now(),
            )
            ->perDay()
            ->count();
        $total = Apartment::query()
            ->where('created_at', '<=', now()->startOfMonth())
        ->count();

        $reservation_requests_data = Trend::model(ReservationRequest::class)
            ->between(
                start: now()->startOfMonth(),
                end: now(),
            )
            ->perDay()
            ->count();
        $color = Color::Blue[500];

        $reservations_data = Trend::model(Reservation::class)
            ->between(
                start: now()->startOfMonth(),
                end: now(),
            )
            ->perDay()
            ->count();
        $reservation_color = Color::Green[500];

        return [
            'datasets' => [
                [
                    'label' => 'Жилье',

                    'data' => $data->map(function (TrendValue $value) use (&$total) {
                        $total += $value->aggregate;

                        return $total;
                    }),
                ],
                [
                    'label' => 'Запросы на бронирование',

                    'data' => $reservation_requests_data->map(function (TrendValue $value) {
                        return $value->aggregate;
                    }),
                    'backgroundColor' => "rgb($color)",
                    'borderColor' => "rgb($color)",
                ],
                [
                    'label' => 'Бронирования',

                    'data' => $reservations_data->map(function (TrendValue $value) {
                        return $value->aggregate;
                    }),
                    'backgroundColor' => "rgb($reservation_color)",
                    'borderColor' => "rgb($reservation_color)",
                ],
            ],
            'labels' => $reservation_requests_data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('d.m.Y')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

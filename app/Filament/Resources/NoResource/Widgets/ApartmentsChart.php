<?php

namespace App\Filament\Resources\NoResource\Widgets;

use App\Models\Apartment;
use Carbon\Carbon;
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
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count();
        $total = 0;

        return [
            'datasets' => [
                [
                    'label' => 'Жилье',
                    'data' => $data->map(function (TrendValue $value) use (&$total) {
                        $total += $value->aggregate;

                        return $total;
                    }),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('d.m.Y')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

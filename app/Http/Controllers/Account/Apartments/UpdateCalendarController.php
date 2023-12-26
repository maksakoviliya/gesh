<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Apartments\UpdateCalendarRequest;
use App\Models\Apartment;
use App\Models\DatePrice;
use App\Models\DisabledDate;
use Carbon\CarbonPeriod;

final class UpdateCalendarController extends Controller
{
    public function __invoke(UpdateCalendarRequest $request, Apartment $apartment)
    {
        $period = CarbonPeriod::create(
            $request->validated('start'),
            $request->validated('end'),
        );

        foreach ($period as $date) {
            if ($request->validated('price')) {
                DatePrice::query()->updateOrCreate([
                    'apartment_id' => $apartment->id,
                    'date' => $date,
                ], [
                    'price' => $request->validated('price'),
                ]);
            }
            if ($request->validated('disabled') === false) {
                DisabledDate::query()->whereDate('date', $date)->delete();
            } elseif ($request->validated('disabled') === true) {
                DisabledDate::query()->updateOrCreate([
                    'apartment_id' => $apartment->id,
                    'date' => $date->setTime(15,0),
                ]);
            }
        }

        return to_route('account.apartments.calendar', [
            'apartment' => $apartment,
        ]);
    }
}

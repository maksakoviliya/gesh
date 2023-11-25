<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Apartments\UpdateCalendarRequest;
use App\Models\Apartment;
use App\Models\DatePrice;
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
            DatePrice::query()->updateOrCreate([
                'apartment_id' => $apartment->id,
                'date' => $date], [
                'price' => $request->validated('price')
            ]);
        }
        return to_route('account.apartments.calendar', [
            'apartment' => $apartment
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Apartments\UpdatePriceRequest;
use App\Models\Apartment;

final class UpdatePriceController extends Controller
{
    public function __invoke(UpdatePriceRequest $request, Apartment $apartment)
    {
        $apartment->update([
            "weekdays_price" => $request->validated('weekdays_price'),
            "weekends_price" => $request->validated('weekends_price')
        ]);
        return to_route('account.apartments.calendar', [
            'apartment' => $apartment
        ]);
    }
}

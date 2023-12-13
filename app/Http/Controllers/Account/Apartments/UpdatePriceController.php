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
            'weekdays_price' => $request->validated('weekdays_price'),
            'weekends_price' => $request->validated('weekends_price'),
        ]);

        // TODO: Возможно есть решение красивее
        $apartment->ICalLinks()->delete();
        $links = [];
        foreach ($request->validated('i_cal_links') as $item) {
            $links[] = ['link' => \Arr::get($item, 'link')];
        }
        $apartment->ICalLinks()->createMany($links);
        $apartment->load('ICalLinks');

        return to_route('account.apartments.calendar', [
            'apartment' => $apartment,
        ]);
    }
}

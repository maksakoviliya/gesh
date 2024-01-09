<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Apartments\UpdatePriceRequest;
use App\Models\Apartment;
use Illuminate\Support\Facades\Artisan;

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
        $links = collect($request->validated('i_cal_links'))
            ->map(fn($item) => ['link' => $item['link']])
            ->unique('link')
            ->values()
            ->toArray();
        $apartment->ICalLinks()->createMany($links);

        Artisan::call('sync-calendars', [
            'apartment_id' => $apartment->id,
        ]);

        $apartment = Apartment::query()
            ->with(['ICalLinks', 'reservations'])
            ->find($apartment->id);

        return to_route('account.apartments.calendar', [
            'apartment' => $apartment,
        ]);
    }
}

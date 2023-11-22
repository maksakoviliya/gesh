<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Apartments\StoreRequest;
use App\Models\Apartment;
use Illuminate\Http\RedirectResponse;

final class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, Apartment $apartment): RedirectResponse
    {
        $apartment = $apartment->updateFromArray($request->validated());

        return redirect(route('account.apartments.step', [
            'apartment' => $apartment->id,
            'step' => $apartment->step,
        ]));
    }
}

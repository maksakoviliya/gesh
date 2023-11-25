<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApartmentResource;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class CalendarController extends Controller
{
    public function __invoke(Request $request, Apartment $apartment): Response
    {
        $apartment = $apartment->load('datePrices');
        return Inertia::render('Account/Apartments/Calendar', [
            'apartment' => new ApartmentResource($apartment)
        ]);
    }
}

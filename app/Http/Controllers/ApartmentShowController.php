<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ApartmentResource;
use App\Models\Apartment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class ApartmentShowController extends Controller
{
    public function __invoke(Request $request, Apartment $apartment): Response
    {
        $apartment = $apartment->load([
            'user',
            'datePrices' => function ($query) {
                $query->whereDate('date', '>=', Carbon::now());
            },
            'disabledDates' => function ($query) {
                $query->whereDate('date', '>=', Carbon::now());
            }
        ]);
        return Inertia::render('Apartment', [
            'apartment' => new ApartmentResource($apartment),
        ]);
    }
}

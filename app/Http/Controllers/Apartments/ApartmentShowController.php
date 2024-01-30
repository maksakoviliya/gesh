<?php

declare(strict_types=1);

namespace App\Http\Controllers\Apartments;

use App\Enums\Apartments\Status;
use App\Http\Controllers\Controller;
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
        if ($apartment->status !== Status::Published) {
            abort(404);
        }

        $apartment = $apartment->load([
            'user',
            'ICalLinks',
            'datePrices' => function ($query) {
                $query->whereDate('date', '>=', Carbon::now());
            },
        ]);

        $apartment = $apartment->append('allDisabledDays');

        return Inertia::render('Apartment', [
            'apartment' => new ApartmentResource($apartment),
            'hasICalLinks' => count($apartment->ICalLinks) > 0,
        ]);
    }
}

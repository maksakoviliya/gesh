<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApartmentResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class ListController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $apartments = $request->user()->apartments()->withCount('reservationRequests')->get();

        return Inertia::render('Account/Apartments/List', [
            'apartments' => ApartmentResource::collection($apartments),
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApartmentResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class AccountApartmentsController extends Controller
{
    public function __invoke(Request $request)
    {
        $apartments = $request->user()->apartments;
        return Inertia::render('Account/Apartments/Apartments', [
            'apartments' => ApartmentResource::collection($apartments)
        ]);
    }
}

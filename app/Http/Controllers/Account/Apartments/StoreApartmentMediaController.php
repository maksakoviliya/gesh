<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

final class StoreApartmentMediaController extends Controller
{
    public function __invoke(Request $request, Apartment $apartment)
    {
        $image = $apartment->addMediaFromRequest('image')
            ->toMediaCollection('temp');

        return response($image->uuid)
            ->header('Content-Type', 'text/plain');
    }
}

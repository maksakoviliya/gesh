<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

final class StoreApartmentMediaController extends Controller
{
    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function __invoke(Request $request, Apartment $apartment): \Illuminate\Foundation\Application|Response|Application|ResponseFactory
    {
        $image = $apartment->addMediaFromRequest('image')
            ->toMediaCollection('temp');

        return response($image->uuid)
            ->header('Content-Type', 'text/plain');
    }
}

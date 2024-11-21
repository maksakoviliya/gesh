<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

final class StoreApartmentMediaController extends Controller
{
    /**
 * @throws FileDoesNotExist
 * @throws FileIsTooBig
 */
    public function __invoke(Request $request, Apartment $apartment): RedirectResponse
    {
        $images = [];
        $apartment->addMultipleMediaFromRequest(['files'])
            ->each( function (FileAdder $fileAdder) use (&$images) {
                $media = $fileAdder->toMediaCollection();
                $images[] = [
                    'url' => $media->getUrl(),
                    'uuid' => $media->getKey()
                ];
            });

        return back();
    }
}

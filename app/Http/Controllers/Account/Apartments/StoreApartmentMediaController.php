<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Apartments\Media\StoreRequest as StoreMediaRequest;
use App\Models\Apartment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

final class StoreApartmentMediaController extends Controller
{
    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function __invoke(StoreMediaRequest $request, Apartment $apartment): RedirectResponse
    {
        $images = [];
        $apartment->addMultipleMediaFromRequest(['files'])
            ->each(function (FileAdder $fileAdder) use (&$images) {
                $media = $fileAdder->toMediaCollection();
                $images[] = [
                    'url' => $media->getUrl(),
                    'uuid' => $media->getKey(),
                ];
            });

        return back();
    }
}

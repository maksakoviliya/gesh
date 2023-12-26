<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Apartments\Media\RemoveApartmentMediaRequest;
use App\Models\Apartment;
use Illuminate\Http\JsonResponse;

final class RemoveApartmentMediaController extends Controller
{
    public function __invoke(RemoveApartmentMediaRequest $request, Apartment $apartment): JsonResponse
    {
        $image = $apartment->media()->where('uuid', $request->validated('id'))->first();
        //        dd($image);
        $image->delete();

        return response()->json([
            'success' => 'Image successfully removed!',
        ]);
    }
}

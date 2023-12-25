<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class GetMediaController extends Controller
{
    public function __invoke(Request $request, string $id)
    {
        /** @var Media $media */
        $media = Media::query()
            ->where('uuid', $id)
            ->first();

        return $media->toResponse($request);
    }
}

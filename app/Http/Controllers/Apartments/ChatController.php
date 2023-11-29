<?php

declare(strict_types=1);

namespace App\Http\Controllers\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApartmentResource;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class ChatController extends Controller
{
    public function __invoke(Request $request, Apartment $apartment): Response
    {
        return Inertia::render('Apartments/Chat', [
            'apartment' => new ApartmentResource($apartment)
        ]);
    }
}

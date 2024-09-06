<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ApartmentResource;
use App\Http\Resources\CategoryResource;
use App\Models\Apartment;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class HomeMapController extends Controller
{
    public function __invoke(Request $request)
    {
        $categories = Category::all();
        $apartments = Apartment::query()
            ->published()
            ->filter($request)
            ->orderBy('updated_at')
            ->get();

        return Inertia::render('MapList', [
            'categories' => CategoryResource::collection($categories),
            'apartments' => ApartmentResource::collection($apartments),
        ]);
    }
}

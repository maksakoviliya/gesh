<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ApartmentCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Apartment;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

final class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $categories = Category::all();
        $apartments = Apartment::query()
            ->with('reservations')
            ->published()
            ->filter($request)
            ->orderBy('updated_at')
            ->paginate(24)
            ->withQueryString();

        return Inertia::render('Home', [
            'categories' => CategoryResource::collection($categories),
            'apartments' => new ApartmentCollection($apartments),
        ]);
    }
}

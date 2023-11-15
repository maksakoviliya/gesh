<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ApartmentResource;
use App\Http\Resources\CategoryResource;
use App\Models\Apartment;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class HomeController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $categories = Category::all();
        $apartments = Apartment::query()
            ->filter($request)
            ->orderBy('updated_at')
            ->paginate(20);

        return Inertia::render('Home', [
            'categories' => CategoryResource::collection($categories),
            'apartments' => ApartmentResource::collection($apartments),
        ]);
    }
}

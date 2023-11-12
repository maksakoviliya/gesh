<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class HomeController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $categories = Category::all();

        return Inertia::render('Home', [
            'categories' => CategoryResource::collection($categories)
        ]);
    }
}

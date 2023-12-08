<?php

declare(strict_types=1);

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SearchCityController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $cities = [];
        if ($request->input('query')) {
            $cities = Apartment::query()
                ->select('city')
                ->where('city', 'like', "%{$request->input('query')}%")
                ->distinct()
                ->limit(10)
                ->pluck('city');
        }
        return response()->json([
            'data' => $cities
        ]);
    }
}

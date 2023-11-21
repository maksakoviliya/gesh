<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Apartment;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class StepController extends Controller
{
    public function __invoke(Request $request, Apartment $apartment, int $step): Response|RedirectResponse
    {
        return match ($step) {
            1 => Inertia::render('Account/Apartments/Steps/Step1', [
                'categories' => CategoryResource::collection(Category::all()),
                'apartment' => $apartment,
            ]),
            2 => Inertia::render('Account/Apartments/Steps/Step2', [
                'types' => Apartment::getTypes(),
                'apartment' => $apartment,
            ]),
            3 => Inertia::render('Account/Apartments/Steps/Step3', [
                'apartment' => $apartment,
            ]),
            4 => Inertia::render('Account/Apartments/Steps/Step4', [
                'apartment' => $apartment,
            ]),
            5 => Inertia::render('Account/Apartments/Steps/Step5', [
                'apartment' => $apartment,
            ]),
            6 => Inertia::render('Account/Apartments/Steps/Step6', [
                'apartment' => $apartment,
            ]),
            default => redirect()->route('account.apartments.list'),
        };
    }
}

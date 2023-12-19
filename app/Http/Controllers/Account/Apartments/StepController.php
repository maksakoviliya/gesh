<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApartmentResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\FeatureResource;
use App\Models\Apartment;
use App\Models\Category;
use App\Models\Feature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class StepController extends Controller
{
    public function __invoke(Request $request, Apartment $apartment, int $step): Response|RedirectResponse
    {
        $this->authorize('view', $apartment);

        $apartment = new ApartmentResource($apartment->load('features'));

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
                'features' => FeatureResource::collection(Feature::query()
                    ->orderBy('order')->get()),
                'apartment' => $apartment,
            ]),
            7 => Inertia::render('Account/Apartments/Steps/Step7', [
                'apartment' => $apartment,
            ]),
            8 => Inertia::render('Account/Apartments/Steps/Step8', [
                'apartment' => $apartment,
            ]),
            9 => Inertia::render('Account/Apartments/Steps/Step9', [
                'apartment' => $apartment,
            ]),
            10 => Inertia::render('Account/Apartments/Steps/Step10', [
                'apartment' => $apartment,
            ]),
            11 => Inertia::render('Account/Apartments/Steps/Step11', [
                'apartment' => $apartment,
            ]),
            12 => Inertia::render('Account/Apartments/Steps/Step12', [
                'apartment' => $apartment,
            ]),
            13 => Inertia::render('Account/Apartments/Steps/Step13', [
                'apartment' => $apartment,
            ]),
            default => redirect()->route('account.apartments.list'),
        };
    }
}

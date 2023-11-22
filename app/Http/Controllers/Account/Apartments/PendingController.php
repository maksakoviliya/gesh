<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class PendingController extends Controller
{
    public function __invoke(Request $request, Apartment $apartment): Response
    {
        return Inertia::render('Account/Apartments/Pending', [
            'apartment' => $apartment,
        ]);
    }
}

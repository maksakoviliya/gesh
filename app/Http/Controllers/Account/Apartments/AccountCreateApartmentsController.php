<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class AccountCreateApartmentsController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Account/Apartments/Create');
    }
}

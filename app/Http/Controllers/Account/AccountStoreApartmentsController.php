<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Apartments\StoreRequest;
use App\Models\Apartment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class AccountStoreApartmentsController extends Controller
{
    public function __invoke(StoreRequest $request): RedirectResponse
    {
        Apartment::query()->create($request->validated());
        return redirect(route('account.apartments'));
    }
}

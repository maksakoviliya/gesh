<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class CreateController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $apartment = Apartment::createDraft($user);

        return to_route('account.apartments.step', [
            'apartment' => $apartment,
            'step' => 1,
        ]);
    }
}

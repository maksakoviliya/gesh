<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class AccountProfileController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $user = Auth::user();

        return Inertia::render('Account/Profile', [
            'user' => new UserResource($user, true),
        ]);
    }
}

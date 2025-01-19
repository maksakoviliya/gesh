<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Profile\UpdateRequest;
use Auth;
use Illuminate\Http\RedirectResponse;

final class AccountProfileUpdateController extends Controller
{
    public function __invoke(UpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->updateFromArray($request->validated());

        return redirect()->back()->with('success', 'Данные профиля успешно обновлены!');
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Profile\UpdateRequest;
use Auth;

final class AccountProfileUpdateController extends Controller
{
    public function __invoke(UpdateRequest $request)
    {
        $user = Auth::user();
        $user->updateFromArray($request->validated());

        return redirect()->back()->with('success', 'Данные профиля успешно обновлены!');
    }
}

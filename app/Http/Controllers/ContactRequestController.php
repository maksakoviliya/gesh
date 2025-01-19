<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\ContactRequest\ContactRequestStoreAction;
use App\Http\Requests\ContactRequest\StoreContactRequestRequest;
use Illuminate\Http\RedirectResponse;

final class ContactRequestController extends Controller
{
    public function store(
        StoreContactRequestRequest $request,
        ContactRequestStoreAction $action
    ): RedirectResponse {
        $action->run($request->validated());

        return redirect()->back();
    }
}

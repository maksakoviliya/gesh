<?php

declare(strict_types=1);

namespace App\Http\Controllers\Chat\Messages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\Messages\StoreRequest;
use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use Illuminate\Http\RedirectResponse;

final class MessageStoreController extends Controller
{
    public function __invoke(StoreRequest $request, Chat $chat): RedirectResponse
    {
        Message::createFromArray($request->validated());

        return back();
    }
}

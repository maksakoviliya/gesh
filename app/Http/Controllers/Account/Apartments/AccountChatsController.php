<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatResource;
use App\Models\Apartment;
use App\Models\Chat\Chat;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class AccountChatsController extends Controller
{
    public function __invoke(Request $request, Apartment $apartment): Response
    {
        $chats = Chat::with('last_message')
            ->where('apartment_id', $apartment->id)
            ->get()
            ->sortByDesc('last_message.created_at');

        return Inertia::render('Account/Apartments/Owner/OwnerChat', [
            'chats' => ChatResource::collection($chats),
        ]);
    }
}

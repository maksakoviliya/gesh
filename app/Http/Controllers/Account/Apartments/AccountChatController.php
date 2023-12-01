<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatResource;
use App\Http\Resources\Chat\MessageResource;
use App\Models\Apartment;
use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class AccountChatController extends Controller
{
    public function __invoke(Request $request, Apartment $apartment, Chat $chat): Response
    {
        $chats = Chat::with('last_message')
            ->where('apartment_id', $apartment->id)
            ->get()
            ->sortByDesc('last_message.created_at')
        ;
        $messages = Message::query()
            ->where('chat_id', $chat->id)
            ->paginate(100);
        return Inertia::render('Account/Apartments/Chat', [
            'chats' => ChatResource::collection($chats),
            'chat' => new ChatResource($chat),
            'messages' =>  MessageResource::collection($messages)
        ]);
    }
}

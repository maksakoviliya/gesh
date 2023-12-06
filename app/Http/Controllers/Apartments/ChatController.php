<?php

declare(strict_types=1);

namespace App\Http\Controllers\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApartmentResource;
use App\Http\Resources\Chat\ChatResource;
use App\Http\Resources\Chat\MessageResource;
use App\Models\Apartment;
use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

final class ChatController extends Controller
{
    public function __invoke(Request $request, Apartment $apartment): Response
    {
        $chat = Chat::query()
            ->firstOrCreate([
                'apartment_id' => $apartment->id,
                'user_id' => Auth::id(),
            ]);
        $messages = Message::query()
            ->with(['reservation_request', 'reservation_request.reservation'])
            ->where('chat_id', $chat->id)
            ->paginate(100);

        return Inertia::render('Apartments/Chat', [
            'chat' => new ChatResource($chat),
            'apartment' => new ApartmentResource($apartment),
            'messages' => MessageResource::collection($messages),
        ]);
    }
}

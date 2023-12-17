<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Chat\Message;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class HasUnreadNotificationsController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $user = Auth::user()->load('unreadNotifications');
//        $unread_messages = Message::query()
//            ->where('user_id', $user->id)
//            ->whereNull('read_at')
//            ->count();
        return response()
            ->json([
//                'unread_messages_count' => $unread_messages,
                'unread_notifications_count' => $user->unreadNotifications()->count()
            ]);
    }
}

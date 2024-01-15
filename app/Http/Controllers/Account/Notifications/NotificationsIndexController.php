<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class NotificationsIndexController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $type = $request->query('type');
        if ($type === 'unread') {
            $notifications = Auth::user()->unreadNotifications();
        } else {
            $notifications = Auth::user()->notifications();
        }
        $notifications = $notifications
            ->latest()
            ->paginate($request->query('per_page', 20))
            ->withQueryString();

        //dd(NotificationResource::collection($notifications));
        return Inertia::render('Account/Notifications/Index', [
            'notifications' => fn () => NotificationResource::collection($notifications),
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

final class NotificationsReadController extends Controller
{
    public function __invoke(Request $request, DatabaseNotification $notification): RedirectResponse
    {
        $notification->markAsRead();

        return redirect()->route('account.notifications.index');
    }
}

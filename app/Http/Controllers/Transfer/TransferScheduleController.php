<?php

declare(strict_types=1);

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transfer\ScheduleRequest;
use App\Models\User;
use App\Notifications\Admin\Transfer\ScheduleNotification;
use Illuminate\Support\Facades\Notification;

final class TransferScheduleController extends Controller
{
    public function __invoke(ScheduleRequest $request)
    {
        $admins = User::query()->role('admin')->get();
        Notification::send($admins, new ScheduleNotification(
            $request->validated('name'),
            $request->validated('phone')
        ));

        return back();
    }
}

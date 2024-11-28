<?php

declare(strict_types=1);

namespace App\Http\Controllers\Instructors;

use App\Actions\TelegramNotifications\SendMessageToAdminGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\Instructors\ScheduleRequest;
use App\Models\Instructor;
use App\Models\User;
use App\Notifications\Admin\Instructors\ScheduleNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;

final class InstructorsScheduleController extends Controller
{
    protected SendMessageToAdminGroup $telegram;

    public function __construct()
    {
        $this->telegram = new SendMessageToAdminGroup;
    }

    public function __invoke(ScheduleRequest $request, Instructor $instructor): RedirectResponse
    {
        $admins = User::query()->role('admin')->get();

        Notification::send($admins, new ScheduleNotification(
            $instructor,
            $request->validated('name'),
            $request->validated('phone')
        ));

        $this->telegram->sendNewInstructorRequestMessage(
            $instructor,
            $request->validated('name'),
            $request->validated('phone')
        );

        return back();
    }
}

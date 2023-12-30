<?php

declare(strict_types=1);

namespace App\Http\Controllers\Instructors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instructors\ScheduleRequest;
use App\Models\Instructor;
use App\Models\User;
use App\Notifications\Admin\Instructors\ScheduleNotification;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;

final class InstructorsScheduleController extends Controller
{
    public function __invoke(ScheduleRequest $request, Instructor $instructor)
    {
        $admins = User::query()->role('admin')->get();
        Notification::send($admins, new ScheduleNotification(
            $instructor,
            $request->validated('name'),
            $request->validated('phone')
        ));
        return back();
    }
}

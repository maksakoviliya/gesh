<?php

declare(strict_types=1);

namespace App\Http\Controllers\Transfer;

use App\Actions\TelegramNotifications\SendMessageToAdminGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transfer\ScheduleRequest;
use App\Models\User;
use App\Notifications\Admin\Transfer\ScheduleNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Propaganistas\LaravelPhone\PhoneNumber;

final class TransferScheduleController extends Controller
{
    protected SendMessageToAdminGroup $telegram;

    public function __construct()
    {
        $this->telegram = new SendMessageToAdminGroup;
    }

    public function __invoke(ScheduleRequest $request): RedirectResponse
    {
        $admins = User::query()->role('admin')->get();
        /** @var PhoneNumber $phone */
        $phone = $request->validated('phone');

        Notification::send($admins, new ScheduleNotification(
            $request->validated('name'),
            $phone->formatE164()
        ));

        $this->telegram->sendNewTransferRequestMessage(
            $request->validated('name'),
            $phone->formatE164()
        );

        return back();
    }
}

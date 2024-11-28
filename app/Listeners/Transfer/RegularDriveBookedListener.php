<?php

declare(strict_types=1);

namespace App\Listeners\Transfer;

use App\Actions\TelegramNotifications\SendMessageToAdminGroup;
use App\Events\Transfer\RegularDriveBookedEvent;

final class RegularDriveBookedListener
{
    protected SendMessageToAdminGroup $telegram;

    public function __construct()
    {
        $this->telegram = new SendMessageToAdminGroup;
    }

    public function handle(RegularDriveBookedEvent $event): void
    {
        $this->telegram->sendNewDriveUserBooking($event->driveUser);
    }
}

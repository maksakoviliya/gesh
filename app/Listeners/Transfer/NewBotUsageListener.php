<?php

declare(strict_types=1);

namespace App\Listeners\Transfer;

use App\Actions\TelegramNotifications\SendMessageToAdminGroup;
use App\Events\Transfer\NewBotUsageEvent;

final class NewBotUsageListener
{
    protected SendMessageToAdminGroup $telegram;

    public function __construct()
    {
        $this->telegram = new SendMessageToAdminGroup;
    }

    public function handle(NewBotUsageEvent $event): void
    {
        $this->telegram->sendNewTelegramTransferRequest($event->transferRequest);
    }
}

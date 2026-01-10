<?php

declare(strict_types=1);

namespace App\Services\Transfer\Handlers;

use App\Enums\Transfer\ButtonDataEnum;
use App\Models\User;
use App\Services\Transfer\TelegramMessageBuilder;
use Telegram\Bot\Objects\Update;

final readonly class CommandHandler
{
    public function __construct(
        private TelegramMessageBuilder $messageBuilder,
    ) {}

    public function handle(Update $update, User $user, int $chatId): void
    {
        $command = $update->getMessage()->text;

        match ($command) {
            '/start' => $this->handleStart($user, $chatId),
            default => null,
        };
    }

    private function handleStart(User $user, int $chatId): void
    {
        $this->messageBuilder->sendWelcome($chatId, $user);
    }
}
<?php

declare(strict_types=1);

namespace App\Services\Transfer\Conversation;

use App\Models\TransferRequest;
use App\Models\User;
use App\Services\Transfer\TelegramMessageBuilder;

interface StepInterface
{
    public function prompt(int $chatId, TelegramMessageBuilder $builder): void;

    public function isComplete(TransferRequest $request, User $user): bool;

    public function process(TransferRequest $request, User $user, string $input): bool;

    public function getErrorMessage(): string;

    public function next(): ?StepInterface;
}

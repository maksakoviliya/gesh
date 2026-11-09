<?php

declare(strict_types=1);

namespace App\Services\Transfer\Conversation\Steps;

use App\Models\TransferRequest;
use App\Models\User;
use App\Services\Transfer\Conversation\StepInterface;
use App\Services\Transfer\TelegramMessageBuilder;

final class SelectDestinationStep implements StepInterface
{
    public function prompt(int $chatId, TelegramMessageBuilder $builder): void
    {
        $builder->sendDestinationSelection($chatId);
    }

    public function isComplete(TransferRequest $request, User $user): bool
    {
        return $request->destination !== null;
    }

    public function process(TransferRequest $request, User $user, string $input): bool
    {
        // Выбор направления происходит через callback, не через текст
        return false;
    }

    public function getErrorMessage(): string
    {
        return 'Пожалуйста, выберите направление, нажав на одну из кнопок выше.';
    }

    public function next(): ?StepInterface
    {
        return new EnterDateStep;
    }
}

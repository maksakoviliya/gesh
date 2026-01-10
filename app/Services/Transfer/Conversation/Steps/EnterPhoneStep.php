<?php

declare(strict_types=1);

namespace App\Services\Transfer\Conversation\Steps;

use App\Models\TransferRequest;
use App\Models\User;
use App\Services\Transfer\Conversation\StepInterface;
use App\Services\Transfer\TelegramMessageBuilder;

final class EnterPhoneStep implements StepInterface
{
    public function prompt(int $chatId, TelegramMessageBuilder $builder): void
    {
        $builder->sendPhoneRequest($chatId);
    }

    public function isComplete(TransferRequest $request, User $user): bool
    {
        return $user->phone !== null;
    }

    public function process(TransferRequest $request, User $user, string $input): bool
    {
        // Номер телефона обрабатывается через ContactHandler, не через текст
        return false;
    }

    public function getErrorMessage(): string
    {
        return 'Пожалуйста, отправьте свой контакт, нажав на кнопку "Отправить номер телефона".';
    }

    public function next(): ?StepInterface
    {
        return null; // Это последний шаг
    }
}

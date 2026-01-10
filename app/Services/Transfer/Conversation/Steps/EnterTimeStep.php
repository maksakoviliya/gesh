<?php

declare(strict_types=1);

namespace App\Services\Transfer\Conversation\Steps;

use App\Models\TransferRequest;
use App\Models\User;
use App\Services\Transfer\Conversation\StepInterface;
use App\Services\Transfer\TelegramMessageBuilder;
use App\Services\Transfer\Validators\TimeValidator;

final readonly class EnterTimeStep implements StepInterface
{
    public function __construct(
        private TimeValidator $validator = new TimeValidator(),
    ) {}

    public function prompt(int $chatId, TelegramMessageBuilder $builder): void
    {
        $builder->sendSimple($chatId, 'Введите время в формате ЧЧ:ММ');
    }

    public function isComplete(TransferRequest $request, User $user): bool
    {
        return $request->start_time !== null;
    }

    public function process(TransferRequest $request, User $user, string $input): bool
    {
        if (!$this->validator->validate($input)) {
            return false;
        }

        return $request->update(['start_time' => $input]);
    }

    public function getErrorMessage(): string
    {
        return $this->validator->getErrorMessage();
    }

    public function next(): ?StepInterface
    {
        return new EnterPassengersStep();
    }
}

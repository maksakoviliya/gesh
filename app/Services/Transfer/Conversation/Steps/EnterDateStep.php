<?php

declare(strict_types=1);

namespace App\Services\Transfer\Conversation\Steps;

use App\Models\TransferRequest;
use App\Models\User;
use App\Services\Transfer\Conversation\StepInterface;
use App\Services\Transfer\TelegramMessageBuilder;
use App\Services\Transfer\Validators\DateValidator;

final readonly class EnterDateStep implements StepInterface
{
    public function __construct(
        private DateValidator $validator = new DateValidator(),
    ) {}

    public function prompt(int $chatId, TelegramMessageBuilder $builder): void
    {
        $builder->sendSimple($chatId, 'Введите дату в формате ДД.ММ.ГГГГ');
    }

    public function isComplete(TransferRequest $request, User $user): bool
    {
        return $request->start_at !== null;
    }

    public function process(TransferRequest $request, User $user, string $input): bool
    {
        $date = $this->validator->parse($input);

        if (!$date) {
            return false;
        }

        return $request->update(['start_at' => $date]);
    }

    public function getErrorMessage(): string
    {
        return $this->validator->getErrorMessage();
    }

    public function next(): ?StepInterface
    {
        return new EnterTimeStep();
    }
}

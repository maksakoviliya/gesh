<?php

declare(strict_types=1);

namespace App\Services\Transfer\Conversation\Steps;

use App\Models\TransferRequest;
use App\Models\User;
use App\Services\Transfer\Conversation\StepInterface;
use App\Services\Transfer\TelegramMessageBuilder;
use App\Services\Transfer\Validators\PassengersValidator;

final readonly class EnterPassengersStep implements StepInterface
{
    public function __construct(
        private PassengersValidator $validator = new PassengersValidator,
    ) {}

    public function prompt(int $chatId, TelegramMessageBuilder $builder): void
    {
        $builder->sendPassengersPicker($chatId);
    }

    public function isComplete(TransferRequest $request, User $user): bool
    {
        return $request->passengers_count !== null;
    }

    public function process(TransferRequest $request, User $user, string $input): bool
    {
        $count = $this->validator->parse($input);

        if ($count === null) {
            return false;
        }

        return $request->update(['passengers_count' => $count]);
    }

    public function getErrorMessage(): string
    {
        return $this->validator->getErrorMessage();
    }

    public function next(): ?StepInterface
    {
        return new EnterPhoneStep;
    }
}

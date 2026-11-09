<?php

declare(strict_types=1);

namespace App\Services\Transfer\Validators;

final class PassengersValidator
{
    private const MIN_PASSENGERS = 1;

    private const MAX_PASSENGERS = 20;

    public function parse(string $input): ?int
    {
        $count = filter_var($input, FILTER_VALIDATE_INT);

        if ($count === false) {
            return null;
        }

        if ($count < self::MIN_PASSENGERS || $count > self::MAX_PASSENGERS) {
            return null;
        }

        return $count;
    }

    public function getErrorMessage(): string
    {
        return sprintf(
            'Неверный формат числа. Укажите целое число от %d до %d.',
            self::MIN_PASSENGERS,
            self::MAX_PASSENGERS
        );
    }
}

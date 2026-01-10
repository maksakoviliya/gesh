<?php

declare(strict_types=1);

namespace App\Services\Transfer\Validators;

final class TimeValidator
{
    public function validate(?string $time): bool
    {
        if (!$time) {
            return false;
        }

        return (bool) preg_match('/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9])$/', $time);
    }

    public function getErrorMessage(): string
    {
        return 'Неверный формат времени. Нужно отправить в формате ЧЧ:ММ';
    }
}

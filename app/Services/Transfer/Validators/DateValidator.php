<?php

declare(strict_types=1);

namespace App\Services\Transfer\Validators;

use Illuminate\Support\Carbon;
use Throwable;

final class DateValidator
{
    public function parse(string $date): ?Carbon
    {
        try {
            $date = Carbon::createFromFormat('d.m.Y', $date);
            if ($date < Carbon::now()) {
                return null;
            }
            return $date;
        } catch (Throwable) {
            return null;
        }
    }

    public function getErrorMessage(): string
    {
        return 'Неверный формат даты. Нужно отправить в формате ДД.ММ.ГГГГ.';
    }
}

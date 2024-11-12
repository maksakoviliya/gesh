<?php

declare(strict_types=1);

namespace App\Enums\Transfer;

enum RegularDriveStatus: string
{
    case ACTIVE = 'active';

    case DRAFT = 'draft';

    public static  function options(): array
    {
        return [
            self::ACTIVE->value,
            self::DRAFT->value,
        ];
    }
}

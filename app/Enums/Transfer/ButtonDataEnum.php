<?php

declare(strict_types=1);

namespace App\Enums\Transfer;

enum ButtonDataEnum: string
{
    case TAXI = 'taxi';

    case TRANSFER = 'transfer';

    case PUSH_START = 'push_start';
}

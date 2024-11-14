<?php

declare(strict_types=1);

namespace App\Enums\Transfer;

enum DriveUserStatus: string
{
    case Pending = 'pending';

    case Cancelled = 'cancelled';

    case Paid = 'paid';
}

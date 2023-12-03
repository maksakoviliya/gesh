<?php

declare(strict_types=1);

namespace App\Enums\ReservationRequest;

enum Status: string
{
    case Rejected = 'rejected';
    case Submitted = 'submitted';
}

<?php

declare(strict_types=1);

namespace App\Enums\Apartments;

enum Type: string
{
    case WHOLE = 'whole';
    case ROOM = 'room';
    case HOSTEL = 'hostel';
}

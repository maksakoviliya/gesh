<?php

declare(strict_types=1);

namespace App\Enums\Apartments;

enum Status: string
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Published = 'published';
}

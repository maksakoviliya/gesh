<?php

namespace App\Enums\Transfer;

enum RequestStatusEnum: string
{
    case DRAFT = 'draft';

    case PENDING = 'pending';

    case REJECTED = 'rejected';

    case APPROVED = 'approved';

    case CANCELLED = 'cancelled';
}

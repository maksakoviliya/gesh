<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

final class ReservationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }
}

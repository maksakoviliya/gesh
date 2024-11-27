<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

final class DriveUserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }
}

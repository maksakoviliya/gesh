<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Apartment;
use App\Models\User;

final class ApartmentPolicy
{
    public function view(User $user, Apartment $apartment): bool
    {
        return $user->id === $apartment->user_id || $user->hasRole(['admin', 'moderator', 'manager']);
    }

    public function update(User $user, Apartment $apartment): bool
    {
        return $user->id === $apartment->user_id || $user->hasRole(['admin', 'moderator', 'manager']);
    }

    public function delete(User $user, Apartment $apartment): bool
    {
        return $user->id === $apartment->user_id || $user->hasRole('admin');
    }

    public function remove_media(User $user, Apartment $apartment): bool
    {
        return $user->id === $apartment->user_id || $user->hasRole('admin');
    }

    public function add_media(User $user, Apartment $apartment): bool
    {
        return $user->id === $apartment->user_id || $user->hasRole('admin');
    }
}

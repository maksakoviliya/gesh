<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Apartment;
use App\Models\User;

class ApartmentPolicy
{
    //    /**
    //     * Determine whether the user can view any models.
    //     */
    //    public function viewAny(User $user): bool
    //    {
    //        //
    //    }
    //
    public function view(User $user, Apartment $apartment): bool
    {
        return $user->id === $apartment->user_id || $user->hasRole(['admin', 'moderator']);
    }
    //
    //    /**
    //     * Determine whether the user can create models.
    //     */
    //    public function create(User $user): bool
    //    {
    //        //
    //    }

    public function update(User $user, Apartment $apartment): bool
    {
        return $user->id === $apartment->user_id || $user->hasRole('admin');
    }

    public function delete(User $user, Apartment $apartment): bool
    {
        return $user->id === $apartment->user_id || $user->hasRole('admin');
    }

    public function remove_media(User $user, Apartment $apartment): bool
    {
        return $user->id === $apartment->user_id || $user->hasRole('admin');
    }
    //
    //    /**
    //     * Determine whether the user can restore the model.
    //     */
    //    public function restore(User $user, Apartment $apartment): bool
    //    {
    //        //
    //    }
    //
    //    /**
    //     * Determine whether the user can permanently delete the model.
    //     */
    //    public function forceDelete(User $user, Apartment $apartment): bool
    //    {
    //        //
    //    }
}

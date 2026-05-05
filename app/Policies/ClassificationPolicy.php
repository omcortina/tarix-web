<?php

namespace App\Policies;

use App\Models\Classification;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClassificationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Classification $classification): bool
    {
        // Dueño de la clasificación o admin
        if ($user->id === $classification->user_id || $user->user_type === 'ADMIN') {
            return true;
        }

        // Usuario EMPRESA puede ver clasificaciones de usuarios de su misma empresa
        if ($user->user_type === 'EMPRESA' && $user->company_id !== null) {
            return $classification->user->company_id === $user->company_id;
        }

        return false;
    }

    /**
     * Determine whether the user can verify the model (for clasificadores).
     */
    public function verify(User $user, Classification $classification): bool
    {
        return $user->id === $classification->clasificador_id || $user->user_type === 'ADMIN';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Classification $classification): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Classification $classification): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Classification $classification): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Classification $classification): bool
    {
        //
    }
}

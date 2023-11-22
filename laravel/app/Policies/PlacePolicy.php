<?php

namespace App\Policies;

use App\Models\Place;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlacePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('author');
    }


    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Place $place): bool
    {
        // Tots poden visualitzar un place específic
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Només els usuaris amb rol 'author' poden crear places
        return $user->hasRole('author');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Place $place): bool
    {
        // 'author' pot editar els seus propis places
        // 'editor' pot editar qualsevol place
        return ($user->hasRole('author') && $user->id === $place->author_id) || $user->role === 'editor';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Place $place): bool
    {
        // 'author' pot eliminar els seus propis places
        // 'editor' pot eliminar qualsevol place
        return ($user->hasRole('author') && $user->id === $place->author_id) || $user->role === 'editor';
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Place $place): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Place $place): bool
    {
        //
    }

    public function favorite(User $user, Place $place)
    {
        return $user->role === 'author';
    }

}

<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy extends ModelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(User $user): bool
    // {
    //     return $user->hasAbility('roles.view');
    // }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    // public function view(User $user, Role $role): bool
    // {
    //     return $user->hasAbility('roles.view');

    // }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create(User $user): bool
    // {
    //     return $user->hasAbility('roles.create');

    // }

    // /**
    //  * Determine whether the user can update the model.
    //  */
    // public function update(User $user, Role $role): bool
    // {
    //     return $user->hasAbility('roles.update');

    // }

    // /**
    //  * Determine whether the user can delete the model.
    //  */
    // public function delete(User $user, Role $role): bool
    // {
    //         return $user->hasAbility('roles.delete');

    // }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restore(User $user, Role $role): bool
    // {
    //     return $user->hasAbility('roles.restore');
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(User $user, Role $role): bool
    // {
    //     return $user->hasAbility('roles.force-delete');

    // }
}

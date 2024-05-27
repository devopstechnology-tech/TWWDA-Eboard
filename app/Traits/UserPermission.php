<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;

trait UserPermission
{
    use Types;

    public function hasDefaultPermission(User $user, $permission): bool
    {
        if ($user->hasSuperAdminRole()) {
            return true;
        }
        if ($user->type === User::$type_system) {
            return true;
        }
        if ($user->type === User::$type_admin) {
            return true;
        }
        $roles = $user->roles()->where('type', Role::$type_default)->get();

        return $this->loopThroughRolesToFindPermission($roles, $permission, Role::$type_default);
    }

    /**
     * Loop through a collection of $roles to determine if one of them contains the $permission of the proper type.
     */
    private function loopThroughRolesToFindPermission(Collection $roles, string $permission, string $type): bool
    {
        foreach ($roles as $role) {
            if (
                ($type === Permission::$type_default && $role->hasTypePermissionTo(Role::$type_default, $permission))
                || ($type === Permission::$type_admin && $role->hasTypePermissionTo(Role::$type_admin, $permission))
                || ($type === Permission::$type_system && $role->hasTypePermissionTo(Role::$type_system, $permission))
            ) {
                return true;
            }
        }

        return false;
    }

    public function hasAdminPermission(User $user, $permission): bool
    {
        // Super Admin has all permissions
        if ($user->hasSuperAdminRole()) {
            return true;
        }
        if ($user->type === User::$type_system) {
            return true;
        }

        $roles = $user->roles()->where('type', Role::$type_admin)->get();

        return $this->loopThroughRolesToFindPermission($roles, $permission, Role::$type_admin);
    }

    public function hasSystemPermission(User $user, $permission): bool
    {
        if ($user->hasSuperAdminRole()) {
            return true;
        }
        $roles = $user->roles()->where('type', Role::$type_system)->get();

        return $this->loopThroughRolesToFindPermission($roles, $permission, Role::$type_system);
    }
}

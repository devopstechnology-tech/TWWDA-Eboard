<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exceptions\RolePermissionTypeException;
use App\Exceptions\RoleUserTypeException;
use App\Http\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Repository\Contracts\RoleInterface;
use Illuminate\Support\Facades\DB;

class RoleRepository extends BaseRepository implements RoleInterface
{
    public function attachPermissionToRole(string|Role $role, Permission|string $permission): bool
    {
        if (!($role instanceof Role)) {
            $role = Role::findOrFail($role);
        }
        if (!($permission instanceof Permission)) {
            $permission = Permission::findOrFail($permission);
        }
        if ($permission->type === $permission::$type_system && $role->type === $role::$type_admin) {
            throw new RolePermissionTypeException('Permission of type `System` cannot be assigned to role of type `Admin`');
        }
        if ($permission->type === $permission::$type_default && ($role->type === $role::$type_admin || $role->type === $role::$type_system)) {
            throw new RolePermissionTypeException('Permission of type `Default` cannot be assigned to role of type `Admin` or `System`');
        }

        return (bool) $role->permissions()->syncWithoutDetaching($permission->id);
    }

    public function attachRoleToUser(string|Role $role, User|string $user): bool
    {
        if (!($role instanceof Role)) {
            $role = Role::findOrFail($role);
        }
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }
        if ($user->type === $user::$type_system && $role->type === $role::$type_admin) {
            throw new RoleUserTypeException('User of type `System` cannot be assigned to role of type `Admin`');
        }
        if ($user->type === $user::$type_default && ($role->type === $role::$type_admin || $role->type === $role::$type_system)) {
            throw new RoleUserTypeException('User of type `Default` cannot be assigned to role of type `Admin` or `System`');
        }

        return (bool) $role->users()->save($user);
    }

    public function create(array $payload): Role
    {
        return Role::firstOrCreate($payload);
    }

    public function delete(string|Role $role): bool
    {
        if (!($role instanceof Role)) {
            $role = Role::findOrFail($role);
        }
        DB::beginTransaction();
        $role->permissions()->detach();
        $role->users()->detach();
        $role->delete();
        DB::commit();

        return true;
    }

    public function detachPermissionFromRole(string|Role $role, Permission|string $permission): bool
    {
        if (!($role instanceof Role)) {
            $role = Role::findOrFail($role);
        }
        if (!($permission instanceof Permission)) {
            $permission = Permission::findOrFail($permission);
        }

        return (bool) $role->permissions()->detach($permission->id);
    }

    public function detachRoleFromUser(string|Role $role, User|string $user): int
    {
        if (!($role instanceof Role)) {
            $role = Role::findOrFail($role);
        }
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }

        return $role->users()->detach($user->id);
    }

    public function get(string|Role $role): Role
    {
        if (!($role instanceof Role)) {
            $role = Role::findOrFail($role);
        }

        return $role->loadCount(['permissions', 'users']);
    }

    public function getAll()
    {
        return $this->indexResource(Role::class, RoleResource::class);
    }

    public function update(string|Role $role, array $payload): RoleResource
    {
        if (!($role instanceof Role)) {
            $role = Role::findOrFail($role);
        }
        $role->update($payload);
        $role->save();

        return RoleResource::make($role)->format('single');
    }
}

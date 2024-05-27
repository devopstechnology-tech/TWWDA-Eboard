<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Http\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

interface RoleInterface
{
    public function attachPermissionToRole(Role|string $role, Permission|string $permission): bool;

    public function attachRoleToUser(Role|string $role, User|string $user): bool;

    public function create(array $payload): Role;

    public function delete(Role|string $role): bool;

    public function detachPermissionFromRole(Role|string $role, Permission|string $permission): bool;

    public function detachRoleFromUser(Role|string $role, User|string $user): int;

    public function get(Role|string $role): Role;

    public function getAll();

    public function update(Role|string $role, array $payload): Role|RoleResource;
}

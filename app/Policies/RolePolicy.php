<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Permissions\RolePermissions;

class RolePolicy extends BasePolicy
{
    // public function viewAny(User $user): bool
    // {
    //     return $this->hasAdminPermission($user, RolePermissions::VIEW['name']);
    // }

    // public function view(User $user): bool
    // {
    //     return $this->hasAdminPermission($user, RolePermissions::VIEW['name']);
    // }

    // public function create(User $user): bool
    // {
    //     return $this->hasAdminPermission($user, RolePermissions::CREATE['name']);
    // }

    // public function update(User $user): bool
    // {
    //     return $this->hasAdminPermission($user, RolePermissions::EDIT['name']);
    // }

    // public function delete(User $user): bool
    // {
    //     return $this->hasSystemPermission($user, RolePermissions::DELETE['name']);
    // }
}
<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Permissions\PermissionPermissions;

class PermissionPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->hasAdminPermission($user, PermissionPermissions::VIEW['name']);
    }

    public function view(User $user): bool
    {
        return $this->hasDefaultPermission($user, PermissionPermissions::VIEW['name']);
    }

    public function update(User $user): bool
    {
        return $this->hasSystemPermission($user, PermissionPermissions::EDIT['name']);
    }
}

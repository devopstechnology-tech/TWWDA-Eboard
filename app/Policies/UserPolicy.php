<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Permissions\UserPermissions;

class UserPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->hasDefaultPermission($user, UserPermissions::VIEW['name']);
    }

    public function view(User $user): bool
    {
        return $this->hasDefaultPermission($user, UserPermissions::VIEW['name']);
    }

    public function create(User $user): bool
    {
        return $this->hasDefaultPermission($user, UserPermissions::CREATE['name']);
    }

    public function update(User $user, $userId): bool
    {
        return $user->id === $userId || $this->hasDefaultPermission($user, UserPermissions::EDIT['name']);
    }

    public function delete(User $user): bool
    {
        return $this->hasSystemPermission($user, UserPermissions::DELETE['name']);
    }
}

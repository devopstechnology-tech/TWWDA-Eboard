<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Permissions\StaffPermissions;

class StaffPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->hasDefaultPermission($user, StaffPermissions::VIEW['name']);
    }

    public function view(User $user): bool
    {
        return $this->hasDefaultPermission($user, StaffPermissions::VIEW['name']);
    }

    public function create(User $user): bool
    {
        return $this->hasSystemPermission($user, StaffPermissions::CREATE['name']);
    }

    public function update(User $user): bool
    {
        return $this->hasDefaultPermission($user, StaffPermissions::EDIT['name']);
    }

    public function delete(User $user): bool
    {
        return $this->hasSystemPermission($user, StaffPermissions::DELETE['name']);
    }
}

<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\User;

interface UsersInterface
{
    // Define your methods here


    public function getUsers();
    public function getTrashedUsers();
    public function get(User|string $user);
    public function getUserFullDetails(User|string $user);
    public function create(array $payload): User;
    public function InviteAcceptance(array $payload);
    public function update(User|string $user, array $payload): User;
    public function updateRole(User|string $user, array $payload): User;
    public function restoreUser($user);
    public function forceDeleteUser($user);
    public function deleteUser($user);
}
<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Data\Credentials;
use App\Models\User;
use Illuminate\Http\Request;

interface UserInterface
{
    public function register(array $payload);

    public function update(User|string $user, array $payload);

    public function deleteUser(User $user);

    public function login(Credentials $credentials);

    public function logout(Request $request);

    public function get(User|string $user);

    public function getUserFullDetails(User|string $user);

    public function getUsers();
}

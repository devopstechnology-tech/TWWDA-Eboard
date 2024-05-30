<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\User;
use App\Data\Credentials;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

interface UserInterface
{
    public function register(array $payload);

    public function update(User|string $user, array $payload);

    public function deleteUser(User $user);

    public function login(Credentials $credentials);

    public function logout(Request $request);

    public function forgotPassword(array $payload);

    public function changePassword(array $payload);

    public function get(User|string $user);

    public function getUserFullDetails(User|string $user);

    public function getUsers();
}

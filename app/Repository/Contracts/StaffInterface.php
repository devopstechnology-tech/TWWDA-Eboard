<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Data\Credentials;
use App\Models\Users\Staff;
use Illuminate\Http\Request;

interface StaffInterface
{
    public function login(Credentials $credentials);

    public function logout(Request $request);

    public function getAll();

    public function get(Staff|string $staff): Staff;

    public function create(array $payload): Staff;

    public function update(Staff|string $staff, array $payload): Staff;

    public function delete(Staff|string $staff): bool;
}

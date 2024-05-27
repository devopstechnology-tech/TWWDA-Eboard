<?php

declare(strict_types=1);

namespace Database\Factories\Users;

use App\Models\Pos\PosAccount;
use App\Models\Users\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first' => fake()->firstName(),
            'last' => fake()->lastName(),
            'id_number' => fake()->numerify('##########'),
            'department_id' => Department::factory()->createOne()->id,
            'pos_account_id' => PosAccount::factory()->createOne()->id,
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'serial_no' => fake()->word(),
            'access_key' => fake()->numerify('####################'),
            'access_secret' => fake()->numerify('##############################'),
            'password' => '@Passwor0d', // password
        ];
    }

    public function email(string $email): static
    {
        return $this->set('email', $email);
    }

    public function idNumber(string $idNumber): static
    {
        return $this->set('id_number', $idNumber);
    }

    public function name(string $first, string $last): static
    {
        return $this->set('first', $first)
            ->set('last', $last);
    }

    public function password(string $password): static
    {
        return $this->set('password', $password);
    }

    public function type($type): static
    {
        return $this->set('type', $type);
    }

    public function role($role): static
    {
        return $this->set('role', $role);
    }

    public function unverified(): static
    {
        return $this->set('email_verified_at', null);
    }
}

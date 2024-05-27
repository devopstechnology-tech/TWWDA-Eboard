<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first' => fake()->firstName(),
            'last' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'id_number' => fake()->numerify('##########'),
            'role' => fake()->randomElement(Role::allTypes()),
            'type' => 'default',
            'email_verified_at' => now('Africa/Nairobi'),
            'password' => '@Passwor0d', // password
            'remember_token' => Str::random(10),
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

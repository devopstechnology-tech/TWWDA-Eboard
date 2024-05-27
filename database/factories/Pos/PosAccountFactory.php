<?php

declare(strict_types=1);

namespace Database\Factories\Pos;

use Illuminate\Database\Eloquent\Factories\Factory;

class PosAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'serial' => fake()->word(),
            'line_1' => fake()->numerify('##################'),
            'line_1_provider' => fake()->randomElement(['safaricom', 'airtel']),
            'status' => fake()->word(),
            'description' => fake()->word(),
        ];
    }
}

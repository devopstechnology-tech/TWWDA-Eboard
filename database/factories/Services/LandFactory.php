<?php

declare(strict_types=1);

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;

class LandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = $this->faker->numberBetween(1, 2000);

        return [
            'sub_county_id' => 1,
            'plot_number' => $this->faker->numberBetween(1, 2000),
            'plot_size' => $this->faker->numberBetween(1, 2000),
            'owner_name' => $this->faker->name(),
            'owner_id' => $this->faker->numberBetween(1, 2000),
            'owner_phone' => $this->faker->numberBetween(1, 2000),
        ];
    }
}

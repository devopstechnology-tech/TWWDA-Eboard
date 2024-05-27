<?php

declare(strict_types=1);

namespace Database\Factories\Config;

use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'number' => $this->faker->randomNumber(),
            'icon' => $this->faker->word(),
            'pos_excluded' => $this->faker->randomElement([true, false]),
            'ussd_excluded' => $this->faker->randomElement([true, false]),
            'detail' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(25),
        ];
    }
}

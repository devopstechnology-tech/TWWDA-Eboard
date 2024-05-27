<?php

declare(strict_types=1);

namespace Database\Factories\Config;

use App\Models\Config\Schedule;
use App\Models\Config\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Section>
 */
class SectionFactory extends Factory
{
    public function definition(): array
    {
        $schedule = Schedule::factory()->createOne();

        return [
            'name' => $this->faker->word(),
            'schedule_id' => $schedule->id,
            'icon' => $this->faker->word(),
            'pos_excluded' => $this->faker->randomElement([true, false]),
            'ussd_excluded' => $this->faker->randomElement([true, false]),
            'description' => $this->faker->sentence(25),
        ];
    }
}

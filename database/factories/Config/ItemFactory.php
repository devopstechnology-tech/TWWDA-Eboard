<?php

declare(strict_types=1);

namespace Database\Factories\Config;

use App\Models\Config\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $section = Section::factory()->count(1)->create()->first();

        return [
            //            'name' => $this->faker->word(),
            'schedule_id' => $section->schedule_id,
            'section_id' => $section->id,
            'icon' => $this->faker->word(),
            'code' => $this->faker->word(),
            'unit' => $this->faker->word(),
            'amount' => $this->faker->randomNumber(),
            'pos_excluded' => $this->faker->randomElement([true, false]),
            'zoned' => $this->faker->randomElement([true, false]),
            'ussd_excluded' => $this->faker->randomElement([true, false]),
            'description' => $this->faker->sentence(25),
        ];
    }
}

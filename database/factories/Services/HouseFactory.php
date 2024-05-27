<?php

declare(strict_types=1);

namespace Database\Factories\Services;

use App\Models\Config\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class HouseFactory extends Factory
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
            'owner_name' => $this->faker->name(),
            'location' => $this->faker->word(),
            'owner_id' => $this->faker->numberBetween(1, 2000),
            'owner_phone' => $this->faker->numberBetween(1, 2000),
            'house_no' => $this->faker->numberBetween(1, 2000),
            'item_id' => Item::inRandomOrder()->first()->pluck('id'),
        ];
    }
}

<?php

declare(strict_types=1);

namespace Database\Factories\Payment;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = $this->faker->randomNumber();

        return [
            'serial' => generateRandomString(6),
            'original_amount' => $amount,
            'payable_amount' => $amount,
            'grace_period' => $this->faker->randomNumber(),
            'daily_interest' => $this->faker->randomNumber(),
            'daily_penalty' => $this->faker->randomNumber(),
        ];
    }

    public function billable_type(string $type): static
    {
        return $this->set('billable_type', $type);
    }

    public function billable_id(int $type): static
    {
        return $this->set('billable_id', $type);
    }
    public function amount(int $amount): static
    {
        return $this->set('payable_amount', $amount);
    }
}

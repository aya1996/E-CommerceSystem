<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'transaction_id' => uniqid(),
            'payment_method' => [
                'en' => $this->faker->word,
                'ar' => $this->faker->word,
            ],
            'payment_status' => [
                'en' => $this->faker->word,
                'ar' => $this->faker->word,
            ],
            'payment_amount' => $this->faker->numberBetween(1, 100),
            'payment_currency' => [
                'en' => $this->faker->word,
                'ar' => $this->faker->word,
            ],
            'payment_date' => $this->faker->dateTimeBetween('2020-01-01', '2020-12-31'),

        ];
    }
}

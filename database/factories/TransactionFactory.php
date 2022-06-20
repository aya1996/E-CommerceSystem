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
            'transactionable_id' => $this->faker->numberBetween(1, 10),
            'transactionable_type' => $this->faker->randomElement(['App\Models\User', 'App\Models\Admin']),
            'transaction_id' => uniqid(),
            'payment_method' => $this->faker->randomElement(['credit_card', 'debit_card', 'paypal']),
            'payment_status' => $this->faker->randomElement(['paid', 'pending', 'cancelled']),
            'payment_amount' => $this->faker->numberBetween(1, 100),
            'payment_currency' => $this->faker->word,
            'payment_date' => $this->faker->dateTimeBetween('now', '+1 year'),

        ];
    }
}

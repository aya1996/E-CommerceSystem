<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

            'invoice_number' => uniqid(),
            'total_amount' => $this->faker->numberBetween(1, 100),
            'user_id' => $this->faker->numberBetween(1, 10),
            'sub_total' => $this->faker->numberBetween(1, 100),
            'invoiceDate' => $this->faker->dateTimeBetween('2020-01-01', '2020-12-31'),
            'discount' => $this->faker->numberBetween(1, 100),
            'status' => $this->faker->numberBetween(0, 1),


        ];
    }
}

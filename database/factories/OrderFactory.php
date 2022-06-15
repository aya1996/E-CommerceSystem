<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
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
            'shipping_date' => $this->faker->dateTimeBetween('2020-01-01', '2020-12-31'),
            'delivery_date' => $this->faker->dateTimeBetween('2020-01-01', '2020-12-31'),
            'status' => $this->faker->numberBetween(0, 1),


        ];
    }
}

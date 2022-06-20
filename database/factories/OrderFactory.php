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
            'shipping_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'delivery_date' => $this->faker->dateTimeBetween('tomorrow', '+1 year'),
            'status' => $this->faker->randomElement(['pending', 'processing', 'delivered', 'cancelled']),
            'delivery_id' => $this->faker->numberBetween(1, 5),
            'longitude' => $this->faker->longitude,
            'latitude' => $this->faker->latitude,


        ];
    }
}

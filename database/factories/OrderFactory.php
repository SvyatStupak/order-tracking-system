<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'product_name' => $this->faker->word(),
            'amount' => $this->faker->randomFloat(2, 10, 100),
            'status' => 'new',
        ];
    }
}

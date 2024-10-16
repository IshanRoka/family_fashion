<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(5, 18),
            'product_id' => Product::factory(),
            'total_price' => $this->faker->randomFloat(2, 10, 1000),
            'qty' => $this->faker->numberBetween(1, 10)
        ];
    }
}

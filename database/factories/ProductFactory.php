<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 3),
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 100),

            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
            'color' => $this->faker->colorName(),
            'material' => $this->faker->word(),
            'product_status' => $this->faker->randomElement(['pending', 'available', 'sold_out']),
            'image' => $this->faker->imageUrl(),
        ];
    }
}

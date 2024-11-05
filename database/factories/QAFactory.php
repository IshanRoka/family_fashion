<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Q_A_S>
 */
class QAFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 6),
            'product_id' => $this->faker->numberBetween(1, 10),
            'question' => $this->faker->sentence(),
            'answer' => $this->faker->sentence(),
        ];
    }
}
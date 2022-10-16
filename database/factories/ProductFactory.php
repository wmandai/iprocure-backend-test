<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->randomElement(['almatix', 'duodip', 'delete', 'steladone']),
            'description' => 'Tick controls',
            'type' => 'acaricide',
            'category' => 'controls',
            'quantity' => rand(1, 5),
            'unit_cost' => rand(100, 1000),
            'manufacturer' => 'Norbrook',
            'distributor' => 'Solai Agrovet',
            'user_id' => auth()->id(),
        ];
    }
}

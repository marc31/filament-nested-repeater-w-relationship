<?php

namespace Database\Factories;

use App\Models\Color;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            // Attacher des acteur aléatoirement
            $colors = Color::inRandomOrder()->limit(3)->pluck('id');
            $product->colors()->attach($colors);
        });
    }
}

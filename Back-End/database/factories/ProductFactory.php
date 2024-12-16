<?php

namespace Database\Factories;

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
            'name' => $this->faker->word,
            'name_AR' => $this->faker->word,
            'description' => $this->faker->text,
            'description_AR' => $this->faker->text,
            'price' => $this->faker->numberBetween(100, 1000),
            'quantity' => $this->faker->numberBetween(1, 100),
            'product_image' => $this->faker->imageUrl(),
            'store_id' => \App\Models\Store::factory(), // Assuming you have a Store factory
        ];
    }
}

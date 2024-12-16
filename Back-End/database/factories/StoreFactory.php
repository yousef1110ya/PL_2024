<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->company, // Generates a random company name
            'name_AR' => $this->faker->company, // Generates a random company name in Arabic
            'location' => $this->faker->address, // Generates a random address
            'phone' => $this->faker->phoneNumber, // Generates a random phone number
            'store-image' => null,
        ];
    }
}

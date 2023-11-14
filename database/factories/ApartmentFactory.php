<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apartment>
 */
class ApartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => null,
            'description' => null,
            'address' => $this->faker->address,
            'rooms' => $this->faker->randomDigitNotZero(),
            'guests' => $this->faker->randomDigitNotZero(),
            'price' => mt_rand(1000, 15000)
        ];
    }
}

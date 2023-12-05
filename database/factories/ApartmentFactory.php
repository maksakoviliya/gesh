<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Apartments\Status;
use App\Enums\Apartments\Type;
use App\Models\Apartment;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApartmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'status' => Status::Published,
            'step' => '12',
            'user_id' => User::factory(),

            // Step 1
            'category_id' => Category::query()->inRandomOrder()->first()?->id,

            // Step 2
            'type' => Type::WHOLE,

            // Step 3
            'country_code' => 'ru',
            'state' => 'state',
            'city' => 'city',
            'street' => 'street',
            'building' => 'building',
            'housing' => 'housing',
            'room' => 'room',
            'floor' => 'floor',
            'entrance' => 'entrance',
            'index' => 'index',

            // Step 4
            'lon' => $this->faker->longitude(1,60),
            'lat' => $this->faker->latitude(1,60),

            // Step 5
            'guests' => rand(1, 5),
            'bedrooms' => rand(1, 5),
            'beds' => rand(1, 5),
            'bathrooms' => rand(1, 5),

            // Step 6
            // Features

            // Step 7
            // Photos

            // Step 8
            'title' => null,

            // Step 9
            'description' => null,

            // Step 10
            'weekdays_price' => rand(1000, 5000),
            'weekends_price' => rand(1000, 5000),

            // Step 11
            'fast_reserve' => false,

            // Step 12
            // Sales
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Apartment $apartment) {
            try {
                $imageUrl = $this->faker->imageUrl;
                $apartment->addMediaFromUrl($imageUrl)->toMediaCollection();
            } catch (\Exception $exception) {
                
            }
        });
    }
}

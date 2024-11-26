<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Apartment;
use App\Models\DatePrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DatePrice>
 */
final class DatePriceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'apartment_id' => Apartment::factory(),
            'date' => $this->faker->date,
            'price' => mt_rand(1000, 10000),
        ];
    }
}

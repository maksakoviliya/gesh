<?php

declare(strict_types=1);

namespace Database\Factories\Transfer;

use App\Enums\Transfer\RegularDriveStatus;
use App\Models\Transfer\RegularDrive;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RegularDrive>
 */
final class RegularDriveFactory extends Factory
{
    public function definition(): array
    {
        return [
            'status' => RegularDriveStatus::ACTIVE,
            'name' => $this->faker->sentence(),
            'start_at' => $this->faker->dateTime(),
            'description' => null,
            'passengers_limit' => mt_rand(6, 12),
            'duration' => mt_rand(60, 240),
            'regular_price' => mt_rand(100, 5000),
            'start_point' => $this->faker->sentence,
            'start_lat' => $this->faker->latitude,
            'start_lon' => $this->faker->longitude,
            'finish_point' => $this->faker->sentence,
            'finish_lat' => $this->faker->latitude,
            'finish_lon' => $this->faker->longitude,
        ];
    }
}

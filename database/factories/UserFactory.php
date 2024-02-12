<?php

declare(strict_types=1);

namespace Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Propaganistas\LaravelPhone\PhoneNumber;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $phone = null;

        do {
            $fakePhone = $this->faker->phoneNumber;
            try {
                $phone = new PhoneNumber($fakePhone, 'RU');
            } catch (Exception) {
            }
        } while (!$phone);

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $phone,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }
}

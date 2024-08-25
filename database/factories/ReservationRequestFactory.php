<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Reservation\Status;
use App\Models\Apartment;
use App\Models\ReservationRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<ReservationRequest>
 */
final class ReservationRequestFactory extends Factory
{
    public function definition(): array
    {
        $start = Carbon::parse($this->faker->date)->setTime(15, 0);
        $end = Carbon::parse($this->faker->date(max: Carbon::now()->addMonth()))->setTime(12, 0);
        $guests = mt_rand(1, 4);
        $children = mt_rand(1, 4);
        $totalGuests = $guests + $children;
        $price = $this->faker->numberBetween(2000, 20000);

        return [
            'start' => $start,
            'end' => $end,
            'apartment_id' => Apartment::factory(),
            'user_id' => User::factory(),
            'guests' => $guests,
            'children' => $children,
            'total_guests' => $totalGuests,
            'range' => $start->copy()->setTime(0, 0)->diffInDays(
                $end->copy()->setTime(0, 0)
            ),
            'price' => $price,
            'first_payment' => ceil($price * 0.3),
            'status' => Status::Pending,
        ];
    }
}

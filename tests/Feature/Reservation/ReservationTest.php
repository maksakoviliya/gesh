<?php

declare(strict_types=1);

namespace Tests\Feature\Reservation;

use App\Models\Apartment;
use App\Models\Reservation;
use App\Models\ReservationRequest;
use App\Models\User;
use Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

final class ReservationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_create_reservation_request(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $apartment = Apartment::factory()
            ->create([
                'user_id' => $user->id,
            ]);

        $reservationRequest = ReservationRequest::factory()
            ->create([
                'apartment_id' => $apartment->id,
                'start' => '2024-10-15 15:00:00',
                'end' => '2024-10-19 12:00:00',
                'range' => 4,
                'price' => 5000,
                'first_payment' => 1500,
            ]);

        $this->postJson(route('account.reservation-requests.submit', [
            'reservationRequest' => $reservationRequest->id,
        ]));

        $this->assertDatabaseHas('reservations', [
            'user_id' => $reservationRequest->user->id,
            'apartment_id' => $apartment->id,
            'reservation_request_id' => $reservationRequest->id,
            'start' => '2024-10-15 15:00:00',
            'end' => '2024-10-19 12:00:00',
            'range' => 4,
            'guests' => $reservationRequest->guests,
            'children' => $reservationRequest->children,
            'total_guests' => $reservationRequest->total_guests,
            'price' => 5000,
            'first_payment' => 1500,
        ]);

        $reservation = Reservation::query()->latest()
            ->first();
        $this->assertTrue($reservation->first_payment_until->greaterThan(
            Carbon::now()->addHours(4)->addMinutes(45))
        );
    }
}

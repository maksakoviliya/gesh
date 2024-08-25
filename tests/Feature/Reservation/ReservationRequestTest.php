<?php

declare(strict_types=1);

namespace Tests\Feature\Reservation;

use App\Enums\ReservationRequest\Status;
use App\Models\Apartment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

final class ReservationRequestTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_create_reservation_request_endpoint(): void
    {
        Event::fake();

        $apartment = Apartment::factory()
            ->create([
                'weekdays_price' => 1000,
                'weekends_price' => 2000,
                'guests' => 5,
            ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'start' => '02.10.2024',
            'end' => '09.10.2024',
            'guests' => 2,
            'children' => 2,
        ];

        $this->postJson(route('reservation-requests.store', [
            'apartment' => $apartment->id,
        ]), $data);

        $this->assertDatabaseHas('reservation_requests', [
            'apartment_id' => $apartment->id,
            'user_id' => $user->id,
            'start' => '2024-10-02 15:00:00',
            'end' => '2024-10-09 12:00:00',
            'guests' => 2,
            'children' => 2,
            'total_guests' => 4,
            'range' => 7,
            'price' => 9000,
            'status' => Status::Pending->value,
            'reservation_id' => null,
            'first_payment' => 2700,
        ]);
    }

    public function test_create_reservation_request_endpoint_one_day(): void
    {
        Event::fake();

        $apartment = Apartment::factory()
            ->create([
                'weekdays_price' => 1000,
                'weekends_price' => 2000,
                'guests' => 5,
            ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'start' => '16.10.2024',
            'end' => '17.10.2024',
            'guests' => 1,
            'children' => 1,
        ];

        $this->postJson(route('reservation-requests.store', [
            'apartment' => $apartment->id,
        ]), $data);

        $this->assertDatabaseHas('reservation_requests', [
            'apartment_id' => $apartment->id,
            'user_id' => $user->id,
            'start' => '2024-10-16 15:00:00',
            'end' => '2024-10-17 12:00:00',
            'guests' => 1,
            'children' => 1,
            'total_guests' => 2,
            'range' => 1,
            'price' => 1000,
            'status' => Status::Pending->value,
            'reservation_id' => null,
            'first_payment' => 300,
        ]);
    }
}

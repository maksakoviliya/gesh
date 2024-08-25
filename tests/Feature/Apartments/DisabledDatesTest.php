<?php

declare(strict_types=1);

namespace Tests\Feature\Apartments;

use App\Models\Apartment;
use App\Models\Telegram\ActionSetDisabledDates;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DisabledDatesTest extends TestCase
{
    use RefreshDatabase;

    public function test_example(): void
    {
//        $user = User::factory()->create();
//        $apartment = Apartment::factory()
//            ->create([
//                'user_id' => $user->id,
//            ]);
//
//        ActionSetDisabledDates::factory()
//            ->create([
//                'apartment_id' => $apartment->id,
//            ]);
//
//        $this->assertDatabaseCount('disabled_dates', 0);
//
//        $data = [
//            'start' => '22.10.2024',
//            'end' => '25.10.2024',
//            'disabled' => true,
//        ];
//
//        $this->postJson(route('account.apartments.calendar.update'), $data);
//
//        $this->assertDatabaseCount('disabled_dates', 1);
//        $this->assertDatabaseCount('action_set_disabled_dates', 0);
    }
}

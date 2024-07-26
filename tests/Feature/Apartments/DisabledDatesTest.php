<?php

namespace Tests\Feature\Apartments;

use App\Models\Apartment;
use App\Models\Telegram\ActionSetDisabledDates;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisabledDatesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $apartment = Apartment::factory()
            ->create();

        $actionSetDisabledDates = ActionSetDisabledDates::factory()
            ->create([
                'apartment_id' => $apartment->id,
            ]);

        $this->assertDatabaseCount('disabled_dates', 0);

        $dates = '22.10.2024 - 25.10.2024';

        $actionSetDisabledDates->processText($dates);

        $this->assertDatabaseCount('disabled_dates', 1);
        $this->assertDatabaseCount('action_set_disabled_dates', 0);
    }
}

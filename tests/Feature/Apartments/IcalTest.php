<?php

namespace Tests\Feature\Apartments;

use App\Models\Apartment;
use App\Services\ICalService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IcalTest extends TestCase
{
    use RefreshDatabase;

    public function test_example(): void
    {
        $url = 'https://www.avito.ru/calendars-export/36/62/3611849362.ics';
        $apartment = Apartment::factory()->create();

        $this->assertDatabaseCount('side_reservations', 0);

        $iCalService = new IcalService();
        $iCalService->process($url, $apartment);

        $this->assertDatabaseHas('side_reservations', [
            'apartment_id' => $apartment->id,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Reservation;

use App\Models\Apartment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CorrectPaymentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_correct_payments_calculation(): void
    {
        $apartment = Apartment::factory()->create();

        dd($apartment->toArray());
    }
}

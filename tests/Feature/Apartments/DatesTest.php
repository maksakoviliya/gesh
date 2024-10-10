<?php

declare(strict_types=1);

namespace Tests\Feature\Apartments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DatesTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_apartment_right_dates(): void
    {
        //        $response = $this->get('/');
        //
        //        $response->assertStatus(200);
    }
}

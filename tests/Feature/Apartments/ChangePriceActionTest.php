<?php

declare(strict_types=1);

namespace Tests\Feature\Apartments;

use App\Actions\Apartments\UpdatePricesPercentsAction;
use App\Models\Apartment;
use App\Models\DatePrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ChangePriceActionTest extends TestCase
{
    use refreshDatabase;

    public function test_update_percents_from_to(): void
    {
        $apartment = Apartment::factory()
            ->create([
                'weekdays_price' => 1150,
            ]);
        DatePrice::factory(5)->create([
            'price' => 13800,
            'apartment_id' => $apartment->id,
        ]);

        $action = new UpdatePricesPercentsAction();
        $action->run($apartment, 15, 17.6);

        $apartment = $apartment->fresh([
            'datePrices',
        ]);

        $this->assertEquals(1176, $apartment->weekdays_price);
        $this->assertEquals(14112, $apartment->datePrices()->first()->price);
    }

    public function test_update_command()
    {
        Apartment::factory(3)
            ->create([
                'weekdays_price' => 1150,
            ]);

        $this->artisan('app:update-prices-command')
            ->expectsQuestion('Current percents: ', 15)
            ->expectsQuestion('New percents: ', 17.6);

        foreach (Apartment::query()->get() as $apartment) {
            $this->assertEquals(1176, $apartment->weekdays_price);
        }
    }
}

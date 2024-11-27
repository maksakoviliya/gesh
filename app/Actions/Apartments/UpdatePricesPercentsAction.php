<?php

namespace App\Actions\Apartments;

use App\Models\Apartment;

class UpdatePricesPercentsAction
{
    public function run(Apartment $apartment, float $fromPercents, float $toPercents): void
    {
        $multiplier = (1 + $toPercents / 100) / (1 + $fromPercents / 100);

        $apartment->update([
            'weekdays_price' => $apartment->weekdays_price * $multiplier,
            'weekends_price' => $apartment->weekends_price * $multiplier,
        ]);

        foreach ($apartment->datePrices as $datePrice) {
            $datePrice->update([
                'price' => $datePrice->price * $multiplier,
            ]);
        }
    }
}

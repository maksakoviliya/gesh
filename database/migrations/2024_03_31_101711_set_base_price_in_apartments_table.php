<?php

declare(strict_types=1);

use App\Models\Apartment;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        foreach (Apartment::all() as $apartment) {
            if (!$apartment->base_weekdays_price) {
                $apartment->base_weekdays_price = $apartment->weekdays_price;
            }
            if (!$apartment->base_weekends_price) {
                $apartment->base_weekends_price = $apartment->weekends_price;
            }
            $apartment->weekdays_price = ceil($apartment->weekdays_price * 1.15);
            $apartment->weekends_price = ceil($apartment->weekends_price * 1.15);
            $apartment->save();
        }
    }

    public function down(): void
    {
        foreach (Apartment::all() as $apartment) {
            $apartment->base_weekdays_price = null;
            $apartment->base_weekends_price = null;
        }
    }
};

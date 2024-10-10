<?php

declare(strict_types=1);

use App\Models\Apartment;
use App\Models\DisabledDate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disabled_dates', function (Blueprint $table) {
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->dateTime('date')->nullable()->change();
        });

        $apartments = Apartment::query()
            ->whereHas('disabledDates')
            ->get();
        foreach ($apartments as $apartment) {
            $segments = [];
            $dates = $apartment->disabledDates()->orderBy('date')->get();

            $start = null;
            $end = null;

            foreach ($dates as $date) {
                if ($start === null) {
                    $start = $date->date->startOfDay()->hours(15);
                } elseif ($end->diff($date->date->startOfDay())->days > 1) {
                    $segments[] = [
                        $start,
                        $end->addDay(),
                    ];
                    $start = $date->date->startOfDay()->hours(15);
                }
                $end = $date->date->startOfDay()->hours(12);
                $date->delete();
            }

            $segments[] = [$start, $end];
            foreach ($segments as $segment) {
                DisabledDate::query()
                    ->create([
                        'apartment_id' => $apartment->id,
                        'start' => Arr::get($segment, 0),
                        'end' => Arr::get($segment, 1),
                    ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('disabled_dates', function (Blueprint $table) {
            $table->dropColumn(['start', 'end']);
        });
    }
};

<?php

declare(strict_types=1);

use App\Models\Reservation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->unsignedInteger('first_payment');
        });

        $reservations = Reservation::all();
        foreach ($reservations as $reservation) {
            $reservation->update([
                'first_payment' => intval(ceil($reservation->price * 0.3)),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('first_payment');
        });
    }
};

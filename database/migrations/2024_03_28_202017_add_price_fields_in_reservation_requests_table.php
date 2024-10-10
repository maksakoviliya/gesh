<?php

declare(strict_types=1);

use App\Models\ReservationRequest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservation_requests', function (Blueprint $table) {
            $table->unsignedInteger('first_payment');
        });

        $reservationRequests = ReservationRequest::all();
        foreach ($reservationRequests as $reservationRequest) {
            $reservationRequest->update([
                'first_payment' => intval(ceil($reservationRequest->price * 0.3)),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('reservation_requests', function (Blueprint $table) {
            $table->dropColumn('first_payment');
        });
    }
};

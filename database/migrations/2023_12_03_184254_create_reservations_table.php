<?php

declare(strict_types=1);

use App\Enums\Reservation\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->ulid('id');

            $table->foreignUlid('user_id');
            $table->foreignUlid('apartment_id');
            $table->foreignUlid('reservation_request_id')->nullable();

            $table->dateTime('start');
            $table->dateTime('end');
            $table->unsignedSmallInteger('guests');
            $table->unsignedSmallInteger('children');
            $table->unsignedSmallInteger('total_guests');
            $table->unsignedSmallInteger('range');
            $table->unsignedInteger('price');

            $table->string('status')->default(Status::Pending);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};

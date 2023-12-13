<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('side_reservations', function (Blueprint $table) {
            $table->ulid('id');

            $table->foreignUlid('apartment_id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->text('description')->nullable();
            $table->string('summary')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('side_reservations');
    }
};

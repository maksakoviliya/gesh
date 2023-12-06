<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservation_requests', function (Blueprint $table) {
            $table->ulid('id');

            $table->foreignUlid('apartment_id');
            $table->foreignUlid('user_id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->unsignedSmallInteger('guests');
            $table->unsignedSmallInteger('children');
            $table->unsignedSmallInteger('total_guests');
            $table->unsignedSmallInteger('range');
            $table->unsignedInteger('price');

            $table->string('status')->nullable();
            $table->string('status_text')->nullable();
            $table->foreignUlid('reservation_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservation_requests');
    }
};

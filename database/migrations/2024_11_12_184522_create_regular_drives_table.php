<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regular_drives', function (Blueprint $table) {
            $table->ulid('id');

            $table->string('status');
            $table->string('name');
            $table->dateTime('start_at');
            $table->text('description')->nullable();
            $table->unsignedInteger('passengers_limit');
            $table->unsignedInteger('duration');
            $table->unsignedInteger('regular_price');
            $table->string('start_point');
            $table->string('start_lat')->nullable();
            $table->string('start_lon')->nullable();
            $table->string('finish_point');
            $table->string('finish_lat')->nullable();
            $table->string('finish_lon')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regular_drives');
    }
};

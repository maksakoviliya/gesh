<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disabled_dates', function (Blueprint $table) {
            $table->id();

            $table->foreignUlid('apartment_id');
            $table->dateTime('date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disabled_dates');
    }
};

<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('date_prices', function (Blueprint $table) {
            $table->id();

            $table->foreignUlid('apartment_id');
            $table->dateTime('date');
            $table->integer('price');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('date_prices');
    }
};

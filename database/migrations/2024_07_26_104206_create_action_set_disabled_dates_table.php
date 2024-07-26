<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('action_set_disabled_dates', function (Blueprint $table) {
            $table->id();

            $table->foreignUuid('user_id');
            $table->foreignUuid('apartment_id');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('action_set_disabled_dates');
    }
};

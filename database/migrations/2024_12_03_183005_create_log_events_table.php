<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_events', function (Blueprint $table) {
            $table->id();

            $table->foreignUlid('user_id');
            $table->string('name');
            $table->json('data_before')->nullable();
            $table->json('data_after')->nullable();
            $table->string('eventable_type')->nullable();
            $table->foreignUlid('eventable_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_events');
    }
};

<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drive_user', function (Blueprint $table) {
            $table->id();

            $table->foreignUlid('drive_id');
            $table->foreignUlid('user_id');
            $table->string('status');
            $table->dateTime('start_at')->nullable();
            $table->string('place')->nullable();
            $table->unsignedInteger('seats_count')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drive_user');
    }
};

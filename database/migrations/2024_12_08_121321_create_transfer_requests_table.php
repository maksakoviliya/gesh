<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignUlid('user_id');
            $table->string('type');
            $table->dateTime('start_at')->nullable();
            $table->unsignedInteger('passengers_count')->nullable();
            $table->string('status');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_requests');
    }
};

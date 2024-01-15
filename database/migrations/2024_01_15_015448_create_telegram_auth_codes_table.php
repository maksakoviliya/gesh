<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('telegram_auth_codes', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->foreignUlid('user_id');
            $table->foreignUlid('chat_id');
            $table->dateTime('expires_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_auth_codes');
    }
};

<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avito_access_token')->nullable();
            $table->string('avito_refresh_token')->nullable();
            $table->unsignedInteger('avito_user_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avito_access_token', 'avito_refresh_token', 'avito_user_id']);
        });
    }
};

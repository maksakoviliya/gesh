<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->unsignedInteger('base_weekdays_price')->nullable();
            $table->unsignedInteger('base_weekends_price')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->dropColumn([
                'base_weekdays_price',
                'base_weekends_price',
            ]);
        });
    }
};

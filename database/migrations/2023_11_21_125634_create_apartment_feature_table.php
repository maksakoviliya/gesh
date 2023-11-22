<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apartment_feature', function (Blueprint $table) {
            $table->foreignUlid('apartment_id');
            $table->foreignUlid('feature_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apartment_feature');
    }
};

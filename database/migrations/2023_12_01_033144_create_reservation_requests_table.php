<?php

declare(strict_types=1);

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('reservation_requests', function (Blueprint $table) {
            $table->ulid('id');

            $table->foreignUlid('apartment_id');
            $table->foreignUlid('user_id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->unsignedSmallInteger('guests');
            $table->unsignedSmallInteger('children');
            $table->unsignedSmallInteger('total_guests');
            $table->unsignedSmallInteger('range');
            $table->unsignedInteger('price');

            $table->string('status')->nullable();
            $table->string('status_text')->nullable();
            $table->foreignUlid('reservation_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_requests');
    }
};

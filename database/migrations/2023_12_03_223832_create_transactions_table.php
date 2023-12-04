<?php

declare(strict_types=1);

use App\Enums\Transactions\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignUlid('reservation_id');
            $table->unsignedInteger('amount');
            $table->foreignUlid('user_id');
            $table->string('status')->default(Status::Pending);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

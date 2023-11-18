<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->ulid('id');

            $table->string('status');
            $table->unsignedSmallInteger('step')->default(1);
            $table->foreignIdFor(User::class);

            // Step 1
            $table->foreignIdFor(Category::class)->nullable();

            // Step 2
            $table->string('type')->nullable();

            // Step 3
            $table->string('country_code')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('building')->nullable();
            $table->string('housing')->nullable();
            $table->string('room')->nullable();
            $table->string('floor')->nullable();
            $table->string('entrance')->nullable();
            $table->string('index')->nullable();

            // Step 4
            $table->string('lon')->nullable();
            $table->string('lat')->nullable();

            // Step 5
            $table->smallInteger('guests')->nullable();
            $table->smallInteger('bedrooms')->nullable();
            $table->smallInteger('beds')->nullable();
            $table->smallInteger('bathrooms')->nullable();

            // Step 6
            // Features

            // Step 7
            // Photos

            // Step 8
            $table->string('title')->nullable();

            // Step 9
            // Tags

            // Step 10
            $table->text('description')->nullable();

            // Step 11
            $table->unsignedInteger('price')->nullable();

            // Step 12
            // Sales

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appartments');
    }
};

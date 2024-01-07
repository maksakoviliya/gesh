<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('title_single')->nullable();
        });

        $categories = \App\Models\Category::all();
        foreach ($categories as $category) {
            $title = match ($category->title) {
                'Дома' => 'Дом',
                'Квартиры' => 'Квартира',
                'Апартаменты' => 'Апартаменты',
                'Коттеджи' => 'Коттедж',
                'Шале' => 'Шале',
                default => $category->title,
            };
            $category->update([
                'title_single' => $title,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('title_single');
        });
    }
};

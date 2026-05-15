<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
        $table->id();
        $table->string('title');           // Название
        $table->string('author');          // Автор
        $table->decimal('price', 8);    // Цена, 8 цифр всего, 2 после запятой
        $table->string('image');           // Путь к картинке
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

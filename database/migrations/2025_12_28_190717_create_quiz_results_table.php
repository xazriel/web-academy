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
    Schema::create('quiz_results', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke user yang mengerjakan
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // Menghubungkan ke academy/kursus terkait
        $table->foreignId('academy_id')->constrained()->onDelete('cascade');
        // Menyimpan skor (misal: 0-100)
        $table->integer('score');
        // Menyimpan berapa banyak jawaban yang benar (opsional, untuk statistik)
        $table->integer('correct_answers')->default(0);
        $table->integer('total_questions');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};

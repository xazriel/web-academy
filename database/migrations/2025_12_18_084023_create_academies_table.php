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
        Schema::create('academies', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Contoh: Lighting Unreal: Basic
            $table->string('slug')->unique();
            $table->string('category'); // LRC atau Animation
            $table->integer('price'); // Contoh: 150000
            $table->string('instructor_name'); // Dawa'i Fathulwally
            $table->string('instructor_role')->nullable(); // Founder of Dream Ratio Studio
            $table->text('description')->nullable(); // Penjelasan singkat mengenai kursus
            $table->string('thumbnail')->nullable(); // Cover image kursus
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academies');
    }
};

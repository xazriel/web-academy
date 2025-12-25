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
    Schema::table('users', function (Blueprint $table) {
        // Cek satu per satu sebelum menambah
        if (!Schema::hasColumn('users', 'gender')) {
            $table->enum('gender', ['male', 'female', 'private'])->nullable();
        }
        if (!Schema::hasColumn('users', 'birth_date')) {
            $table->date('birth_date')->nullable();
        }
        if (!Schema::hasColumn('users', 'city')) {
            $table->string('city')->nullable();
        }
        if (!Schema::hasColumn('users', 'occupation_status')) {
            $table->string('occupation_status')->nullable(); 
        }
        if (!Schema::hasColumn('users', 'school_level')) {
            $table->string('school_level')->nullable(); 
        }
        if (!Schema::hasColumn('users', 'institution_name')) {
            $table->string('institution_name')->nullable(); 
        }
        if (!Schema::hasColumn('users', 'major')) {
            $table->string('major')->nullable(); 
        }
        if (!Schema::hasColumn('users', 'company_name')) {
            $table->string('company_name')->nullable();
        }
        if (!Schema::hasColumn('users', 'job_title')) {
            $table->string('job_title')->nullable();
        }
        if (!Schema::hasColumn('users', 'about_me')) {
            $table->text('about_me')->nullable();
        }
        if (!Schema::hasColumn('users', 'interests')) {
            $table->text('interests')->nullable();
        }
        if (!Schema::hasColumn('users', 'portfolio_link')) {
            $table->string('portfolio_link')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};

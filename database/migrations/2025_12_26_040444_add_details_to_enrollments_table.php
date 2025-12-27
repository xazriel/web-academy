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
    Schema::table('enrollments', function (Blueprint $table) {
        // Kita tambah kolom yang absen
        if (!Schema::hasColumn('enrollments', 'enrolled_at')) {
            $table->timestamp('enrolled_at')->nullable()->after('academy_id');
        }
        if (!Schema::hasColumn('enrollments', 'progress_percent')) {
            $table->integer('progress_percent')->default(0)->after('status');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn(['enrolled_at', 'progress_percent']);
        });
    }
};

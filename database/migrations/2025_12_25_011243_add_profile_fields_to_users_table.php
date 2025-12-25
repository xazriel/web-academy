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
        $table->string('phone_number')->nullable()->after('email');
        $table->string('gender')->nullable()->after('phone_number'); // Jenis Kelamin
        $table->string('institution')->nullable()->after('gender'); // Pekerjaan/Instansi
        $table->text('address')->nullable()->after('institution'); // Alamat (Gunakan text jika panjang)
        $table->date('birth_date')->nullable()->after('address'); // Tanggal Lahir
        $table->string('avatar')->nullable()->after('birth_date'); // Foto Profil
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['phone_number', 'institution', 'address']);
        });
    }
};

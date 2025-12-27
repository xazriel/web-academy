<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Academy;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function enroll($academy_id)
    {
        $user = Auth::user();

        // 1. Cek profil menggunakan nama kolom yang BENAR di database kamu
        // Kita pakai 'phone' dan 'occupation_status' sesuai dump DB kamu tadi
        if (empty($user->phone) || empty($user->occupation_status)) {
            // PERBAIKAN: Nama route yang benar adalah 'profile.edit'
            return redirect()->route('profile.edit')->with('warning', 'Lengkapi profil dulu sebelum gabung kelas! 👍');
        }

        // 2. Cek apakah sudah pernah daftar
        $alreadyEnrolled = Enrollment::where('user_id', $user->id)
                                    ->where('academy_id', $academy_id)
                                    ->first();

        if ($alreadyEnrolled) {
            return redirect()->route('user.course', $academy_id)->with('info', 'Kamu sudah terdaftar di kelas ini.');
        }

        // 3. Simpan data Enrollment
        Enrollment::create([
            'user_id' => $user->id,
            'academy_id' => $academy_id,
            'enrolled_at' => now(),
            'status' => 'active',
            'progress_percent' => 0,
        ]);

        // 4. Redirect ke halaman belajar
        return redirect()->route('user.course', $academy_id)->with('success', 'Berhasil bergabung! Selamat belajar! 🚀');
    }
}
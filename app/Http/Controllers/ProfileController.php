<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Menampilkan halaman form pelengkapan profil
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    // Menyimpan data profil baru
    public function update(Request $request)
    {
        $user = Auth::user();

       $validated = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'nullable|string|max:255|unique:users,username,'.$user->id,
        'phone' => 'nullable|string|max:20',
        'gender' => 'nullable|in:male,female,private',
        'birth_date' => 'nullable|date',
        'city' => 'nullable|string|max:255',
        'occupation_status' => 'nullable|string',
        'school_level' => 'nullable|string',
        'institution_name' => 'nullable|string',
        'major' => 'nullable|string',
        'company_name' => 'nullable|string',
        'job_title' => 'nullable|string',
        'about_me' => 'nullable|string',
        'interests' => 'nullable|string',
        'portfolio_link' => 'nullable|url',
    ]);

        $user->update($validated);

        // Setelah sukses, arahkan ke dashboard
        return redirect()->route('user.home')->with('success', '👍');
    }

    public function showPublic($id)
{
    // 1. Ambil data user beserta sertifikatnya (tanpa memanggil 'profile' karena tidak ada)
    $user = \App\Models\User::with(['certificates.academy'])->findOrFail($id);

    // 2. Ambil jumlah kursus yang diikuti (enrollments)
    $coursesCount = \App\Models\Enrollment::where('user_id', $id)->count();

    // 3. Ambil jumlah materi yang sudah diselesaikan (jika relasi sudah ada di model User)
    // Jika belum ada relasi completedLessons, biarkan 0 dulu atau sesuaikan
    $completedLessonsCount = method_exists($user, 'completedLessons') 
        ? $user->completedLessons()->count() 
        : 0;

    // 4. Pastikan path view benar (kamu tadi pakai user.profile.public)
    return view('profile.public', compact('user', 'coursesCount', 'completedLessonsCount'));
}
}
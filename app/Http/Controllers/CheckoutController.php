<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index($slug)
    {
        $academy = Academy::where('slug', $slug)->firstOrFail();
        
        // Cek jika user sudah terdaftar, langsung arahkan ke kelas
        $isEnrolled = Enrollment::where('user_id', Auth::id())
                                ->where('academy_id', $academy->id)
                                ->exists();
        
        if ($isEnrolled) {
            return redirect()->route('user.course', $academy->id);
        }

        return view('user.checkout', compact('academy'));
    }

    public function store(Request $request, $id)
    {
        // Simulasi Pembayaran Berhasil
        // Di masa depan, bagian ini akan diganti dengan notifikasi dari Midtrans
        Enrollment::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'academy_id' => $id,
            ],
            [
                'status' => 'active',
                'enrolled_at' => now(),
            ]
        );

        return redirect()->route('user.course', $id)
                         ->with('success', 'Pembayaran berhasil! Selamat belajar di ARC ACADEMY.');
    }
}
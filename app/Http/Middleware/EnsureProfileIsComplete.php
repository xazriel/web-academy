<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureProfileIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Tentukan kolom mana saja yang WAJIB diisi
            // Jika salah satu kosong, maka dianggap tidak lengkap
            if (empty($user->phone_number) || empty($user->institution) || empty($user->gender)) {
                
                // Supaya tidak terjadi error "Too many redirects", 
                // pastikan middleware tidak memblokir saat user sudah berada di halaman profil atau logout
                if (!$request->is('profile*') && !$request->is('logout')) {
                    return redirect()->route('profile.edit')
                        ->with('warning', 'Selesaikan profilmu dulu yuk untuk lanjut ke ARC Academy!');
                }
            }
        }

        return $next($request);
    }
}
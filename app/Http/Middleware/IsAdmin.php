<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
{
    // Cukup panggil isAdmin() yang sudah kita definisikan di model
    if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);
    }

    abort(403, 'Akses ditolak. Anda bukan Admin.');
}
}

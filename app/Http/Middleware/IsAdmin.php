<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login?
        // Jika belum, paksa ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah Role-nya Admin?
        // Jika Admin, silakan lanjut (akses diberikan)
        if (Auth::user()->role === 'admin') {
            return $next($request);
        }

        // 3. Jika user login tapi BUKAN Admin (misal: Pegawai coba masuk URL admin)
        // Daripada error 403, lebih baik kita arahkan ke dashboard pegawai.
        // Ini mencegah error "Page Expired" atau kebingungan user.
        return redirect()->route('pegawai.dashboard');
    }
}
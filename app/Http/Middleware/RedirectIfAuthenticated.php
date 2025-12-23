<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                
                // --- LOGIKA MENCEGAH LOOPING ---
                // Jika user sudah login tapi mencoba akses halaman Guest (seperti Login),
                // Jangan biarkan! Lempar langsung ke Dashboard mereka.
                
                $role = Auth::user()->role;

                if ($role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } 
                
                if ($role === 'pegawai') {
                    return redirect()->route('pegawai.dashboard');
                }

                // Jika role tidak valid, logout & kembali ke login
                Auth::logout();
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
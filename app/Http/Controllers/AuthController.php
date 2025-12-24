<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Tampilkan Halaman Login
    public function showLoginForm()
    {
        // Cegah user yang sudah login mengakses halaman login lagi
        if (Auth::check()) {
            return $this->redirectUser();
        }
        return view('auth.login');
    }

    // 2. Proses Login (Support NIP atau NIK)
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'nip'      => 'required|string', // Field di form login bernama 'nip'
            'password' => 'required|string',
        ]);

        // Ambil input
        $identity = $request->nip;
        $password = $request->password;
        $remember = $request->has('remember');

        // --- LOGIKA LOGIN ROBUST ---
        
        // Percobaan 1: Login menggunakan NIP
        if (Auth::attempt(['nip' => $identity, 'password' => $password], $remember)) {
            return $this->handleSuccessfulLogin($request);
        }

        // Percobaan 2: Login menggunakan NIK (Jika NIP gagal)
        if (Auth::attempt(['nik' => $identity, 'password' => $password], $remember)) {
            return $this->handleSuccessfulLogin($request);
        }

        // --- JIKA KEDUANYA GAGAL ---
        
        return back()->withErrors([
            'nip' => 'NIP/NIK atau password salah.',
        ])->onlyInput('nip');
    }

    // 3. Helper: Menangani Login Berhasil
    protected function handleSuccessfulLogin(Request $request)
    {
        $request->session()->regenerate();
        return $this->redirectUser();
    }

    // 4. Helper: Redirect User Sesuai Role
    protected function redirectUser()
    {
        // Pastikan user terautentikasi sebelum mengakses properti role
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $role = Auth::user()->role;

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        
        if ($role === 'pegawai') {
            return redirect()->route('pegawai.dashboard');
        }

        // Jika role tidak dikenali, logout paksa untuk keamanan
        Auth::logout();
        return redirect()->route('login')->with('error', 'Role akun tidak valid. Hubungi administrator.');
    }

    // 5. Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
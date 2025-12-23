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
        // Validasi
        $request->validate([
            'nip'      => 'required|string', 
            'password' => 'required|string', 
        ]);

        // Ambil kredensial
        $identity = $request->nip;
        $password = $request->password;
        $remember = $request->has('remember');

        // Tentukan apakah input ini NIK atau NIP (Cek panjang string atau is_numeric)
        // NIK biasanya 16 digit, NIP 18 digit.
        $fieldType = strlen($identity) == 16 ? 'nik' : 'nip';

        // Coba Login sekali saja sesuai tipe yang terdeteksi
        if (Auth::attempt([$fieldType => $identity, 'password' => $password], $remember)) {
            return $this->handleSuccessfulLogin($request);
        }

        // Jika tipe tidak terdeteksi pasti (misal panjangnya aneh), bisa fallback ke cara lama (cek dua kali)
        // Tapi cara di atas lebih efisien database query-nya.

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
    // (Fungsi ini dipakai juga oleh Middleware agar konsisten)
    protected function redirectUser()
    {
        $role = Auth::user()->role;

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        
        if ($role === 'pegawai') {
            return redirect()->route('pegawai.dashboard');
        }

        // Jika role aneh/tidak dikenal, logout paksa
        Auth::logout();
        return redirect()->route('login')->with('error', 'Role akun tidak dikenali.');
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
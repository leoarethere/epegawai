<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SettingController;
use App\Http\Middleware\IsAdmin; 

/*
|--------------------------------------------------------------------------
| Web Routes - E-Data Pegawai TVRI
|--------------------------------------------------------------------------
*/

// ====================================================
// 1. RUTE UNTUK TAMU (Belum Login)
// ====================================================
Route::middleware('guest')->group(function () {
    
    // Halaman Utama langsung lempar ke Login
    Route::get('/', function () {
        return redirect()->route('login');
    });

    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']); 
    
});

// ====================================================
// 2. RUTE UNTUK USER YANG SUDAH LOGIN (Umum)
// ====================================================
Route::middleware('auth')->group(function () {
    
    // Fitur Logout (Bisa diakses siapa saja yang sudah login)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ----------------------------------------------------
    // A. AREA PEGAWAI
    // ----------------------------------------------------
    Route::prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('/dashboard', [PegawaiController::class, 'index'])->name('dashboard');
    });

    // ----------------------------------------------------
    // B. AREA KHUSUS ADMIN
    // ----------------------------------------------------
    // Menggunakan Middleware IsAdmin, Prefix URL '/admin', dan Prefix Nama Route 'admin.'
    Route::middleware(IsAdmin::class)->prefix('admin')->name('admin.')->group(function () {
        
        // 1. Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        // 2. CRUD Pegawai (Resource Manual)
        Route::get('/pegawai/create', [AdminController::class, 'create'])->name('create');
        Route::post('/pegawai', [AdminController::class, 'store'])->name('store');
        Route::get('/pegawai/{id}', [AdminController::class, 'show'])->name('show');
        Route::get('/pegawai/{id}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/pegawai/{id}', [AdminController::class, 'update'])->name('update');
        Route::delete('/pegawai/{id}', [AdminController::class, 'destroy'])->name('destroy'); 

        // 3. Pengaturan Tampilan (Background & Logo)
        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        
        // Kita gunakan satu route update untuk menangani semua input (Logo & Background)
        // Pastikan nama method di SettingController adalah 'updateBackground' atau sesuaikan
        Route::post('/settings', [SettingController::class, 'updateBackground'])->name('settings.update');
        
    });

});
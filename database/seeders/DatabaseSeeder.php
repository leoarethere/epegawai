<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Panggil Seeder Dummy Pegawai (100 Data)
        // Pastikan UserSeeder sudah kamu buat di langkah sebelumnya
        $this->call([
            UserSeeder::class,
        ]);

        // 2. Buat Akun Admin Manual (PENTING: Agar bisa login Admin)
        // Kita cek dulu biar tidak error duplicate entry
        if (!User::where('role', 'admin')->exists()) {
            User::create([
                'nama_lengkap' => 'Administrator Utama',
                'nik' => '1234567891234567', // NIK Admin Dummy
                'nip' => 'admin123',         // NIP Admin Login
                'password' => Hash::make('password123'), // Password Admin
                'role' => 'admin',
                
                // Data Pelengkap (Biar tidak error validasi database)
                'status_pegawai' => 'Tetap',
                'jenis_kelamin' => 'Laki-laki',
                'status_operasional' => 'Aktif',
                'email' => 'admin@tvri.com',
                'bagian' => 'Kepala Stasiun'
            ]);
        }
    }
}
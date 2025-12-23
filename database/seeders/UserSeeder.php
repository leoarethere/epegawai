<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan data dummy Indonesia

        for ($i = 0; $i < 100; $i++) {
            
            // Menentukan jenis kelamin random agar nama sesuai
            $genderOption = $faker->randomElement(['Laki-laki', 'Perempuan']);
            $genderFaker = ($genderOption == 'Laki-laki') ? 'male' : 'female';

            // Generate Tanggal Lahir (Usia 22-60 tahun)
            $tanggalLahir = $faker->dateTimeBetween('-60 years', '-22 years');
            $usia = date('Y') - $tanggalLahir->format('Y');

            User::create([
                // Data Akun
                'nama_lengkap' => $faker->name($genderFaker),
                'nik' => $faker->unique()->numerify('################'), // 16 Digit
                'nip' => $faker->unique()->numerify('##################'), // 18 Digit
                'password' => Hash::make('password'), // Password default: password
                'role' => 'pegawai', // Default pegawai

                // Data Kepegawaian
                'status_pegawai' => $faker->randomElement(['Tetap', 'Kontrak', 'CPNS']),
                'kelas_jabatan' => $faker->numberBetween(5, 12),
                'jenis_kelamin' => $genderOption,
                'jabatan' => $faker->jobTitle,
                'bagian' => $faker->randomElement(['SDM', 'Keuangan', 'Media', 'Teknik', 'Berita', 'Tata Usaha']),
                
                // Data Pribadi
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $tanggalLahir->format('Y-m-d'),
                'alamat_ktp' => $faker->address,
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'status_keluarga' => $faker->randomElement(['Menikah', 'Belum Menikah', 'Cerai']),
                'nama_ibu_kandung' => $faker->name('female'),
                'pendidikan' => $faker->randomElement(['SMA', 'D3', 'S1', 'S2']),
                
                // Data Administratif
                'status_operasional' => 'Aktif',
                'golongan_pangkat' => $faker->randomElement(['II/a', 'II/b', 'III/a', 'III/b', 'IV/a']),
                'npwp' => $faker->numerify('###############'), // 15 Digit
                'tmt_pensiun' => $faker->dateTimeBetween('+1 years', '+10 years')->format('Y-m-d'),
                'telepon' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'usia' => $usia,
                'link_dokumen' => null, // Dikosongkan dulu
            ]);
        }
    }
}
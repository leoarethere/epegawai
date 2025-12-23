<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_lengkap',
        'nik',
        'nip',
        'password',
        'role',
        'foto_profil',
        'status_pegawai',
        'jabatan',         // Pastikan ada
        'bagian',          // Pastikan ada
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_ktp',
        'agama',
        'telepon',
        'email',
        'status_operasional',

        // --- DOKUMEN DIGITAL (SESUAIKAN DENGAN ADMIN CONTROLLER) ---
        'doc_ktp', 
        'doc_kk', 
        'doc_npwp', 
        'doc_akta_kelahiran', // Jika ada di controller/view
        'doc_akta_nikah',
        'doc_akta_anak_folder', 

        // GANTI KOLOM IJAZAH LAMA DENGAN FOLDER
        'doc_folder_ijazah', 

        // TAMBAHAN BARU
        'doc_jenis_sk',
        'doc_link_sk',
        'doc_sk_naik_pangkat',
        'doc_sertifikat_diklat',
        'doc_file_pendukung',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'tmt_pensiun'   => 'date',
        'password'      => 'hashed',
    ];
}
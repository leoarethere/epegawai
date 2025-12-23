<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel Users (Sesuai kebutuhan TVRI)
        Schema::create('users', function (Blueprint $table) {
            $table->id(); 
            
            // Data Akun & Identitas Utama
            $table->string('nama_lengkap', 150);
            $table->char('nik', 16)->unique();
            $table->char('nip', 18)->unique()->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'pegawai'])->default('pegawai');
            
            // Data Kepegawaian
            $table->enum('status_pegawai', ['Tetap', 'Kontrak', 'CPNS']);
            $table->string('kelas_jabatan', 50)->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('jabatan', 100)->nullable();
            $table->string('bagian', 100)->nullable();
            
            // Data Pribadi
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat_ktp')->nullable();
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])->nullable();
            $table->enum('status_keluarga', ['Menikah', 'Belum Menikah', 'Cerai'])->nullable();
            $table->string('nama_ibu_kandung', 150)->nullable();
            $table->string('pendidikan', 100)->nullable();
            
            // Data Administratif
            $table->enum('status_operasional', ['Aktif', 'Non-Aktif'])->default('Aktif');
            $table->string('golongan_pangkat', 50)->nullable();
            $table->char('npwp', 15)->nullable();
            $table->date('tmt_pensiun')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->integer('usia')->nullable();
            $table->string('link_dokumen', 255)->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Tabel Password Reset Tokens (Bawaan Laravel)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 3. Tabel Sessions (INI YANG HILANG SEBELUMNYA)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
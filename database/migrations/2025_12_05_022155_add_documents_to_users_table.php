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
        Schema::table('users', function (Blueprint $table) {
            
            // --- [PENTING] PERBAIKAN STATUS PEGAWAI ---
            // Mengubah tipe kolom jadi STRING agar bisa menerima "PNS", "CPNS", "PPPK", "KONTRAK"
            // Ini solusi untuk error "Data truncated" yang tadi muncul.
            $table->string('status_pegawai')->change(); 
            // ------------------------------------------

            // 1. Dokumen Identitas Dasar
            $table->string('doc_ktp')->nullable();
            $table->string('doc_kk')->nullable();
            $table->string('doc_npwp')->nullable();
            $table->string('doc_akta_kelahiran')->nullable();
            $table->string('doc_akta_nikah')->nullable();
            
            // 2. Folder Dokumen Keluarga
            $table->string('doc_akta_anak_folder')->nullable(); 

            // 3. Folder Ijazah (1 Kolom Folder)
            $table->string('doc_folder_ijazah')->nullable();

            // 4. Dokumen SK (Jenis & Link)
            $table->string('doc_jenis_sk')->nullable(); 
            $table->string('doc_link_sk')->nullable();
            
            // 5. Dokumen Tambahan (Naik Pangkat, Diklat, Lainnya)
            $table->string('doc_sk_naik_pangkat')->nullable(); 
            $table->string('doc_sertifikat_diklat')->nullable();
            $table->string('doc_file_pendukung')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom-kolom baru jika di-rollback
            $table->dropColumn([
                'doc_ktp', 
                'doc_kk', 
                'doc_npwp', 
                'doc_akta_kelahiran', 
                'doc_akta_nikah',
                'doc_akta_anak_folder',
                'doc_folder_ijazah',    
                'doc_jenis_sk',         
                'doc_link_sk',          
                'doc_sk_naik_pangkat',
                'doc_sertifikat_diklat',
                'doc_file_pendukung'
            ]);
            
            // Catatan: Kita biarkan status_pegawai tetap string saat rollback 
            // agar data tidak rusak/hilang.
        });
    }
};
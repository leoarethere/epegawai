@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
    
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Tambah Pegawai Baru</h2>
        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-blue-600 text-sm">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Terjadi Kesalahan!</p>
            <ul class="list-disc ml-5 text-sm mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- BAGIAN A: IDENTITAS AKUN --}}
        <h3 class="text-lg font-semibold text-blue-800 border-b pb-2 mb-4">A. Identitas Akun</h3>
        
        <div class="flex flex-col md:flex-row gap-6 mb-4">
            {{-- Foto Profil --}}
            <div class="w-full md:w-1/4">
                <label class="block mb-2 font-medium text-gray-700 text-sm">Foto Profil</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:bg-gray-50 transition flex flex-col items-center justify-center h-40">
                    <input type="file" name="foto_profil" class="block w-full text-xs text-gray-500
                        file:mr-2 file:py-1 file:px-2
                        file:rounded-full file:border-0
                        file:text-xs file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100 cursor-pointer mx-auto" accept="image/*">
                    <p class="text-[10px] text-gray-400 mt-2">Max 2MB. Rasio 1:1.</p>
                </div>
            </div>
            
            {{-- Form Identitas --}}
            <div class="w-full md:w-3/4 space-y-3">
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-medium text-gray-700 text-sm">NIK (KTP) <span class="text-red-500">*</span></label>
                        <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="16 Digit" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-gray-700 text-sm">NIP (Opsional)</label>
                        <input type="text" name="nip" value="{{ old('nip') }}" maxlength="18" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="18 Digit">
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN B: DATA PRIBADI --}}
        <h3 class="text-lg font-semibold text-blue-800 border-b pb-2 mb-4 mt-8">B. Data Pribadi</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div><label class="block mb-1 font-medium text-gray-700 text-sm">Tempat Lahir</label><input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"></div>
            <div><label class="block mb-1 font-medium text-gray-700 text-sm">Tanggal Lahir</label><input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Jenis Kelamin *</label>
                <select name="jenis_kelamin" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Agama</label>
                <select name="agama" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white">
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Buddha">Buddha</option>
                    <option value="Konghucu">Konghucu</option>
                </select>
            </div>
        </div>

        {{-- BAGIAN C: DATA KEPEGAWAIAN --}}
        <h3 class="text-lg font-semibold text-blue-800 border-b pb-2 mb-4 mt-8">C. Data Kepegawaian</h3>
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700 text-sm">Status Pegawai *</label>
            <select name="status_pegawai" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white" required>
                <option value="" disabled selected>-- Pilih Status --</option>
                <option value="CPNS">CPNS</option>
                <option value="PNS">PNS</option>
                <option value="PPPK">PPPK</option>
                <option value="KONTRAK">KONTRAK</option>
            </select>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div><label class="block mb-1 font-medium text-gray-700 text-sm">Jabatan</label><input type="text" name="jabatan" value="{{ old('jabatan') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"></div>
            <div><label class="block mb-1 font-medium text-gray-700 text-sm">Bagian / Divisi</label><input type="text" name="bagian" value="{{ old('bagian') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"></div>
        </div>
        <div class="mb-4"><label class="block mb-1 font-medium text-gray-700 text-sm">No Telepon / WA *</label><input type="number" name="telepon" value="{{ old('telepon') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" required></div>
        <div class="mb-4"><label class="block mb-1 font-medium text-gray-700 text-sm">Alamat Lengkap (KTP)</label><textarea name="alamat_ktp" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">{{ old('alamat_ktp') }}</textarea></div>


        {{-- BAGIAN D: LINK DOKUMEN DIGITAL --}}
        <h3 class="text-lg font-semibold text-blue-800 border-b pb-2 mb-4 mt-8">D. Link Dokumen Digital (Google Drive)</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- 1. IDENTITAS --}}
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link KTP</label>
                <input type="url" name="doc_ktp" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link Kartu Keluarga</label>
                <input type="url" name="doc_kk" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link NPWP</label>
                <input type="url" name="doc_npwp" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Akta Nikah</label>
                <input type="url" name="doc_akta_nikah" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div class="md:col-span-2">
                {{-- Label Ganti: "Link Folder Akta Anak" --}}
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link Folder Akta Anak</label>
                <input type="url" name="doc_akta_anak_folder" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>

            {{-- 2. IJAZAH --}}
            <div class="md:col-span-2">
                {{-- Label Ganti: "Link Folder Ijazah" --}}
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link Folder Ijazah</label>
                <div class="flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        <i class="fas fa-folder"></i>
                    </span>
                    <input type="url" name="doc_folder_ijazah" class="flex-1 block w-full border border-gray-300 rounded-r-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Link folder yang berisi semua ijazah...">
                </div>
            </div>

            {{-- 3. SK (Dropdown + Input) --}}
            {{-- Warna diubah: bg-blue-100 dan border-blue-300 (Lebih tebal/biru) --}}
            <div class="md:col-span-2 bg-blue-100 p-4 rounded-lg border border-blue-300">
                {{-- Label Ganti: "UPLOAD SK" --}}
                <label class="block mb-2 font-bold text-blue-900 text-xs uppercase">UPLOAD SK</label>
                <div class="flex flex-col md:flex-row gap-2">
                    <select name="doc_jenis_sk" class="md:w-1/4 border border-blue-300 rounded-md px-3 py-2 text-sm bg-white focus:ring-blue-500">
                        <option value="" disabled selected>- Pilih Jenis -</option>
                        <option value="SK CPNS">SK CPNS</option>
                        <option value="SK PNS">SK PNS</option>
                        <option value="SK PPPK">SK PPPK</option>
                        <option value="SK KONTRAK">SK KONTRAK</option>
                    </select>
                    <input type="url" name="doc_link_sk" class="flex-1 border border-blue-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500" placeholder="Paste Link Google Drive SK di sini...">
                </div>
            </div>

            {{-- 4. DOKUMEN LAINNYA --}}
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">SK Kenaikan Pangkat</label>
                <input type="url" name="doc_sk_naik_pangkat" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Sertifikat Diklat</label>
                <input type="url" name="doc_sertifikat_diklat" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1 font-medium text-gray-700 text-sm">File Pendukung Lainnya</label>
                <input type="url" name="doc_file_pendukung" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-8 pt-4 border-t">
             <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow transition text-sm font-medium">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow transition text-sm font-bold">Simpan Pegawai</button>
        </div>
    </form>
</div>
@endsection
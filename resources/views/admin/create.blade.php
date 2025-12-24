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
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r" role="alert">
            <p class="font-bold">Terjadi Kesalahan!</p>
            <ul class="list-disc ml-5 text-sm mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Info Password Default -->
    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded-r" role="alert">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <p class="font-bold text-sm">Password Default</p>
                <p class="text-sm">Password login pegawai baru akan otomatis di-set sesuai dengan NIK yang diinputkan.</p>
            </div>
        </div>
    </div>

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
                    <p class="text-[10px] text-gray-400 mt-2">Max 2MB. Format: JPG/PNG</p>
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
                        <p class="text-xs text-gray-500 mt-1">NIK akan menjadi password default</p>
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
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white" required>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Agama</label>
                <select name="agama" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white">
                    <option value="">- Pilih Agama -</option>
                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                </select>
            </div>
        </div>

        {{-- BAGIAN C: DATA KEPEGAWAIAN --}}
        <h3 class="text-lg font-semibold text-blue-800 border-b pb-2 mb-4 mt-8">C. Data Kepegawaian</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Status Pegawai <span class="text-red-500">*</span></label>
                <select name="status_pegawai" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white" required>
                    <option value="" disabled selected>-- Pilih Status --</option>
                    <option value="CPNS" {{ old('status_pegawai') == 'CPNS' ? 'selected' : '' }}>CPNS</option>
                    <option value="PNS" {{ old('status_pegawai') == 'PNS' ? 'selected' : '' }}>PNS</option>
                    <option value="PPPK" {{ old('status_pegawai') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                    <option value="KONTRAK" {{ old('status_pegawai') == 'KONTRAK' ? 'selected' : '' }}>KONTRAK</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Status Operasional <span class="text-red-500">*</span></label>
                <select name="status_operasional" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white" required>
                    <option value="Aktif" {{ old('status_operasional', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Non-Aktif" {{ old('status_operasional') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Bagian / Divisi</label>
                <input type="text" name="bagian" value="{{ old('bagian') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700 text-sm">No Telepon / WA <span class="text-red-500">*</span></label>
            <input type="number" name="telepon" value="{{ old('telepon') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" required>
        </div>
        
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700 text-sm">Alamat Lengkap (KTP)</label>
            <textarea name="alamat_ktp" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">{{ old('alamat_ktp') }}</textarea>
        </div>


        {{-- BAGIAN D: LINK DOKUMEN DIGITAL --}}
        <h3 class="text-lg font-semibold text-blue-800 border-b pb-2 mb-4 mt-8">D. Link Dokumen Digital (Google Drive)</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- 1. IDENTITAS --}}
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link KTP</label>
                <input type="url" name="doc_ktp" value="{{ old('doc_ktp') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link Kartu Keluarga</label>
                <input type="url" name="doc_kk" value="{{ old('doc_kk') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link NPWP</label>
                <input type="url" name="doc_npwp" value="{{ old('doc_npwp') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Akta Nikah</label>
                <input type="url" name="doc_akta_nikah" value="{{ old('doc_akta_nikah') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link Folder Akta Anak</label>
                <input type="url" name="doc_akta_anak_folder" value="{{ old('doc_akta_anak_folder') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>

            {{-- 2. IJAZAH --}}
            <div class="md:col-span-2">
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link Folder Ijazah</label>
                <div class="flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        <i class="fas fa-folder"></i>
                    </span>
                    <input type="url" name="doc_folder_ijazah" value="{{ old('doc_folder_ijazah') }}" class="flex-1 block w-full border border-gray-300 rounded-r-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Link folder yang berisi semua ijazah...">
                </div>
            </div>

            {{-- 3. SK (Dropdown + Input) - KONSISTEN --}}
            <div class="md:col-span-2 bg-blue-100 p-4 rounded-lg border border-blue-300">
                <label class="mb-2 font-bold text-blue-900 text-xs uppercase flex items-center gap-2">
                    <i class="fas fa-file-signature"></i> UPLOAD SK KEPEGAWAIAN
                </label>
                <p class="text-xs text-blue-700 mb-3">Pilih jenis SK dan paste link Google Drive dokumen SK</p>
                <div class="flex flex-col md:flex-row gap-2">
                    <select name="doc_jenis_sk" class="md:w-1/4 border border-blue-300 rounded-md px-3 py-2 text-sm bg-white focus:ring-blue-500">
                        <option value="">- Pilih Jenis SK -</option>
                        <option value="SK CPNS" {{ old('doc_jenis_sk') == 'SK CPNS' ? 'selected' : '' }}>SK CPNS</option>
                        <option value="SK PNS" {{ old('doc_jenis_sk') == 'SK PNS' ? 'selected' : '' }}>SK PNS</option>
                        <option value="SK PPPK" {{ old('doc_jenis_sk') == 'SK PPPK' ? 'selected' : '' }}>SK PPPK</option>
                        <option value="SK KONTRAK" {{ old('doc_jenis_sk') == 'SK KONTRAK' ? 'selected' : '' }}>SK KONTRAK</option>
                    </select>
                    <input type="url" name="doc_link_sk" value="{{ old('doc_link_sk') }}" class="flex-1 border border-blue-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500" placeholder="Paste Link Google Drive SK di sini...">
                </div>
            </div>

            {{-- 4. DOKUMEN LAINNYA --}}
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">SK Kenaikan Pangkat</label>
                <input type="url" name="doc_sk_naik_pangkat" value="{{ old('doc_sk_naik_pangkat') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Sertifikat Diklat</label>
                <input type="url" name="doc_sertifikat_diklat" value="{{ old('doc_sertifikat_diklat') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1 font-medium text-gray-700 text-sm">File Pendukung Lainnya</label>
                <input type="url" name="doc_file_pendukung" value="{{ old('doc_file_pendukung') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-8 pt-4 border-t">
             <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow transition text-sm font-medium">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow transition text-sm font-bold">
                <i class="fas fa-save mr-2"></i> Simpan Pegawai
            </button>
        </div>
    </form>
</div>
@endsection
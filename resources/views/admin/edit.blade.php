@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
    
    {{-- HEADER --}}
    <div class="flex justify-between items-start mb-8 border-b pb-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-1">Form Edit Data Pegawai</h2>
            <div class="flex flex-col">
                <span class="text-3xl font-extrabold text-blue-700 mt-1">{{ $pegawai->nama_lengkap }}</span>
            </div>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-2 text-gray-500 hover:text-blue-600 text-sm font-medium transition py-2 px-4 rounded-lg hover:bg-blue-50">
            <span>&larr;</span> Kembali ke Dashboard
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r" role="alert">
            <div class="flex items-center mb-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <p class="font-bold">Gagal Menyimpan Perubahan!</p>
            </div>
            <ul class="list-disc ml-9 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') 
        
        {{-- BAGIAN A --}}
        <h3 class="text-lg font-semibold text-blue-800 border-b pb-2 mb-4">A. Identitas Akun</h3>
        
        <div class="flex flex-col md:flex-row gap-8 mb-8">
            {{-- Foto Profil --}}
            <div class="w-full md:w-1/4 flex flex-col items-center">
                <label class="block mb-3 font-bold text-gray-700 text-sm self-start">Foto Profil</label>
                
                <div class="relative group cursor-pointer mb-3">
                    @if($pegawai->foto_profil)
                        <img src="{{ asset('storage/' . $pegawai->foto_profil) }}" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg group-hover:opacity-75 transition">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 border-4 border-white shadow-lg group-hover:bg-gray-200 transition">
                            <i class="fas fa-user text-4xl"></i>
                        </div>
                    @endif
                    
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                        <i class="fas fa-camera text-gray-800 text-2xl drop-shadow-md"></i>
                    </div>
                </div>

                <div class="w-full">
                    <input type="file" name="foto_profil" class="block w-full text-xs text-slate-500
                        file:mr-2 file:py-2 file:px-3
                        file:rounded-full file:border-0
                        file:text-xs file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100 cursor-pointer mx-auto border border-gray-200 rounded-full" accept="image/*">
                    <p class="text-[10px] text-center text-gray-400 mt-2">Format: JPG/PNG. Max 2MB.</p>
                </div>
            </div>
            
            {{-- Form Identitas --}}
            <div class="w-full md:w-3/4 space-y-5">
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition shadow-sm" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700 text-sm">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $pegawai->email) }}" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition shadow-sm" required>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-1 font-medium text-gray-700 text-sm">NIK (KTP) <span class="text-red-500">*</span></label>
                        <input type="text" name="nik" value="{{ old('nik', $pegawai->nik) }}" maxlength="16" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition shadow-sm" placeholder="16 Digit" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-gray-700 text-sm">NIP (Opsional)</label>
                        <input type="text" name="nip" value="{{ old('nip', $pegawai->nip) }}" maxlength="18" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition shadow-sm" placeholder="18 Digit">
                    </div>
                </div>
                
                <div class="bg-yellow-50 p-4 rounded-md border border-yellow-200 mt-2">
                    <label class="block mb-1 font-bold text-yellow-800 text-xs uppercase">Reset Password (Opsional)</label>
                    <input type="password" name="password" class="w-full border border-yellow-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-yellow-200 focus:border-yellow-500 bg-white" placeholder="Isi hanya jika ingin mengganti password lama...">
                    <p class="text-xs text-yellow-700 mt-1"><i class="fas fa-info-circle mr-1"></i> Password harus berupa angka (PIN) minimal 6 digit</p>
                </div>
            </div>
        </div>

        {{-- BAGIAN B --}}
        <h3 class="text-lg font-semibold text-blue-800 border-b pb-2 mb-4 mt-8">B. Data Pribadi</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-4">
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm shadow-sm">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir ? $pegawai->tanggal_lahir->format('Y-m-d') : '') }}" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm shadow-sm">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-4">
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm bg-white shadow-sm" required>
                    <option value="Laki-laki" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Agama</label>
                <select name="agama" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm bg-white shadow-sm">
                    <option value="">- Pilih Agama -</option>
                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                        <option value="{{ $agama }}" {{ old('agama', $pegawai->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- BAGIAN C --}}
        <h3 class="text-lg font-semibold text-blue-800 border-b pb-2 mb-4 mt-8">C. Data Kepegawaian</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Status Pegawai <span class="text-red-500">*</span></label>
                <select name="status_pegawai" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm bg-white shadow-sm" required>
                    <option value="" disabled>-- Pilih Status --</option>
                    @foreach(['CPNS', 'PNS', 'PPPK', 'KONTRAK'] as $status)
                        <option value="{{ $status }}" {{ old('status_pegawai', $pegawai->status_pegawai) == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Status Operasional <span class="text-red-500">*</span></label>
                <select name="status_operasional" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm bg-white shadow-sm" required>
                    <option value="Aktif" {{ old('status_operasional', $pegawai->status_operasional) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Non-Aktif" {{ old('status_operasional', $pegawai->status_operasional) == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm shadow-sm">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Bagian / Divisi</label>
                <input type="text" name="bagian" value="{{ old('bagian', $pegawai->bagian) }}" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm shadow-sm">
            </div>
        </div>
        <div class="mb-5">
            <label class="block mb-1 font-medium text-gray-700 text-sm">No Telepon / WA <span class="text-red-500">*</span></label>
            <input type="number" name="telepon" value="{{ old('telepon', $pegawai->telepon) }}" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm shadow-sm" required>
        </div>
        <div class="mb-5">
            <label class="block mb-1 font-medium text-gray-700 text-sm">Alamat Lengkap (KTP)</label>
            <textarea name="alamat_ktp" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm shadow-sm">{{ old('alamat_ktp', $pegawai->alamat_ktp) }}</textarea>
        </div>


        {{-- BAGIAN D --}}
        <h3 class="text-lg font-semibold text-blue-800 border-b pb-2 mb-4 mt-8">D. Link Dokumen Digital (Google Drive)</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- 1. IDENTITAS --}}
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link KTP</label>
                <input type="url" name="doc_ktp" value="{{ old('doc_ktp', $pegawai->doc_ktp) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link Kartu Keluarga</label>
                <input type="url" name="doc_kk" value="{{ old('doc_kk', $pegawai->doc_kk) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link NPWP</label>
                <input type="url" name="doc_npwp" value="{{ old('doc_npwp', $pegawai->doc_npwp) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Akta Nikah</label>
                <input type="url" name="doc_akta_nikah" value="{{ old('doc_akta_nikah', $pegawai->doc_akta_nikah) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link Folder Akta Anak</label>
                <input type="url" name="doc_akta_anak_folder" value="{{ old('doc_akta_anak_folder', $pegawai->doc_akta_anak_folder) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>

            {{-- 2. IJAZAH --}}
            <div class="md:col-span-2">
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link Folder Ijazah</label>
                <div class="flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        <i class="fas fa-folder"></i>
                    </span>
                    <input type="url" name="doc_folder_ijazah" value="{{ old('doc_folder_ijazah', $pegawai->doc_folder_ijazah) }}" class="flex-1 block w-full border border-gray-300 rounded-r-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Link folder yang berisi semua ijazah...">
                </div>
            </div>

            {{-- 3. SK (Disederhanakan tanpa Dropdown) --}}
            <div class="md:col-span-2">
                <label class="block mb-1 font-medium text-gray-700 text-sm">Link SK Kepegawaian</label>
                <input type="url" name="doc_link_sk" value="{{ old('doc_link_sk', $pegawai->doc_link_sk) }}" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="https://drive.google.com/...">
                <p class="text-xs text-gray-500 mt-1">Tempelkan link Google Drive SK (CPNS/PNS/PPPK/Kontrak) di sini.</p>
            </div>

            {{-- 4. DOKUMEN LAINNYA --}}
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">SK Kenaikan Pangkat</label>
                <input type="url" name="doc_sk_naik_pangkat" value="{{ old('doc_sk_naik_pangkat', $pegawai->doc_sk_naik_pangkat) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700 text-sm">Sertifikat Diklat</label>
                <input type="url" name="doc_sertifikat_diklat" value="{{ old('doc_sertifikat_diklat', $pegawai->doc_sertifikat_diklat) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1 font-medium text-gray-700 text-sm">File Pendukung Lainnya</label>
                <input type="url" name="doc_file_pendukung" value="{{ old('doc_file_pendukung', $pegawai->doc_file_pendukung) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://drive.google.com/...">
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-10 pt-6 border-t">
             <a href="{{ route('admin.dashboard') }}" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition text-sm">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg shadow-md hover:shadow-lg transition text-sm font-bold flex items-center">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
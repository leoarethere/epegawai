@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden mb-10">
    
    <div class="bg-blue-600 px-6 py-4 flex justify-between items-center">
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Detail Data Pegawai
        </h2>
        <a href="{{ route('admin.dashboard') }}" class="text-blue-100 hover:text-white text-sm font-medium transition">
            &larr; Kembali
        </a>
    </div>

    <div class="p-6">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6 border-b pb-6 mb-6">
            
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center text-3xl font-bold text-gray-500 uppercase border-4 border-gray-100 shadow-sm overflow-hidden relative flex-shrink-0">
                @if($pegawai->foto_profil)
                    <img src="{{ asset('storage/' . $pegawai->foto_profil) }}" class="w-full h-full object-cover">
                @else
                    {{ substr($pegawai->nama_lengkap, 0, 1) }}
                @endif
            </div>
            
            <div class="text-center md:text-left flex-1">
                <h1 class="text-3xl font-bold text-gray-800">{{ $pegawai->nama_lengkap }}</h1>
                <p class="text-lg text-gray-600 mt-1">{{ $pegawai->jabatan }} - {{ $pegawai->bagian }}</p>
                <div class="mt-3">
                    @if($pegawai->status_operasional == 'Aktif')
                        <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full border border-green-200">Status: Aktif</span>
                    @else
                        <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded-full border border-red-200">Status: Non-Aktif</span>
                    @endif
                </div>
            </div>

            </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">

            <div>
                <h3 class="text-lg font-semibold text-blue-800 border-b-2 border-blue-100 pb-2 mb-4">A. Informasi Akun & Pekerjaan</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-bold tracking-wide">NIP</label>
                        <p class="text-gray-900 font-medium text-base">{{ $pegawai->nip ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-bold tracking-wide">NIK (KTP)</label>
                        <p class="text-gray-900 font-medium text-base">{{ $pegawai->nik }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-bold tracking-wide">Email Login</label>
                        <p class="text-gray-900 font-medium text-base">{{ $pegawai->email }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-bold tracking-wide">Status Kepegawaian</label>
                        <p class="text-gray-900 font-medium text-base">{{ $pegawai->status_pegawai }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-blue-800 border-b-2 border-blue-100 pb-2 mb-4">B. Data Pribadi</h3>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-gray-500 uppercase font-bold tracking-wide">Jenis Kelamin</label>
                            <p class="text-gray-900 font-medium text-base">{{ $pegawai->jenis_kelamin }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase font-bold tracking-wide">Agama</label>
                            <p class="text-gray-900 font-medium text-base">{{ $pegawai->agama ?? '-' }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs text-gray-500 uppercase font-bold tracking-wide">Tempat, Tanggal Lahir</label>
                        <p class="text-gray-900 font-medium text-base">
                            {{ $pegawai->tempat_lahir ?? '-' }}, 
                            {{ $pegawai->tanggal_lahir ? $pegawai->tanggal_lahir->format('d F Y') : '-' }}
                        </p>
                    </div>

                    <div>
                        <label class="text-xs text-gray-500 uppercase font-bold tracking-wide">Nomor Telepon / WA</label>
                        <p class="text-gray-900 font-medium text-base">{{ $pegawai->telepon }}</p>
                    </div>

                    <div>
                        <label class="text-xs text-gray-500 uppercase font-bold tracking-wide">Alamat KTP</label>
                        <p class="text-gray-900 font-medium text-base leading-relaxed">{{ $pegawai->alamat_ktp }}</p>
                    </div>
                </div>
            </div>

        </div>
        
        <div class="mt-10 pt-8 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-blue-800 border-b-2 border-blue-100 pb-2 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                C. Arsip Dokumen Digital
            </h3>

            @php
                $dokumens = [
                    'KTP' => 'doc_ktp',
                    'Kartu Keluarga' => 'doc_kk',
                    'NPWP' => 'doc_npwp',
                    'SK CPNS' => 'doc_sk_cpns',
                    'SK PNS / PPPK' => 'doc_sk_pns', // Konsisten dengan label di form
                    'SK Kenaikan Pangkat' => 'doc_sk_naik_pangkat',
                    'Akta Kelahiran' => 'doc_akta_kelahiran',
                    'Akta Nikah' => 'doc_akta_nikah',
                    'Folder Akta Anak' => 'doc_akta_anak_folder',
                    'Ijazah SD' => 'doc_ijazah_sd',
                    'Ijazah SMP' => 'doc_ijazah_smp',
                    'Ijazah SMA' => 'doc_ijazah_sma',
                    'Ijazah D1' => 'doc_ijazah_d1',
                    'Ijazah D3' => 'doc_ijazah_d3',
                    'Ijazah S1 / D4' => 'doc_ijazah_s1',
                    'Ijazah S2' => 'doc_ijazah_s2',
                    'Ijazah S3' => 'doc_ijazah_s3',
                    'Sertifikat Diklat' => 'doc_sertifikat_diklat',
                    'File Pendukung' => 'doc_file_pendukung',
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($dokumens as $label => $field)
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-200 flex flex-col justify-between min-h-[100px]">
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Dokumen</p>
                            <h4 class="font-bold text-gray-700 text-sm leading-tight">{{ $label }}</h4>
                        </div>
                        
                        <div class="mt-4">
                            @if(!empty($pegawai->$field))
                                <a href="{{ $pegawai->$field }}" target="_blank" class="block-w-full text-center bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-bold py-1.5 px-3 rounded transition flex items-center justify-center gap-1.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    Buka File
                                </a>
                            @else
                                <span class="block w-full text-center bg-gray-200 text-gray-400 text-[11px] font-bold py-1.5 px-3 rounded cursor-not-allowed">
                                    Kosong
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-10 pt-6 border-t text-sm text-gray-400 flex justify-between bg-gray-50 -mx-6 -mb-6 px-6 py-4">
            <span>Terdaftar sejak: {{ $pegawai->created_at->format('d M Y') }}</span>
            <span>Terakhir diupdate: {{ $pegawai->updated_at->format('d M Y') }}</span>
        </div>

    </div>
</div>
@endsection
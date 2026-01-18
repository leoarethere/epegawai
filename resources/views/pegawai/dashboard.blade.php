<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai - TVRI Yogyakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-50 font-sans leading-normal tracking-normal flex flex-col min-h-screen">

    <nav class="bg-blue-800 p-4 shadow-lg fixed w-full z-10 top-0">
        <div class="container mx-auto flex items-center justify-between flex-wrap">
            <div class="flex items-center shrink-0 text-white mr-6">
                <span class="font-bold text-xl tracking-tight">E-DATA PEGAWAI TVRI</span>
            </div>
            <div class="flex items-center">
                <span class="text-blue-200 text-sm mr-4">Halo, {{ Auth::user()->nama_lengkap }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded transition">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-24 px-4 grow">
        
        <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden mb-10">
            
            <div class="bg-linear-to-r from-blue-600 to-blue-700 px-6 py-8 text-center md:text-left md:flex md:items-center gap-6">
                <div class="mx-auto md:mx-0 w-28 h-28 bg-white rounded-full flex items-center justify-center text-4xl font-bold text-blue-800 uppercase border-4 border-white shadow-lg overflow-hidden relative shrink-0">
                    @if($user->foto_profil)
                        <img src="{{ asset('storage/' . $user->foto_profil) }}" class="w-full h-full object-cover">
                    @else
                        {{ substr($user->nama_lengkap, 0, 1) }}
                    @endif
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-blue-700 mb-1">{{ $user->nama_lengkap }}</h1>
                    <p class="text-blue-700 text-lg mb-2">{{ $user->jabatan ?? 'Belum ada jabatan' }} - {{ $user->bagian ?? 'Belum ada bagian' }}</p>
                    <div class="flex gap-2 justify-center md:justify-start">
                        @if($user->status_operasional == 'Aktif')
                            <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">Status: Aktif</span>
                        @else
                            <span class="bg-red-500 text-blue-400 text-xs font-bold px-3 py-1 rounded-full shadow-sm">Status: Non-Aktif</span>
                        @endif
                        <span class="bg-gray-200 text-blue-700 text-xs font-bold px-3 py-1 rounded-full shadow-sm">{{ $user->status_pegawai }}</span>
                    </div>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8 border-b">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-3 flex items-center gap-2">
                        <i class="fas fa-briefcase text-blue-600"></i> Data Kepegawaian
                    </h3>
                    <div class="mb-3">
                        <label class="text-xs text-gray-500 uppercase font-bold">NIP</label>
                        <p class="text-gray-800 font-medium">{{ $user->nip ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-xs text-gray-500 uppercase font-bold">NIK</label>
                        <p class="text-gray-800 font-medium">{{ $user->nik }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-xs text-gray-500 uppercase font-bold">Status Pegawai</label>
                        <p class="text-gray-800 font-medium">{{ $user->status_pegawai }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-xs text-gray-500 uppercase font-bold">Email</label>
                        <p class="text-gray-800 font-medium">{{ $user->email }}</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-3 flex items-center gap-2">
                        <i class="fas fa-user text-blue-600"></i> Data Pribadi
                    </h3>
                    <div class="mb-3">
                        <label class="text-xs text-gray-500 uppercase font-bold">Tempat, Tgl Lahir</label>
                        <p class="text-gray-800 font-medium">{{ $user->tempat_lahir ?? '-' }}, {{ $user->tanggal_lahir ? $user->tanggal_lahir->format('d M Y') : '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-xs text-gray-500 uppercase font-bold">Jenis Kelamin</label>
                        <p class="text-gray-800 font-medium">{{ $user->jenis_kelamin }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-xs text-gray-500 uppercase font-bold">Agama</label>
                        <p class="text-gray-800 font-medium">{{ $user->agama ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-xs text-gray-500 uppercase font-bold">Telepon</label>
                        <p class="text-gray-800 font-medium">{{ $user->telepon }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-xs text-gray-500 uppercase font-bold">Alamat KTP</label>
                        <p class="text-gray-800 font-medium text-sm leading-relaxed">{{ $user->alamat_ktp ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-6 bg-gray-50/50">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4 flex items-center gap-2">
                    <i class="fas fa-folder-open text-blue-600"></i> Arsip Dokumen Digital
                </h3>
                
                @php 
                    $dokumens = [
                        'KTP' => ['field' => 'doc_ktp', 'icon' => 'fa-id-card'],
                        'Kartu Keluarga' => ['field' => 'doc_kk', 'icon' => 'fa-users'],
                        'NPWP' => ['field' => 'doc_npwp', 'icon' => 'fa-file-invoice'],
                        'Akta Nikah' => ['field' => 'doc_akta_nikah', 'icon' => 'fa-heart'],
                        'Folder Akta Anak' => ['field' => 'doc_akta_anak_folder', 'icon' => 'fa-folder'],
                        'Folder Ijazah' => ['field' => 'doc_folder_ijazah', 'icon' => 'fa-graduation-cap'],
                        'SK Kenaikan Pangkat' => ['field' => 'doc_sk_naik_pangkat', 'icon' => 'fa-arrow-up'],
                        'Sertifikat Diklat' => ['field' => 'doc_sertifikat_diklat', 'icon' => 'fa-certificate'],
                        'File Pendukung' => ['field' => 'doc_file_pendukung', 'icon' => 'fa-paperclip'],
                    ]; 
                @endphp
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($dokumens as $label => $data)
                        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Dokumen</p>
                                    <h4 class="font-bold text-gray-800 text-sm leading-tight flex items-center gap-2">
                                        <i class="fas {{ $data['icon'] }} text-blue-600"></i>
                                        {{ $label }}
                                    </h4>
                                </div>
                            </div>
                            <div class="mt-4">
                                @if(!empty($user->{$data['field']}))
                                    <a href="{{ $user->{$data['field']} }}" target="_blank" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded transition items-center justify-center gap-2 shadow-sm">
                                        <i class="fas fa-external-link-alt"></i> Lihat / Download
                                    </a>
                                @else
                                    <button disabled class="block w-full text-center bg-gray-100 text-gray-400 text-xs font-bold py-2 px-4 rounded cursor-not-allowed border border-gray-200">
                                        Belum Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                    {{-- SK KEPEGAWAIAN (Updated: Netral Style) --}}
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1 flex items-center gap-1">
                                    DOKUMEN
                                </p>
                                <h4 class="font-bold text-gray-800 text-sm leading-tight flex items-center gap-2">
                                    <i class="fas fa-file-signature text-blue-600"></i>
                                    SK Kepegawaian
                                </h4>
                                <p class="text-[10px] text-gray-400 mt-1">
                                    Dokumen resmi (CPNS/PNS/PPPK)
                                </p>
                            </div>
                        </div>
                        <div class="mt-4">
                            @if(!empty($user->doc_link_sk))
                                <a href="{{ $user->doc_link_sk }}" target="_blank" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded transition items-center justify-center gap-2 shadow-sm">
                                    <i class="fas fa-external-link-alt"></i> Lihat / Download
                                </a>
                            @else
                                <button disabled class="block w-full text-center bg-gray-100 text-gray-400 text-xs font-bold py-2 px-4 rounded cursor-not-allowed border border-gray-200">
                                    Belum Tersedia
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative text-center" role="alert">
                <span class="block sm:inline text-sm">Silahkan hubungi admin jika ada kesalahan data pegawai</span>
            </div>

            @if($user->link_dokumen)
            <div class="bg-yellow-50 p-4 border-t text-center">
                <p class="text-sm text-gray-600 mb-2">
                    <i class="fas fa-info-circle text-yellow-600 mr-1"></i> 
                    Masih ada dokumen lama yang tersimpan?
                </p>
                <a href="{{ $user->link_dokumen }}" target="_blank" class="inline-flex items-center gap-2 text-yellow-700 hover:text-yellow-800 font-bold hover:underline text-sm">
                    <i class="fas fa-external-link-alt"></i> Buka Folder Arsip Lama (Google Drive)
                </a>
            </div>
            @endif
        </div>
    </div>

    <div class="bg-white border-t py-6 mt-auto">
        <div class="text-center space-y-2">
            <p class="text-xs text-gray-400 font-medium">
                &copy; 2025 TVRI Stasiun D.I. Yogyakarta. Semua hak dilindungi.
            </p>
            <p class="text-xs text-gray-500">
                Dibuat oleh 
                <a href="https://www.instagram.com/leoarethere/" target="_blank" class="font-bold text-blue-600 hover:text-blue-800 hover:underline transition">
                    Leonardo Putra Susanto
                </a> 
                & 
                <a href="https://www.instagram.com/destywahyu01/" target="_blank" class="font-bold text-blue-600 hover:text-blue-800 hover:underline transition">
                    Desty Wahyu Anjani
                </a>
            </p>
        </div>
    </div>

</body>
</html>
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
            <div class="flex items-center flex-shrink-0 text-white mr-6">
                <span class="font-bold text-xl tracking-tight">TVRI Yogyakarta</span>
            </div>
            <div class="flex items-center">
                <span class="text-blue-200 text-sm mr-4">Halo, {{ Auth::user()->nama_lengkap }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-24 px-4 flex-grow">
        
        <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden mb-10">
            <div class="bg-blue-600 px-6 py-8 text-center md:text-left md:flex md:items-center gap-6">
                <div class="mx-auto md:mx-0 w-28 h-28 bg-white rounded-full flex items-center justify-center text-4xl font-bold text-blue-800 uppercase border-4 border-white shadow-lg overflow-hidden relative flex-shrink-0">
                    @if($user->foto_profil)
                        <img src="{{ asset('storage/' . $user->foto_profil) }}" class="w-full h-full object-cover">
                    @else
                        {{ substr($user->nama_lengkap, 0, 1) }}
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ $user->nama_lengkap }}</h1>
                    <p class="text-blue-100">{{ $user->jabatan }} - {{ $user->bagian }}</p>
                    <div class="mt-2">
                        <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">Status: {{ $user->status_operasional }}</span>
                    </div>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8 border-b">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-3">Data Kepegawaian</h3>
                    <div class="mb-3"><label class="text-xs text-gray-500 uppercase font-bold">NIP</label><p class="text-gray-800">{{ $user->nip ?? '-' }}</p></div>
                    <div class="mb-3"><label class="text-xs text-gray-500 uppercase font-bold">NIK</label><p class="text-gray-800">{{ $user->nik }}</p></div>
                    <div class="mb-3"><label class="text-xs text-gray-500 uppercase font-bold">Status Pegawai</label><p class="text-gray-800">{{ $user->status_pegawai }}</p></div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-3">Data Pribadi</h3>
                    <div class="mb-3"><label class="text-xs text-gray-500 uppercase font-bold">Tempat, Tgl Lahir</label><p class="text-gray-800">{{ $user->tempat_lahir }}, {{ $user->tanggal_lahir ? $user->tanggal_lahir->format('d M Y') : '-' }}</p></div>
                    <div class="mb-3"><label class="text-xs text-gray-500 uppercase font-bold">Jenis Kelamin</label><p class="text-gray-800">{{ $user->jenis_kelamin }}</p></div>
                    <div class="mb-3"><label class="text-xs text-gray-500 uppercase font-bold">Agama</label><p class="text-gray-800">{{ $user->agama }}</p></div>
                    <div class="mb-3"><label class="text-xs text-gray-500 uppercase font-bold">Telepon</label><p class="text-gray-800">{{ $user->telepon }}</p></div>
                    <div class="mb-3"><label class="text-xs text-gray-500 uppercase font-bold">Alamat KTP</label><p class="text-gray-800">{{ $user->alamat_ktp }}</p></div>
                </div>
            </div>

            <div class="px-6 py-6 bg-gray-50/50">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4 flex items-center gap-2">
                    <i class="fas fa-folder-open text-blue-600"></i> Arsip Dokumen Digital
                </h3>
                @php $dokumens = ['KTP' => 'doc_ktp', 'Kartu Keluarga' => 'doc_kk', 'NPWP' => 'doc_npwp', 'SK CPNS' => 'doc_sk_cpns', 'SK PNS / PPPK' => 'doc_sk_pns', 'SK Kenaikan Pangkat' => 'doc_sk_naik_pangkat', 'Akta Kelahiran' => 'doc_akta_kelahiran', 'Akta Nikah' => 'doc_akta_nikah', 'Folder Akta Anak' => 'doc_akta_anak_folder', 'Ijazah SD' => 'doc_ijazah_sd', 'Ijazah SMP' => 'doc_ijazah_smp', 'Ijazah SMA' => 'doc_ijazah_sma', 'Ijazah D1' => 'doc_ijazah_d1', 'Ijazah D3' => 'doc_ijazah_d3', 'Ijazah S1 / D4' => 'doc_ijazah_s1', 'Ijazah S2' => 'doc_ijazah_s2', 'Ijazah S3' => 'doc_ijazah_s3', 'Sertifikat Diklat' => 'doc_sertifikat_diklat', 'File Pendukung' => 'doc_file_pendukung']; @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($dokumens as $label => $field)
                        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition duration-200">
                            <div class="flex items-start justify-between">
                                <div><p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Dokumen</p><h4 class="font-bold text-gray-800 text-sm">{{ $label }}</h4></div>
                                <div class="bg-blue-50 p-2 rounded-full"><i class="fas fa-file-alt text-blue-500"></i></div>
                            </div>
                            <div class="mt-4">
                                @if(!empty($user->$field))
                                    <a href="{{ $user->$field }}" target="_blank" class="block-w-full text-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded transition flex items-center justify-center gap-2 shadow-sm"><i class="fas fa-external-link-alt"></i> Lihat / Download File</a>
                                @else
                                    <button disabled class="block w-full text-center bg-gray-100 text-gray-400 text-xs font-bold py-2 px-4 rounded cursor-not-allowed border border-gray-200">File Belum Tersedia</button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if($user->link_dokumen)
            <div class="bg-yellow-50 p-4 border-t text-center">
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
                &copy; 2025 TVRI Stasiun D.I. Yogyakarta.
            </p>
            <p class="text-xs text-gray-500">
                Created by 
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
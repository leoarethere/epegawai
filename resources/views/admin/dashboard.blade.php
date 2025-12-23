@extends('layouts.admin')

@section('content')
<div class="flex flex-col">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Pegawai TVRI Yogyakarta</h1>
        
        <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
            
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                
                <select name="filter_bagian" onchange="this.form.submit()" 
                        class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer bg-white w-full md:w-auto">
                    <option value="">- Semua Bagian -</option>
                    @foreach($listBagian as $bagian)
                        <option value="{{ $bagian }}" {{ request('filter_bagian') == $bagian ? 'selected' : '' }}>
                            {{ $bagian }}
                        </option>
                    @endforeach
                </select>

                <div class="flex gap-2 w-full md:w-auto">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari Nama / NIP..." 
                           class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full md:w-48 text-sm">
                    
                    <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded transition text-sm">
                        Cari
                    </button>
                </div>
                
                </form>

            <a href="{{ route('admin.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition duration-300 text-center whitespace-nowrap text-sm flex items-center justify-center">
                + Tambah Pegawai
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-x-auto shadow-md sm:rounded-lg bg-white">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Nama Lengkap</th>
                    <th scope="col" class="px-6 py-3">NIP / NIK</th>
                    <th scope="col" class="px-6 py-3">Jabatan & Bagian</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pegawai as $p)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        <a href="{{ route('admin.show', $p->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline text-base font-bold">
                            {{ $p->nama_lengkap }}
                        </a>
                        <div class="text-xs text-gray-400 mt-1">{{ $p->email ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div>NIP: {{ $p->nip ?? '-' }}</div>
                        <div class="text-xs text-gray-400">NIK: {{ $p->nik }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold">{{ $p->jabatan ?? 'Belum ada jabatan' }}</div>
                        <div class="text-xs">{{ $p->bagian ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($p->status_operasional == 'Aktif')
                            <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-green-400">Aktif</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-red-400">Non-Aktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center items-center gap-4">
                            <a href="{{ route('admin.edit', $p->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                            
                            <form action="{{ route('admin.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data {{ $p->nama_lengkap }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 hover:underline bg-transparent border-none cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        @if(request('search') || request('filter_bagian'))
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <p>Data tidak ditemukan untuk pencarian ini.</p>
                                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline mt-1">Kembali ke Daftar Utama</a>
                            </div>
                        @else
                            <p>Belum ada data pegawai yang ditambahkan.</p>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="p-4">
            {{ $pegawai->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
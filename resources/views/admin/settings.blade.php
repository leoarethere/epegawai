@extends('layouts.admin')

@section('content')
{{-- Style & Font --}}
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style> .settings-font { font-family: 'Plus Jakarta Sans', sans-serif; } </style>

<div class="settings-font p-6 max-w-4xl mx-auto">
    
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-800">Pengaturan Tampilan</h1>
        <p class="text-xs text-gray-500">Ubah tampilan halaman login pegawai.</p>
    </div>

    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm border border-green-200 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <div>
                <span class="font-bold">Berhasil!</span> {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if ($errors->any())
        <div class="bg-red-50 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm border border-red-200 shadow-sm">
            <div class="font-bold mb-1">Terjadi Kesalahan:</div>
            <ul class="list-disc ml-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $bgPath = \App\Models\Setting::where('key', 'login_background')->value('value');
        $logoPath = \App\Models\Setting::where('key', 'login_logo')->value('value');
    @endphp

    <div class="flex flex-col gap-8">
        
        {{-- CARD 1: BACKGROUND --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-blue-50 px-6 py-4 border-b border-blue-100 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="bg-blue-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold">1</div>
                    <h2 class="text-blue-800 font-bold text-sm">Background Gedung</h2>
                </div>
                <span class="text-[10px] text-blue-600 bg-white px-2 py-0.5 rounded border border-blue-100">Max 2MB</span>
            </div>
            
            <div class="p-6">
                {{-- Preview --}}
                <div class="mb-5 relative w-full h-48 rounded-lg overflow-hidden border border-gray-300 bg-gray-800 shadow-inner">
                    <img id="preview-bg" 
                         src="{{ $bgPath ? asset('storage/' . $bgPath) : '' }}" 
                         class="w-full h-full object-cover {{ $bgPath ? '' : 'hidden' }}">
                    
                    <div id="placeholder-bg" class="w-full h-full flex flex-col items-center justify-center text-gray-400 {{ $bgPath ? 'hidden' : '' }}">
                        <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-xs italic">Belum ada background</span>
                    </div>
                </div>

                {{-- FORM UPDATE BACKGROUND --}}
                <form action="{{ route('admin.settings.update.background') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-2 text-xs font-medium text-gray-700">Pilih File Baru:</label>
                        <input type="file" name="background_image" id="input-bg" 
                            required
                            oninvalid="this.setCustomValidity('Mohon pilih file gambar background terlebih dahulu!')"
                            oninput="this.setCustomValidity('')"
                            onchange="previewImage(event, 'preview-bg', 'placeholder-bg')"
                            class="block w-full text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                            file:text-sm file:font-semibold file:bg-blue-600 file:text-white
                            hover:file:bg-blue-700 cursor-pointer bg-slate-50 rounded-lg border border-slate-200 p-2">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg text-sm shadow-md transition flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Background
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- CARD 2: LOGO --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-blue-50 px-6 py-4 border-b border-blue-100 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="bg-blue-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold">2</div>
                    <h2 class="text-blue-800 font-bold text-sm">Logo Instansi</h2>
                </div>
                <span class="text-[10px] text-blue-600 bg-white px-2 py-0.5 rounded border border-blue-100">PNG Transparan</span>
            </div>
            
            <div class="p-6">
                {{-- Preview --}}
                <div class="mb-5 bg-gray-100 rounded-lg border border-gray-300 border-dashed h-40 flex justify-center items-center relative">
                    <img id="preview-logo" 
                         src="{{ $logoPath ? asset('storage/' . $logoPath) : '' }}" 
                         class="h-24 w-auto object-contain {{ $logoPath ? '' : 'hidden' }}">
                    
                    <div id="placeholder-logo" class="flex flex-col items-center text-gray-400 {{ $logoPath ? 'hidden' : '' }}">
                        <span class="text-xs italic">Logo Default</span>
                    </div>
                </div>

                {{-- FORM UPDATE LOGO --}}
                <form action="{{ route('admin.settings.update.logo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-2 text-xs font-medium text-gray-700">Pilih File Baru:</label>
                        <input type="file" name="logo_image" id="input-logo" 
                            required
                            oninvalid="this.setCustomValidity('Mohon pilih file logo terlebih dahulu!')"
                            oninput="this.setCustomValidity('')"
                            onchange="previewImage(event, 'preview-logo', 'placeholder-logo')"
                            class="block w-full text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                            file:text-sm file:font-semibold file:bg-blue-600 file:text-white
                            hover:file:bg-blue-700 cursor-pointer bg-slate-50 rounded-lg border border-slate-200 p-2">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg text-sm shadow-md transition flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Logo
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function previewImage(event, previewId, placeholderId) {
        const input = event.target;
        const previewImg = document.getElementById(previewId);
        const placeholder = document.getElementById(placeholderId);
        
        input.setCustomValidity('');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
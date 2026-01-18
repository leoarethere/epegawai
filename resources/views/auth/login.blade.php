<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Data Pegawai TVRI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-white h-screen overflow-hidden">

    @php
        // Ambil Gambar & Logo dari Database
        $bgPath = \App\Models\Setting::where('key', 'login_background')->value('value');
        $bgImage = $bgPath ? asset('storage/' . str_replace('public/', '', $bgPath)) : ''; 

        $logoPath = \App\Models\Setting::where('key', 'login_logo')->value('value');
        $logoImage = $logoPath ? asset('storage/' . str_replace('public/', '', $logoPath)) : asset('images/logolight.png'); 
    @endphp

    <div class="flex min-h-screen w-full">
        
        <div class="hidden lg:flex lg:w-3/5 relative bg-blue-950 items-end overflow-hidden">
            @if($bgImage)
                <img src="{{ $bgImage }}" class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-1000 hover:scale-105">
            @else
                <div class="absolute inset-0 bg-linear-to-br from-blue-900 to-slate-900"></div>
            @endif
            
            <div class="absolute inset-0 bg-linear-to-t from-blue-950/95 via-blue-900/60 to-blue-900/10"></div>

            <div class="relative z-10 p-16 w-full text-white">
                
                <h2 class="text-4xl font-extrabold mb-4 tracking-tight leading-none drop-shadow-lg">
                    Selamat Datang
                </h2>
                
                <div class="h-1.5 w-16 bg-yellow-400 mb-6 rounded-full"></div>
                
                <div class="space-y-1 mb-8">
                    <p class="text-xl font-bold text-blue-50 leading-relaxed">
                        Sistem Informasi Manajemen Data Pegawai
                    </p>
                    <p class="text-lg text-blue-200 font-light tracking-wide">
                        LPP TVRI Stasiun D.I. Yogyakarta
                    </p>
                </div>

                <div class="flex items-center text-sm text-blue-200/80 font-normal border-t border-blue-500/30 pt-6 max-w-lg">
                    <svg class="w-5 h-5 mr-3 text-yellow-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="leading-relaxed">
                        Jl. Magelang Km. 4,5, Sinduadi, Mlati, Sleman, D.I. Yogyakarta
                    </span>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-2/5 flex flex-col justify-center px-8 lg:px-20 bg-white relative shadow-2xl z-20">
            
            <div class="w-full max-w-md mx-auto">
                <div class="mb-12 text-center">
                    <div class="h-20 flex items-center justify-center mb-6">
                        <img src="{{ $logoImage }}" alt="Logo TVRI" class="h-full object-contain">
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">E-DATA PEGAWAI</h1>
                    <p class="text-gray-500 text-sm mt-2">Silahkan login untuk masuk ke dalam sistem</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-100 rounded-xl p-4 flex items-center">
                        <svg class="h-5 w-5 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm text-red-700 font-medium">{{ $errors->first() }}</span>
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-6 bg-green-50 border border-green-100 rounded-xl p-4 text-sm text-green-700 font-medium text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="nip" class="block text-sm font-semibold text-gray-700 mb-2">NIP / NIK</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input id="nip" name="nip" type="text" required autofocus 
                                class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all text-sm font-medium placeholder-gray-400" 
                                placeholder="Masukkan NIP / NIK" value="{{ old('nip') }}">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" required 
                                class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all text-sm font-medium placeholder-gray-400" 
                                placeholder="Masukkan Kata Sandi">
                        </div>
                    </div>

                    <div class="mb-12 text-center">
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline text-sm">Silahkan hubungi admin jika mengalami kendala saat login</span>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 active:scale-95">
                            MASUK
                        </button>
                    </div>
                </form>

                <div class="mt-12 text-center space-y-2">
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
        </div>
    </div>

</body>
</html>
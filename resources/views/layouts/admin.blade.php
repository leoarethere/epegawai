<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TVRI Yogyakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex md:flex-row-reverse flex-wrap">
        
        <div class="w-full md:w-4/5 bg-gray-100">
            <div class="container bg-gray-100 pt-16 px-6">
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content') 
            </div>
        </div>

        <div class="w-full md:w-1/5 bg-gray-900 md:bg-gray-900 px-2 text-center fixed bottom-0 md:pt-8 md:top-0 md:left-0 h-16 md:h-screen md:border-r-4 md:border-gray-600 z-50">
            <div class="md:relative mx-auto lg:float-right lg:px-6">
                <ul class="list-reset flex flex-row md:flex-col text-center md:text-left">
                    
                    <li class="mr-3 flex-1">
                        <div class="block py-1 md:py-3 pl-1 align-middle text-gray-800 no-underline border-b-2 border-gray-800">
                            <span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 block md:inline-block font-bold">
                                Hi, {{ Auth::user()->nama_lengkap }}
                            </span>
                        </div>
                    </li>

                    <li class="mr-3 flex-1">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-blue-500 transition-colors duration-200">
                            <i class="fas fa-users pr-0 md:pr-3 text-blue-600"></i>
                            <span class="pb-1 md:pb-0 text-xs md:text-base text-white block md:inline-block">Data Pegawai</span>
                        </a>
                    </li>

                    <li class="mr-3 flex-1">
                        <a href="{{ route('admin.settings') }}" 
                           class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-blue-500 transition-colors duration-200">
                            <i class="fas fa-images pr-0 md:pr-3 text-blue-600"></i>
                            <span class="pb-1 md:pb-0 text-xs md:text-base text-white block md:inline-block">Tampilan Login</span>
                        </a>
                    </li>

                    <li class="mr-3 flex-1">
                        <form action="{{ route('logout') }}" method="POST" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-red-500 cursor-pointer border-b-2 border-gray-800 hover:border-red-500 transition-colors duration-200">
                            @csrf
                            <button type="submit" class="w-full text-left">
                                <i class="fas fa-sign-out-alt pr-0 md:pr-3 text-red-600"></i>
                                <span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 block md:inline-block">Logout</span>
                            </button>
                        </form>
                    </li>

                </ul>
            </div>
        </div>
        
    </div>

</body>
</html>
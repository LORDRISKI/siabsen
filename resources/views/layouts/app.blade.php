<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiAbsen')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-950 text-gray-200 min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-56 bg-gray-900 border-r border-gray-800 flex flex-col p-4 fixed h-full">
        <div class="flex items-center gap-3 mb-8 px-2">
            <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center text-lg">📍</div>
            <div>
                <div class="font-bold text-white text-sm">SiAbsen</div>
                <div class="text-xs text-gray-500">Absensi Digital</div>
            </div>
        </div>

        <nav class="flex flex-col gap-1 flex-1">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
               {{ request()->routeIs('dashboard') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30' : 'text-gray-400 hover:bg-gray-800' }}">
                🏠 Dashboard
            </a>
            <a href="{{ route('absensi.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
               {{ request()->routeIs('absensi.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30' : 'text-gray-400 hover:bg-gray-800' }}">
                ✅ Absen Sekarang
            </a>
            <a href="{{ route('riwayat.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
               {{ request()->routeIs('riwayat.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30' : 'text-gray-400 hover:bg-gray-800' }}">
                📋 Riwayat
            </a>

            @if(Auth::guard('pegawai')->user()->role === 'admin')
            <div class="border-t border-gray-800 my-2"></div>
            <p class="text-xs text-gray-600 px-3 mb-1">ADMIN</p>
            <a href="{{ route('admin.pegawai.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:bg-gray-800">
                👥 Data Pegawai
            </a>
            <a href="{{ route('admin.absensi.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:bg-gray-800">
                📊 Semua Absensi
            </a>
            @endif
        </nav>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-400 hover:bg-gray-800">
                🚪 Keluar
            </button>
        </form>
    </aside>

    {{-- Main Content --}}
    <main class="ml-56 flex-1 p-8">
        @yield('content')
    </main>

</body>
</html>
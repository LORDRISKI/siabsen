<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SiAbsen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-6">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600 text-3xl mb-4">📍</div>
            <h1 class="text-2xl font-bold text-white">SiAbsen</h1>
            <p class="text-gray-500 text-sm mt-1">Sistem Informasi Absensi Pegawai</p>
        </div>

        {{-- Card --}}
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8">
            <h2 class="text-lg font-semibold text-white mb-6">Masuk ke Akun Anda</h2>

            @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-4 mb-6">
                <p class="text-red-400 text-sm">{{ $errors->first() }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm text-gray-400 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-indigo-500"
                        placeholder="email@contoh.com">
                </div>
                <div class="mb-6">
                    <label class="block text-sm text-gray-400 mb-2">Password</label>
                    <input type="password" name="password"
                        class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-indigo-500"
                        placeholder="••••••••">
                </div>
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-gray-600 text-xs mt-6">
            © 2026 SiAbsen — Sistem Absensi Digital
        </p>
    </div>
</body>
</html>
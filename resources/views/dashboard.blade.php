@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div>
    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">Dashboard</h1>
            <p class="text-gray-500 text-sm mt-1">
                Selamat datang, {{ Auth::guard('pegawai')->user()->nama }}
            </p>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-xl px-4 py-2 text-center">
            <div class="text-blue-400 font-bold text-lg" id="jam">--:--:--</div>
            <div class="text-gray-500 text-xs">WIB</div>
        </div>
    </div>

    {{-- Status Absensi Hari Ini --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5">
            <div class="text-xs text-gray-500 mb-2">Jam Masuk</div>
            <div class="text-2xl font-bold {{ $absensiHariIni?->jam_masuk ? 'text-green-400' : 'text-gray-600' }}">
                {{ $absensiHariIni?->jam_masuk ? \Carbon\Carbon::parse($absensiHariIni->jam_masuk)->format('H:i') : '--:--' }}
            </div>
            <div class="text-xs mt-1 {{ $absensiHariIni?->jam_masuk ? 'text-green-500' : 'text-gray-600' }}">
                {{ $absensiHariIni?->jam_masuk ? 'Sudah Absen' : 'Belum Absen' }}
            </div>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5">
            <div class="text-xs text-gray-500 mb-2">Jam Keluar</div>
            <div class="text-2xl font-bold {{ $absensiHariIni?->jam_keluar ? 'text-purple-400' : 'text-gray-600' }}">
                {{ $absensiHariIni?->jam_keluar ? \Carbon\Carbon::parse($absensiHariIni->jam_keluar)->format('H:i') : '--:--' }}
            </div>
            <div class="text-xs mt-1 {{ $absensiHariIni?->jam_keluar ? 'text-purple-500' : 'text-gray-600' }}">
                {{ $absensiHariIni?->jam_keluar ? 'Sudah Absen' : 'Belum Absen' }}
            </div>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5">
            <div class="text-xs text-gray-500 mb-2">Status</div>
            <div class="text-2xl font-bold {{ $absensiHariIni ? 'text-yellow-400' : 'text-gray-600' }}">
                {{ $absensiHariIni ? ucfirst(str_replace('_', ' ', $absensiHariIni->status)) : 'Belum' }}
            </div>
            <div class="text-xs mt-1 text-gray-500">{{ now()->format('d M Y') }}</div>
        </div>
    </div>

    {{-- Tombol Absen --}}
    @if(!$absensiHariIni?->jam_masuk || !$absensiHariIni?->jam_keluar)
    <div class="bg-indigo-600/10 border border-indigo-500/30 rounded-2xl p-6 mb-8 flex items-center justify-between">
        <div>
            <div class="font-semibold text-white">
                {{ !$absensiHariIni?->jam_masuk ? '⏰ Anda belum absen masuk hari ini' : '⏰ Anda belum absen keluar' }}
            </div>
            <div class="text-sm text-gray-400 mt-1">Segera lakukan absensi sebelum batas waktu</div>
        </div>
        <a href="{{ route('absensi.index') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl transition text-sm">
            Absen Sekarang →
        </a>
    </div>
    @endif

    {{-- Riwayat Terakhir --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800">
            <h3 class="font-semibold text-white">Riwayat Absensi Terakhir</h3>
        </div>
        <table class="w-full">
            <thead>
                <tr class="bg-gray-950">
                    <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase">Tanggal</th>
                    <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase">Masuk</th>
                    <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase">Keluar</th>
                    <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase">Jarak</th>
                    <th class="text-left px-6 py-3 text-xs text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $r)
                <tr class="border-t border-gray-800 hover:bg-gray-800/50">
                    <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm text-blue-400">{{ $r->jam_masuk ? substr($r->jam_masuk,0,5) : '—' }}</td>
                    <td class="px-6 py-4 text-sm text-purple-400">{{ $r->jam_keluar ? substr($r->jam_keluar,0,5) : '—' }}</td>
                    <td class="px-6 py-4 text-sm text-green-400">{{ $r->jarak_masuk ? $r->jarak_masuk.'m' : '—' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $r->status === 'tepat_waktu' ? 'bg-green-500/15 text-green-400' :
                               ($r->status === 'terlambat' ? 'bg-yellow-500/15 text-yellow-400' : 'bg-red-500/15 text-red-400') }}">
                            {{ ucfirst(str_replace('_', ' ', $r->status)) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-600">Belum ada riwayat absensi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    setInterval(() => {
        document.getElementById('jam').textContent = new Date().toLocaleTimeString('id-ID');
    }, 1000);
</script>
@endsection
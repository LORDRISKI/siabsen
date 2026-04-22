@extends('layouts.app')
@section('title', 'Absen Sekarang')
@section('content')

<div class="p-6 max-w-lg mx-auto">
    <h2 class="text-2xl font-bold mb-2">Absen Sekarang</h2>
    <p class="text-gray-400 mb-6">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>

    @if(session('success'))
        <div class="bg-green-600 text-white px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-600 text-white px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div class="bg-gray-800 rounded-xl p-5 mb-6">
        <h3 class="font-semibold mb-3 text-gray-300">Status Hari Ini</h3>
        <div class="grid grid-cols-2 gap-4 text-center">
            <div class="bg-gray-700 rounded-lg p-4">
                <p class="text-xs text-gray-400 mb-1">Jam Masuk</p>
                <p class="text-xl font-bold text-green-400">
                    {{ $absensiHariIni?->jam_masuk ? \Carbon\Carbon::parse($absensiHariIni->jam_masuk)->format('H:i') : '-' }}
                </p>
            </div>
            <div class="bg-gray-700 rounded-lg p-4">
                <p class="text-xs text-gray-400 mb-1">Jam Keluar</p>
                <p class="text-xl font-bold text-red-400">
                    {{ $absensiHariIni?->jam_keluar ? \Carbon\Carbon::parse($absensiHariIni->jam_keluar)->format('H:i') : '-' }}
                </p>
            </div>
        </div>
        @if($absensiHariIni?->status)
        <div class="mt-3 text-center">
            <span class="px-3 py-1 rounded-full text-xs font-semibold
                {{ $absensiHariIni->status === 'tepat_waktu' ? 'bg-green-500' : ($absensiHariIni->status === 'terlambat' ? 'bg-yellow-500' : 'bg-gray-500') }}">
                {{ ucfirst(str_replace('_', ' ', $absensiHariIni->status)) }}
            </span>
        </div>
        @endif
    </div>

    <div class="bg-gray-800 rounded-xl p-5 mb-6">
        <h3 class="font-semibold mb-3 text-gray-300">Lokasi Kamu</h3>
        <div id="map-status" class="w-full h-12 rounded-lg bg-gray-700 flex items-center justify-center">
            <p class="text-gray-400 text-sm">Mengambil lokasi...</p>
        </div>
        <p class="text-xs text-gray-400 mt-2" id="koordinat">-</p>
        @if($lokasi)
        <p class="text-xs text-gray-500 mt-1">Radius kantor: {{ $lokasi->radius }} meter</p>
        @endif
    </div>

    <div class="grid grid-cols-2 gap-4">
        @if(!$absensiHariIni?->jam_masuk)
        <form action="{{ route('absensi.masuk') }}" method="POST">
            @csrf
            <input type="hidden" name="lat" id="lat_masuk">
            <input type="hidden" name="lng" id="lng_masuk">
            <input type="hidden" name="jarak" id="jarak_masuk">
            <input type="hidden" name="akurasi" id="akurasi">
            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-500 text-white font-bold py-4 rounded-xl transition">
                Absen Masuk
            </button>
        </form>
        @else
            <div class="bg-gray-700 text-gray-400 font-bold py-4 rounded-xl text-center">Sudah Masuk</div>
        @endif

        @if($absensiHariIni?->jam_masuk && !$absensiHariIni?->jam_keluar)
        <form action="{{ route('absensi.keluar') }}" method="POST">
            @csrf
            <input type="hidden" name="lat" id="lat_keluar">
            <input type="hidden" name="lng" id="lng_keluar">
            <input type="hidden" name="jarak" id="jarak_keluar">
            <button type="submit"
                class="w-full bg-red-600 hover:bg-red-500 text-white font-bold py-4 rounded-xl transition">
                Absen Keluar
            </button>
        </form>
        @elseif($absensiHariIni?->jam_keluar)
            <div class="bg-gray-700 text-gray-400 font-bold py-4 rounded-xl text-center">Sudah Keluar</div>
        @else
            <div class="bg-gray-700 text-gray-400 font-bold py-4 rounded-xl text-center opacity-50">Absen Keluar</div>
        @endif
    </div>
</div>

<script>
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(pos) {
        var lat = pos.coords.latitude;
        var lng = pos.coords.longitude;
        var accuracy = pos.coords.accuracy;

        document.getElementById('koordinat').textContent =
            'Lat: ' + lat.toFixed(6) + ', Lng: ' + lng.toFixed(6) + ' | Akurasi: ' + Math.round(accuracy) + 'm';
        document.getElementById('map-status').innerHTML =
            '<p class="text-green-400 text-sm">Lokasi berhasil diambil</p>';

        var el;
        el = document.getElementById('lat_masuk'); if(el) el.value = lat;
        el = document.getElementById('lng_masuk'); if(el) el.value = lng;
        el = document.getElementById('jarak_masuk'); if(el) el.value = 0;
        el = document.getElementById('akurasi'); if(el) el.value = accuracy;
        el = document.getElementById('lat_keluar'); if(el) el.value = lat;
        el = document.getElementById('lng_keluar'); if(el) el.value = lng;
        el = document.getElementById('jarak_keluar'); if(el) el.value = 0;

    }, function(err) {
        document.getElementById('map-status').innerHTML =
            '<p class="text-red-400 text-sm">Gagal: ' + err.message + '</p>';
    }, { enableHighAccuracy: true, timeout: 10000 });
}
</script>

@endsection
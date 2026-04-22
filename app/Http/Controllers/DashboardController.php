<?php

namespace App\Http\Controllers;

use App\Models\LokasiKantor;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pegawai        = Auth::guard('pegawai')->user();
        $absensiHariIni = $pegawai->absensiHariIni;
        $riwayat        = $pegawai->absensis()
                                  ->orderByDesc('tanggal')
                                  ->limit(10)
                                  ->get();
        $lokasi         = LokasiKantor::first();

        return view('dashboard', compact('pegawai', 'absensiHariIni', 'riwayat', 'lokasi'));
    }
}
<?php

namespace App\Http\Controllers;

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

        return view('dashboard', compact('pegawai', 'absensiHariIni', 'riwayat'));
    }
}
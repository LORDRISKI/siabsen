<?php
namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\LokasiKantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $pegawai = Auth::guard('pegawai')->user();
        $absensiHariIni = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', today())->first();
        $lokasi = LokasiKantor::first();
        return view('absensi.index', compact('pegawai', 'absensiHariIni', 'lokasi'));
    }

    public function masuk(Request $request)
    {
        $pegawai = Auth::guard('pegawai')->user();
        $sudahAbsen = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', today())
            ->whereNotNull('jam_masuk')
            ->exists();

        if ($sudahAbsen) {
            return back()->with('error', 'Kamu sudah absen masuk hari ini.');
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_absensi', 'public');
        }

        $jamMasuk = now()->toTimeString();
        $batas = '08:00:00';
        $status = $jamMasuk <= $batas ? 'tepat_waktu' : 'terlambat';

        Absensi::create([
            'pegawai_id'  => $pegawai->id,
            'tanggal'     => today(),
            'jam_masuk'   => $jamMasuk,
            'lat_masuk'   => $request->lat,
            'lng_masuk'   => $request->lng,
            'jarak_masuk' => $request->jarak,
            'akurasi_gps' => $request->akurasi,
            'foto_masuk'  => $fotoPath,
            'status'      => $status,
            'ip_address'  => $request->ip(),
        ]);

        return back()->with('success', 'Absen masuk berhasil! Status: ' . $status);
    }

    public function keluar(Request $request)
    {
        $pegawai = Auth::guard('pegawai')->user();
        $absensi = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', today())
            ->whereNotNull('jam_masuk')
            ->whereNull('jam_keluar')
            ->first();

        if (!$absensi) {
            return back()->with('error', 'Kamu belum absen masuk atau sudah absen keluar.');
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_absensi', 'public');
        }

        $absensi->update([
            'jam_keluar'   => now()->toTimeString(),
            'lat_keluar'   => $request->lat,
            'lng_keluar'   => $request->lng,
            'jarak_keluar' => $request->jarak,
            'foto_keluar'  => $fotoPath,
        ]);

        return back()->with('success', 'Absen keluar berhasil!');
    }
}
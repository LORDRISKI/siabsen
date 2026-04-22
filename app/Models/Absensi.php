<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'pegawai_id','tanggal','jam_masuk','jam_keluar',
        'lat_masuk','lng_masuk','lat_keluar','lng_keluar',
        'jarak_masuk','jarak_keluar','foto_masuk','foto_keluar',
        'akurasi_gps','status','keterangan','ip_address',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
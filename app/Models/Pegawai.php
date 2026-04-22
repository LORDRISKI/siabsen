<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'password',
        'jabatan',
        'divisi',
        'foto_profil',
        'role',
        'is_aktif',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password'  => 'hashed',
        'is_aktif'  => 'boolean',
    ];

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function absensiHariIni()
    {
        return $this->hasOne(Absensi::class)->whereDate('tanggal', today());
    }
}
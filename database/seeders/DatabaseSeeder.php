<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Lokasi Kantor
        \App\Models\LokasiKantor::create([
            'nama_lokasi'  => 'Kantor Pusat Bungo',
            'latitude'     => -1.4748,
            'longitude'    => 102.1247,
            'radius_meter' => 100,
            'jam_masuk'    => '08:00:00',
            'jam_pulang'   => '16:00:00',
            'is_aktif'     => true,
        ]);

        // Akun Admin
        \App\Models\Pegawai::create([
            'nip'      => '198501012010011001',
            'nama'     => 'Administrator',
            'email'    => 'admin@siabsen.test',
            'password' => bcrypt('password'),
            'jabatan'  => 'Administrator',
            'divisi'   => 'IT',
            'role'     => 'admin',
        ]);

        // Akun Pegawai Contoh
        \App\Models\Pegawai::create([
            'nip'      => '199001012015011002',
            'nama'     => 'Budi Santoso',
            'email'    => 'budi@siabsen.test',
            'password' => bcrypt('password'),
            'jabatan'  => 'Staff',
            'divisi'   => 'Umum',
            'role'     => 'pegawai',
        ]);
    }
}
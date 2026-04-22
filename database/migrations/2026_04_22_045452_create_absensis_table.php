<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->decimal('lat_masuk', 10, 8)->nullable();
            $table->decimal('lng_masuk', 11, 8)->nullable();
            $table->decimal('lat_keluar', 10, 8)->nullable();
            $table->decimal('lng_keluar', 11, 8)->nullable();
            $table->float('jarak_masuk')->nullable();
            $table->float('jarak_keluar')->nullable();
            $table->string('foto_masuk')->nullable();
            $table->string('foto_keluar')->nullable();
            $table->float('akurasi_gps')->nullable();
            $table->enum('status', ['tepat_waktu', 'terlambat', 'absen'])->default('absen');
            $table->text('keterangan')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
            $table->unique(['pegawai_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
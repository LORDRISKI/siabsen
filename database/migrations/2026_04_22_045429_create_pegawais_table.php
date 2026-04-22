<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 20)->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('jabatan');
            $table->string('divisi');
            $table->string('foto_profil')->nullable();
            $table->enum('role', ['admin', 'pegawai'])->default('pegawai');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
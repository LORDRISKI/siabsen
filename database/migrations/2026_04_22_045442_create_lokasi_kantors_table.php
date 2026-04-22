<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lokasi_kantors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasi');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->integer('radius_meter')->default(100);
            $table->time('jam_masuk')->default('08:00:00');
            $table->time('jam_pulang')->default('16:00:00');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lokasi_kantors');
    }
};
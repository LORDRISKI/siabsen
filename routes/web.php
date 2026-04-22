<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

Route::middleware(\App\Http\Middleware\PegawaiAuth::class)->group(function () {
    Route::get('/',          fn() => redirect()->route('dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/absensi',   fn() => view('absensi.index'))->name('absensi.index');
    Route::get('/riwayat',   fn() => view('riwayat.index'))->name('riwayat.index');
    Route::get('/admin/pegawai',  fn() => view('admin.pegawai.index'))->name('admin.pegawai.index');
    Route::get('/admin/absensi',  fn() => view('admin.absensi.index'))->name('admin.absensi.index');
});
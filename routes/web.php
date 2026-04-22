<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiController;
use Illuminate\Support\Facades\Route;
Route::get("/login",  [AuthController::class, "showLogin"])->name("login");
Route::post("/login", [AuthController::class, "login"]);
Route::post("/logout",[AuthController::class, "logout"])->name("logout");
Route::middleware(\App\Http\Middleware\PegawaiAuth::class)->group(function () {
    Route::get("/",          fn() => redirect()->route("dashboard"));
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");
    Route::get("/absensi",   [AbsensiController::class, "index"])->name("absensi.index");
    Route::post("/absensi/masuk",  [AbsensiController::class, "masuk"])->name("absensi.masuk");
    Route::post("/absensi/keluar", [AbsensiController::class, "keluar"])->name("absensi.keluar");
    Route::get("/riwayat",   fn() => view("riwayat.index"))->name("riwayat.index");
    Route::get("/admin/pegawai",  fn() => view("admin.pegawai.index"))->name("admin.pegawai.index");
    Route::get("/admin/absensi",  fn() => view("admin.absensi.index"))->name("admin.absensi.index");
});
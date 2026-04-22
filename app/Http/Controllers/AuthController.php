<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('pegawai')->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi',
            'email.email'       => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        $pegawai = Pegawai::where('email', $request->email)->first();

        if (!$pegawai || !Hash::check($request->password, $pegawai->password)) {
            return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
        }

        if (!$pegawai->is_aktif) {
            return back()->withErrors(['email' => 'Akun Anda tidak aktif'])->withInput();
        }

        Auth::guard('pegawai')->login($pegawai, $request->remember);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('pegawai')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
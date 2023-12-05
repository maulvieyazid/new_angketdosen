<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Jika sudah login, langsung arahkan ke halaman home
        if (auth()->check()) return redirect()->route('home');

        return view('auth.new_login');
    }

    public function login(Request $req)
    {
        // Ambil Karyawan yang nik nya sesuai request
        // yang aktif, dan yang pass kar ok nya bernilai true
        $karyawan = Karyawan::where('nik', $req->nik)
            ->aktif()
            ->whereRaw("PASS_KAR_OK(nik, ?) = 'TRUE'", [$req->pin])
            ->first();

        // Kalo karyawan nya null, maka redirect ke halaman login
        if (!$karyawan) return redirect()->route('login')->with('danger', 'NIK/PIN salah')->withInput();

        // Cek apakah karyawan memiliki otoritas, jika tidak ada maka lempar ke halaman login
        if (!$this->authorizeKary($karyawan)) return redirect()->route('login')->with('danger', 'Maaf, anda tidak memiliki hak akses')->withInput();

        // Set karyawan sebagai user auth
        auth()->login($karyawan);

        // Tambah session untuk mengindikasikan bahwa user telah login
        $req->session()->put('logged_in', true);

        // redirect ke halaman home / intended
        if (auth()->check()) return redirect()->intended('/');
    }

    function authorizeKary($karyawan)
    {
        // Beri akses ke Bu Sekar
        if ($karyawan->nik == '970216') return true;

        // Kalau salah satu nilai ini tidak ada yang true, maka return false
        if (!in_array(true, [
            $karyawan->is_dekan,
            $karyawan->is_warek_1,
            $karyawan->is_admin_fakultas,
            $karyawan->is_kaprodi,
            $karyawan->is_dosen,
            $karyawan->is_p3ai,
        ])) return false;

        return true;
    }

    public function logout()
    {
        auth()->logout();

        session()->invalidate();

        session()->regenerateToken();

        return redirect()->route('login');
    }
}

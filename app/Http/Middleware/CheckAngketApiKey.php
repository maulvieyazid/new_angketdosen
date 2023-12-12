<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CheckAngketApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /*
         | Untuk menggunakan API di aplikasi angket dosen ini, mohon kirimkan dua parameter berikut :
         | - id : Nilai id dapat berupa nilai apapun yang ingin dilemparkan, bisa nim, bisa nik, bisa kode, apapun
         | - passcode : Hash dari kombinasi id dengan api key.
         |              Hash bisa menggunakan bcrypt($combination) / Hash::make($combination) bila di laravel,
         |              atau menggunakan password_hash($combination, PASSWORD_BCRYPT) bila menggunakan php native.
         |              Bentuk kombinasi id dan api key dapat dilihat pada variabel $combination_code dibawah
         |
         | Parameter diatas dapat dimasukkan ke query parameter url (Method GET) atau dimasukkan ke body (Method POST, PUT, DELETE, dll)
         */

        // Ambil request passcode yang bernilai hash dari kode kombinasi
        $passcode = $request->passcode;

        // Ambil request id
        $id = $request->id;

        if (!$id) return response()->json(['message' => 'ID tidak boleh kosong'], 401);

        // Kode kombinasi untuk dibandingkan dengan hash passcode
        $combination_code =  $id . '_' . config('angket.api_key');

        // Jika hash passcode tidak cocok dengan kode kombinasi, maka passcode yang dilemparkan salah
        if (!Hash::check($combination_code, $passcode)) return response()->json(['message' => 'API Key Aplikasi Angket Dosen tidak sesuai'], 401);

        return $next($request);
    }
}

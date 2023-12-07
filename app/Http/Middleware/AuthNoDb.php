<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthNoDb
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
         | Middleware ini digunakan untuk mengecek apakah user sudah terotentikasi atau tidak
         | tetapi disini tidak menggunakan auth()->check() atau Auth()::check(),
         | dikarenakan panggilan ke instance auth akan memicu panggilan juga ke DB untuk mengambil user yang terkait,
         | ini dapat menyebabkan pemrosesan route menjadi LAMBAT.
         | Maka dari itu disini hanya mengecek apakah ada session yang bernama 'logged_in'.
         | Kalau ada berarti user berhasil terotentikasi, kalau tidak berarti user belum terotentikasi.
         */
        if (!$request->session()->has('logged_in')) {
            return abort(401);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\Semester;
use Closure;
use Illuminate\Http\Request;

class CheckSemester
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
        // WARNING : FAK_ID default '41010' atau jurusan SI, permintaan DBA
        $semester = Semester::where('fak_id', '41010')->first();

        // Jika "semester yang akan datang" sama dengan "semester yang aktif", maka sudah tutup semester
        // Jika tidak sama, maka belum tutup semester
        session(['isTutupSemester' => $semester->smt_yad == $semester->smt_aktif]);

        return $next($request);
    }
}

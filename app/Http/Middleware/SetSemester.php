<?php

namespace App\Http\Middleware;

use App\Models\Semester;
use Closure;
use Illuminate\Http\Request;

class SetSemester
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

        $request->session()->put('smt_aktif', $semester->smt_aktif);
        $request->session()->put('smt_yad', $semester->smt_yad);
        $request->session()->put('smt_lain', $semester->smt_lain);

        return $next($request);
    }
}

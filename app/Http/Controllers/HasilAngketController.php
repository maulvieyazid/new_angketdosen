<?php

namespace App\Http\Controllers;

use App\Models\AngketTf;
use Illuminate\Http\Request;

class HasilAngketController extends Controller
{
    function index(Request $req)
    {
        // Ambil semua smt yg ada di angkettf untuk dimasukkan ke select
        $semuaSmt = AngketTf::select('smt')
            ->distinct()
            ->orderBy('smt', 'desc')
            ->get();

        // Kalo gk ada query param "smt", maka langsung return view
        if (!$req->smt) return view('hasil-angket.index', compact('semuaSmt'));

        // Ambil semua dosen pada angketTf yang mengajar pada semester tertentu
        // Setelah diambil, sorting datanya berdasarkan nama dosen
        $semuaDosen = AngketTf::query()
            ->dosenMengajarDiSmt($req->smt)
            ->with('karyawan:nik,nama')
            ->get()
            ->sortBy('karyawan.nama');

        return view('hasil-angket.index', compact('semuaSmt', 'semuaDosen'));
    }

    function detail($smt, $nik)
    {
        return view('hasil-angket.detail');
    }
}

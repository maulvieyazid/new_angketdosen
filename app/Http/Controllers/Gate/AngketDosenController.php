<?php

namespace App\Http\Controllers\Gate;

use App\Http\Controllers\Controller;
use App\Models\AngketMf;
use Illuminate\Http\Request;

class AngketDosenController extends Controller
{
    public function getDataKrsMhs()
    {
        return 'coba';
    }

    public function getDaftarPertanyaanAngketDosen()
    {
        $pertanyaan = AngketMf::where('status', AngketMf::AKTIF)->orderBy('urut')->get();

        return response()->json(compact('pertanyaan'));
    }
}

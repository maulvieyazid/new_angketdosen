<?php

namespace App\Http\Controllers\API\Gate;

use App\Http\Controllers\API\Controller;
use App\Models\AngketMf;
use App\Models\Krs;
use Illuminate\Http\Request;

class AngketDosenController extends Controller
{
    public function getDataKrsMhs()
    {
        dd(Krs::make()->getTable(), self::STATUS_SUCCESS);

        return 'coba';
    }

    public function getDaftarPertanyaanAngketDosen()
    {
        $pertanyaan = AngketMf::where('status', AngketMf::AKTIF)->orderBy('urut')->get();

        return response()->json(compact('pertanyaan'));
    }
}

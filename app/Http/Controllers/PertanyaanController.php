<?php

namespace App\Http\Controllers;

use App\Models\AngketMf;
use App\Models\NoSrKtr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PertanyaanController extends Controller
{
    public function index()
    {
        $pertanyaan = AngketMf::query()
            ->orderBy('status', 'desc')
            ->orderBy('urut')
            ->orderBy('kd_angket')
            ->get();

        $inPeriodeAngket = NoSrKtr::inPeriodeAngket()->count();

        return view('pertanyaan.index', compact('pertanyaan', 'inPeriodeAngket'));
    }

    public function update(Request $req)
    {
        // Lakukan dekripsi pada data pertanyaan yg dienkripsi
        $encPrtyn = Crypt::decryptString($req->encPrtyn);
        // Lalu decode json nya
        $encPrtyn = json_decode($encPrtyn, false);

        // Validasi
        if (!in_array($req->jenis, [
            AngketMf::PIL_GANDA,
            AngketMf::ISIAN_BEBAS,
            AngketMf::ISIAN_CAMPUR,
        ])) return redirect()->route('index.pertanyaan')->with('danger', 'Jenis tidak valid.');

        // Ambil data pertanyaan yang kd_angket nya sesuai dengan data yang dienkripsi
        $angketMf = AngketMf::query()
            ->where('kd_angket', $encPrtyn->kd_angket)
            ->first();

        // Update
        $angketMf->uraian = $req->uraian;
        $angketMf->status = isset($req->status) ? 1 : 0;
        $angketMf->jenis = $req->jenis;
        $angketMf->save();

        return redirect()->route('index.pertanyaan')->with('success', 'Pertanyaan berhasil diubah.');
    }

    public function changeStatus(Request $req)
    {
        // Lakukan dekripsi pada data pertanyaan yg dienkripsi
        $encPrtyn = Crypt::decryptString($req->encPrtyn);
        // Lalu decode json nya
        $encPrtyn = json_decode($encPrtyn, false);

        // Langsung update status pertanyaan dengan kd_angket dari data enkripsi,
        // tanpa di select terlebih dahulu
        AngketMf::where('kd_angket', $encPrtyn->kd_angket)
            ->update([
                'status' => !$req->status ? 0 : 1
            ]);

        return response()->json([
            'status' => 'success'
        ]);
    }
}

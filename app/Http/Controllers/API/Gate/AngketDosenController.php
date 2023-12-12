<?php

namespace App\Http\Controllers\API\Gate;

use App\Http\Controllers\API\Controller;
use App\Models\AngketMf;
use App\Models\API\Gate\Krs;
use App\Models\HisMf;
use Illuminate\Http\Request;

class AngketDosenController extends Controller
{
    public function getDataKrsMhs(Request $req)
    {
        // Ambil nilai nim dari id
        $nim = $req->id;

        $prodi = substr($nim, 2, 5);

        // Ambil status mhs di semester smt_yad
        $sts_mhs = HisMf::query()
            ->where('semester', session('smt_yad'))
            ->where('mhs_nim', $nim)
            ->first();

        // Kalo status nya bukan [null, 'T', 'X'], maka return array kosong
        $allowed_sts = [null, 'T', 'X'];
        // TEMPORARY : karena data di DB 23 tidak sesuai, maka untuk sementara pengecekan ini di skip, jika sudah masuk ke DB 15, maka buka komentar pengecekan ini
        /* if (!in_array($sts_mhs, $allowed_sts)) return $this->sendApiResponseSuccess(json_encode([])); */

        // Ambil data krs mhs
        $krs = Krs::query()
            ->where('mhs_nim', $nim)
            ->with(['jdwkul', 'jdwprk']);

        // Kalau bukan prodi '41010' maka jangan tampilkan yang praktikum
        $krs = ($prodi != '41010') ? $krs->whereNull('prk_group') : $krs;

        $krs = $krs->get();

        return $this->sendApiResponseSuccess($krs->toJson());
    }

    public function getDaftarPertanyaanAngketDosen()
    {
        $pertanyaan = AngketMf::where('status', AngketMf::AKTIF)
            ->orderBy('urut')
            ->get();

        return $this->sendApiResponseSuccess($pertanyaan->toJson());
    }
}

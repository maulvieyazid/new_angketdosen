<?php

namespace App\Http\Controllers;

use App\Models\AngketMf;
use App\Models\AngketTf;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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

    /**
     * Menampilkan detil hasil angket
     *
     * @param string $data Bernilai enkripsi sebuah json yang berstruktur seperti berikut:
     * [
     *    "smt" => Semester,
     *    "nik" => NIK Dosen yang dipilih,
     * ]
     */
    function detail($data)
    {
        // Decrypt dan lakukan decode pada data
        $data = Crypt::decryptString($data);
        $data = json_decode($data, false); // <- false untuk menjadikan object

        $smt = $data->smt;

        // Ambil data dosen
        $dosen = Karyawan::query()
            ->withoutGlobalScopes()
            ->where('nik', $data->nik)
            ->select('nik', 'nama')
            ->getNamaLengkap()
            ->first();

        // Ambil hasil angket per kelas
        $hasilPerKelas = AngketTf::query()
            ->hasilPerKelas($data->smt, $data->nik)
            ->with('prodiAngket')
            ->get();

        // Ambil hasil angket per kelas per pertanyaan
        // NOTE : nilai angket yang dipakai hanya yang pilihan ganda, karena yg esai tidak ada nilai nya
        $hasilPerKelasPerPertanyaan = AngketTf::query()
            ->hasilPerKelasPerPertanyaan($data->smt, $data->nik)
            ->with('pertanyaan')
            ->get();

        // Ambil semua jawaban esai untuk ditampilkan di view
        $semuaJwbnEsai = AngketTf::query()
            ->where('nik', $data->nik)
            ->where('smt', $data->smt)
            ->whereNotNull('saran')
            ->whereRelation('pertanyaan', 'jenis', AngketMf::ISIAN_BEBAS)
            ->get();

        return view('hasil-angket.detail', compact(
            'smt',
            'dosen',
            'hasilPerKelas',
            'hasilPerKelasPerPertanyaan',
            'semuaJwbnEsai'
        ));
    }
}

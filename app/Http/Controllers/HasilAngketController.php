<?php

namespace App\Http\Controllers;

use App\Models\AngketMf;
use App\Models\AngketTf;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Shuchkin\SimpleXLSXGen;

class HasilAngketController extends Controller
{
    public function index(Request $req)
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
    public function detail($data)
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


    public function downloadExcel($smt)
    {
        // Ambil nik-nik dosen yang bisa dilihat oleh user yang login
        $nik = AngketTf::dosenMengajarDiSmt($smt)->get()->pluck('nik')->all();

        // Ambil hasil angker per kelas per dosen sesuai dengan smt dan nik yang diberikan
        $hasilPerKelasPerDosen = AngketTf::query()
            ->hasilPerKelasPerDosen($smt, $nik)
            ->with(['karyawan' => function ($karyawan) {
                $karyawan->select('nik', 'bagian')->with('departemen');
            }])
            ->get();

        // Ambil semua jawaban esai
        $semuaJwbnEsai = AngketTf::query()
            ->where('smt', $smt)
            ->whereIn('nik', $nik)
            ->whereNotNull('saran')
            ->whereRelation('pertanyaan', 'jenis', AngketMf::ISIAN_BEBAS)
            ->get();


        // Set header
        $data = [
            [
                '<style border="thin"><center>' . "Semester" . '</center></style>',
                '<style border="thin"><center>' . "Prodi" . '</center></style>',
                '<style border="thin"><center>' . "NIK" . '</center></style>',
                '<style border="thin"><center>' . "Nama Dosen" . '</center></style>',
                '<style border="thin"><center>' . "Bagian" . '</center></style>',
                '<style border="thin"><center>' . "Kode MK" . '</center></style>',
                '<style border="thin"><center>' . "Nama MK" . '</center></style>',
                '<style border="thin"><center>' . "Kelas" . '</center></style>',
                '<style border="thin"><center>' . "Nilai Rata-rata" . '</center></style>',
                '<style border="thin"><center>' . "Keluhan" . '</center></style>',
            ],
        ];

        foreach ($hasilPerKelasPerDosen as $hpkpd) {

            // Filter jawaban esai sesuai matakuliah dan dosen
            // Lalu gabungkan dengan pemisah " | "
            $keluhan = $semuaJwbnEsai
                ->where('kode_mk', $hpkpd->kode_mk)
                ->where('kelas', $hpkpd->kelas)
                ->where('prodi', $hpkpd->prodi)
                ->where('nik', $hpkpd->nik)
                ->implode('saran', ' | ');

            $data[] = [
                $smt,
                $hpkpd->prodi,
                $hpkpd->nik,
                $hpkpd->nama_dosen,
                $hpkpd->karyawan->departemen->nama ?? null,
                '<center>' . $hpkpd->kode_mk . '</center>',
                $hpkpd->nama_mk,
                '<center>' . $hpkpd->kelas . '</center>',
                '<center>' . $hpkpd->nilai . '</center>',
                $keluhan,
            ];
        }



        $xlsx = SimpleXLSXGen::fromArray($data);
        $xlsx->setDefaultFontSize(11);

        /* Set width column */
        $xlsx->setColWidth(1, 10); // <- Semester
        $xlsx->setColWidth(2, 9); // <- Prodi
        $xlsx->setColWidth(3, 10); // <- NIK
        $xlsx->setColWidth(4, 34); // <- Nama Dosen
        $xlsx->setColWidth(5, 41); // <- Bagian
        $xlsx->setColWidth(6, 9); // <- Kode MK
        $xlsx->setColWidth(7, 38); // <- Nama MK
        $xlsx->setColWidth(8, 6); // <- Kelas
        $xlsx->setColWidth(9, 14); // <- Nilai Rata-rata

        $xlsx->downloadAs("Hasil Angket Per Kelas Per Dosen Semester $smt.xlsx");
    }
}

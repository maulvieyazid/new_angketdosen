<?php

namespace App\Http\Controllers\API\Gate;

use App\Http\Controllers\API\Controller;
use App\Models\AngketMf;
use App\Models\AngketTf;
use App\Models\API\Gate\Krs;
use App\Models\HisMf;
use App\Models\MstSubKegiatan;
use App\Models\NoSrKtr;
use App\Models\PesertaAngket;
use App\Models\TrnNilaiMaba;
use Illuminate\Http\Request;

class AngketDosenController extends Controller
{
    const ID_MATERI = 3;
    const ID_SUB_MATERI = 16;

    /**
     * Isi data request yang dilempar ke method getDataKrsMhs() adalah sebagai berikut:
     * - id : NIM Mahasiswa
     * - passcode : Hash dari kombinasi id dan api key
     */
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

        return $this->sendApiResponseSuccess($krs);
    }

    public function getDaftarPertanyaanAngketDosen()
    {
        $pertanyaan = AngketMf::where('status', AngketMf::AKTIF)
            ->orderBy('urut')
            ->get();

        return $this->sendApiResponseSuccess($pertanyaan);
    }


    /** 
     * Isi data request yang dilempar ke method storeAngketDosen() adalah sebagai berikut:
     * - id : NIM Mahasiswa
     * - passcode : Hash dari kombinasi id dan api key
     * - matkul_angket : [
     *      'nik'      => NIK Dosen Matakuliah,
     *      'kode_mk'  => Kode Matakuliah,
     *      'kelas'    => Kelas Matakuliah,
     *      'smt'      => kolom SMT_LAIN dari tabel SEMESTER_MF where prodi 41010,
     *      'smt_mk'   => kolom SEMESTER dari tabel KURLKL_MF where ID dan PRODI disesuaikan,
     *      'prodi'    => Prodi Mahasiswa,
     *   ]
     * - penilaian : Data array dari jawaban-jawaban angket yang memiliki struktur seperti di bawah ini
     *               [
     *                  'kode_angket' => 'jawaban_angket',
     *                  'kode_angket' => 'jawaban_angket',
     *                  ...
     *               ]
     */
    public function storeAngketDosen(Request $req)
    {
        $nim = $req->id;

        $matkul_angket = (object) $req->matkul_angket;

        // Cek apakah sekarang masuk periode pengisian angket dosen
        $inPeriodeAngket = NoSrKtr::inPeriodeAngket()->count();
        if (!$inPeriodeAngket) return $this->sendApiResponseError('Hari ini tidak masuk dalam periode pengisian angket dosen.');


        $alreadyFillAngket = PesertaAngket::query()
            ->where('nim', $nim)
            ->where('kode_mk', $matkul_angket->kode_mk)
            ->where('smt', $matkul_angket->smt)
            ->count();

        if ($alreadyFillAngket) return $this->sendApiResponseError('Angket sudah terisi');


        $penilaian = $req->penilaian;

        // Ambil semua key dari data penilaian
        $allKdAngket = array_keys($penilaian);

        // Ambil daftar pertanyaan dengan KD_ANGKET dari seluruh key data penilaian
        $pertanyaan = AngketMf::query()
            ->where('status', AngketMf::AKTIF)
            ->whereIn('kd_angket', $allKdAngket)
            ->orderBy('kd_angket')
            ->get();

        foreach ($pertanyaan as $prtyn) {

            // Ini adalah data-data yang sama yang akan diinsert untuk pilihan ganda maupun isian bebas
            // yang membedakan pilihan ganda dan isian bebas, hanyalah kolom untuk mengisi jawaban angket nya
            $dataInsert = [
                'nik'       => $matkul_angket->nik,
                'kode_mk'   => $matkul_angket->kode_mk,
                'kelas'     => $matkul_angket->kelas,
                'smt'       => $matkul_angket->smt,
                'smt_mk'    => $matkul_angket->smt_mk,
                'prodi'     => $matkul_angket->prodi,
                'kd_angket' => $prtyn->kd_angket,
                'tgl_entry' => today(),
            ];

            // Cek Jenis
            // Kalo jenis nya pilihan ganda
            if ($prtyn->jenis == AngketMf::PIL_GANDA) {
                // Jawaban angket nya disimpan di kolom "NILAI"
                $dataInsert['nilai'] = $penilaian[$prtyn->kd_angket];
            }
            // Kalo jenis nya isian bebas
            elseif ($prtyn->jenis == AngketMf::ISIAN_BEBAS) {
                // Jawaban angket nya disimpan di kolom "SARAN" dan "JAWAB"
                // Jika nilainya adalah '-', maka ganti dengan nilai null
                $dataInsert['saran'] = $penilaian[$prtyn->kd_angket] == '-' ? null : $penilaian[$prtyn->kd_angket];

                // Lalu untuk key "jawab", jika saran nya kosong atau null maka isikan 't', kalo gk kosong maka isikan 'y'
                $dataInsert['jawab'] = !$dataInsert['saran'] ? 't' : 'y';
            }

            // Simpan Jawaban
            AngketTf::create($dataInsert);
        }

        // Simpan Log Mahasiswa yang mengisi angket
        PesertaAngket::create([
            'smt'       => $matkul_angket->smt,
            'nim'       => $nim,
            'kode_mk'   => $matkul_angket->kode_mk,
            'kelas'     => $matkul_angket->kelas,
        ]);


        /* ================================================================== */
        /* Menambahkan SSKM Mahasiswa setelah mengisi angket dosen */
        /* ================================================================== */

        // Ambil data mst_sub_kegiatan PENGISIAN ANGKET
        $mstSubKeg = MstSubKegiatan::query()
            ->select('id_materi', 'id_sub_materi', 'id_sub_kegiatan')
            ->where('id_materi', 3)
            ->where('id_sub_materi', 16)
            ->whereRaw("UPPER(nm_sub_kegiatan) LIKE 'PENGISIAN ANGKET%'")
            ->whereRaw("SUBSTR(nm_sub_kegiatan, -3) = ?", [$matkul_angket->smt])
            ->first();

        // Nilai default id id materi
        $idmat = self::ID_MATERI;
        $idsubmat = self::ID_SUB_MATERI;
        $idsubkeg = null;

        // Kalo gk ada, maka insert dulu data mst_sub_kegiatan PENGISIAN ANGKET
        if (!$mstSubKeg) {
            // Pertama, ambil dulu id terakhir dari mst_sub_kegiatan PENGISIAN ANGKET
            $lastidsubkeg = MstSubKegiatan::query()
                ->selectRaw("MAX(TO_NUMBER(id_sub_kegiatan)) AS lastidsubkeg")
                ->where('id_materi', $idmat)
                ->where('id_sub_materi', $idsubmat)
                ->whereRaw("UPPER(nm_sub_kegiatan) LIKE 'PENGISIAN ANGKET%'")
                ->first()
                ->lastidsubkeg;

            // Increment id terakhir nya, sebagai primary key baru
            $lastidsubkeg = $lastidsubkeg + 1;

            // Setelah itu baru insert kan mst_sub_kegiatan PENGISIAN ANGKET
            MstSubKegiatan::create([
                'id_sub_kegiatan'   => $lastidsubkeg,
                'nm_sub_kegiatan'   => "Pengisian Angket PBM Semester {$matkul_angket->smt}",
                'id_sub_materi'     => $idsubmat,
                'id_materi'         => $idmat,
            ]);

            // Set nilai idsubkeg dengan id terakhir
            $idsubkeg = $lastidsubkeg;
        }
        // Kalo ada, maka set nilai id id materi diatas tadi
        else {
            $idmat = $mstSubKeg->id_materi;
            $idsubmat = $mstSubKeg->id_sub_materi;
            $idsubkeg = $mstSubKeg->id_sub_kegiatan;
        }


        // Cek apakah mahasiswa sudah memiliki sskm dengan id id diatas
        $trnnilaimaba = TrnNilaiMaba::query()
            ->where('nim', $nim)
            ->where('id_materi', $idmat)
            ->where('sub_materi_id', $idsubmat)
            ->where('sub_keg_id', $idsubkeg)
            ->first();

        // Kalo belum ada, maka insert sskm baru
        if (!$trnnilaimaba) {
            // Insert nilai sskm mahasiswa
            TrnNilaiMaba::create([
                'nim'           => $nim,
                'sub_materi_id' => $idsubmat,
                'nilai'         => 1,
                'id_materi'     => $idmat,
                'tanggal'       => today(),
                'group_id'      => null,
                'sub_keg_id'    => $idsubkeg,
            ]);
        }
        // Kalo sudah ada, maka update nilai sskm nya sebanyak log mahasiswa
        else {
            // Ambil jumlah log mahasiswa pengisian angket dosen
            $jmlLog = PesertaAngket::query()
                ->where('smt', $matkul_angket->smt)
                ->where('nim', $nim)
                ->count();

            // jumlah log nya dikalikan 1, entah kenapa, tapi di sicyca seperti ini
            $jmlLog = $jmlLog * 1;

            // Update nilai sskm mahasiswa
            $trnnilaimaba->update([
                'nilai' => $jmlLog
            ]);
        }

        return $this->sendApiResponseSuccess('Data Angket berhasil disimpan');
    }
}

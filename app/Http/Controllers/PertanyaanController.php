<?php

namespace App\Http\Controllers;

use App\Models\AngketMf;
use App\Models\AngketTf;
use App\Models\NoSrKtr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PertanyaanController extends Controller
{
    public function index()
    {
        $pertanyaan = AngketMf::query()
            ->orderBy('status', 'desc')
            ->orderBy('urut')
            ->get();

        $inPeriodeAngket = NoSrKtr::inPeriodeAngket()->count();

        return view('pertanyaan.index', compact('pertanyaan', 'inPeriodeAngket'));
    }

    public function otherPertanyan(Request $req)
    {
        // Ambil semua smt yg ada di angkettf untuk dimasukkan ke select
        $semuaSmt = AngketTf::select('smt')
            ->distinct()
            ->orderBy('smt', 'desc')
            ->get();

        // Kalo gk ada query param "smt", maka langsung return view
        if (!$req->smt) return view('pertanyaan.otherPertanyaan', compact('semuaSmt'));

        $semuaPertanyaan = AngketTf::query()
            ->select('kd_angket')
            ->distinct()
            ->where('smt', $req->smt)
            ->with('pertanyaan')
            ->orderBy('kd_angket')
            ->get();

        return view('pertanyaan.otherPertanyaan', compact('semuaSmt', 'semuaPertanyaan'));
    }

    public function store(Request $req)
    {
        $failure = function ($message) {
            return redirect()->route('index.pertanyaan')->with('danger', $message);
        };

        // Jika uraian kosong
        if (!$req->uraian) return $failure('Uraian tidak boleh kosong.');

        // Validasi Jenis
        if (!in_array($req->jenis, [
            AngketMf::PIL_GANDA,
            AngketMf::ISIAN_BEBAS,
            AngketMf::ISIAN_CAMPUR,
        ])) return $failure('Jenis tidak valid.');

        // Cast inputan urut ke int
        $urut = (int) $req->urut;
        // Kalo nilai nya 0, maka
        if (!$urut) return $failure('Urut tidak boleh 0.');

        // Geser urutan lainnya, agar urutan yang baru bisa menempati urutan yang diinginkan
        $this->shiftUrutActive(null, $urut);

        // Generate kd_angket
        $newkode = AngketMf::max('kd_angket') + 1;

        // Insert
        AngketMf::create([
            'kd_angket' => $newkode,
            'uraian'    => $req->uraian,
            'status'    => isset($req->status) ? 1 : 0,
            'jenis'     => $req->jenis,
            'urut'      => $urut,
        ]);

        return redirect()->route('index.pertanyaan')->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function update(Request $req)
    {
        // Lakukan dekripsi pada data pertanyaan yg dienkripsi
        $encPrtyn = Crypt::decryptString($req->encPrtyn);
        // Lalu decode json nya
        $encPrtyn = json_decode($encPrtyn, false);

        // Validasi Jenis
        if (!in_array($req->jenis, [
            AngketMf::PIL_GANDA,
            AngketMf::ISIAN_BEBAS,
            AngketMf::ISIAN_CAMPUR,
        ])) return redirect()->route('index.pertanyaan')->with('danger', 'Jenis tidak valid.');

        // Cast inputan urut ke int
        $urut = (int) $req->urut;
        // Kalo nilainya 0, maka ganti dengan urutan awal nya
        $urut = !$urut ? $encPrtyn->urut : $urut;

        // Kalo inputan urut berbeda dari urutan awal nya, maka
        if ($urut != $encPrtyn->urut) {
            // Geser urutan-urutan lain nya
            $this->shiftUrutActive($encPrtyn->urut, $urut);
        }

        // Ambil data pertanyaan yang kd_angket nya sesuai dengan data yang dienkripsi
        $angketMf = AngketMf::query()
            ->where('kd_angket', $encPrtyn->kd_angket)
            ->first();

        // Update
        $angketMf->uraian = $req->uraian;
        $angketMf->status = isset($req->status) ? 1 : 0;
        $angketMf->jenis = $req->jenis;
        $angketMf->urut = $urut;
        $angketMf->save();

        return redirect()->route('index.pertanyaan')->with('success', 'Pertanyaan berhasil diubah.');
    }


    /*
     | Fungsi ini digunakan untuk menggeser urutan pertanyaan lain yang status nya aktif.
     | Ini untuk memberikan ruang agar pertanyaan yang diubah urutan nya bisa menempati urutan baru nya.
     |
     | @param $from Urutan pertanyaan dari mana
     | @param $to Urutan pertanyaan mau dipindah kemana
     */
    private function shiftUrutActive($from, $to)
    {
        /*
         | Karena urutan ini ASC, maka bila urutannya semakin mendekati angka 1 maka dianggap NAIK, sebaliknya
         | bila urutan nya semakin besar maka dianggap TURUN, ilustrasi nya sebagai berikut :
         | <--- NAIK    TURUN --->
         |        1 .... 999
         */

        // Urutan yang digeser hanya yang statusnya aktif
        $angketMf = AngketMf::where('status', AngketMf::AKTIF);

        // Jika $from nya null, maka itu berarti pertanyaan baru yang ingin menempati urutan tertentu
        if ($from == null) {
            /*
             | Misal pertanyaan baru ingin menempati urutan 5, maka
             | lakukan INCREMENT pada pertanyaan urutan 5 dan seterusnya,
             | supaya pertanyaan baru bisa menempati urutan 5
             */
            $angketMf
                ->where(function ($query) use ($from, $to) {
                    $query->where('urut', '>=', $to);
                })
                ->increment('urut');

            return;
        }


        /*
         | Contoh jika NAIK : Pertanyaan urutan 8 ingin dipindah ke urutan 5, maka
         | lakukan INCREMENT urutan pada pertanyaan urutan 5 sampai 7,
         | supaya pernyataan urutan 8 bisa menempati urutan 5
         |
         | Contoh jika TURUN : Pertanyaan urutan 5 ingin dipindah ke urutan 8, maka
         | lakukan DECREMENT urutan pada pertanyaan urutan 6 sampai 8
         | supaya pernyataan urutan 5 bisa menempati urutan 8
         */

        // NAIK
        if ($from > $to) {
            $angketMf
                ->where(function ($query) use ($from, $to) {
                    $query->where('urut', '>=', $to)
                        ->where('urut', '<', $from);
                })
                ->increment('urut');
        }
        // TURUN
        elseif ($from < $to) {
            $angketMf
                ->where(function ($query) use ($from, $to) {
                    $query->where('urut', '>', $from)
                        ->where('urut', '<=', $to);
                })
                ->decrement('urut');
        }
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

    public function koreksiUrut()
    {
        $angketMf = AngketMf::make()->getTable();

        $sql = "MERGE INTO $angketMf target
                USING (
                        SELECT kd_angket, urut, ROW_NUMBER() OVER (ORDER BY urut) AS new_urut
                        FROM $angketMf
                        WHERE STATUS = 1 AND URUT IS NOT NULL
                ) sumber
                ON (target.kd_angket = sumber.kd_angket)
                WHEN MATCHED THEN
                    UPDATE SET target.urut = sumber.new_urut
        ";

        DB::statement($sql);

        return redirect()->route('index.pertanyaan')->with('success', 'Urutan pertanyaan berhasil dikoreksi.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AngketTf;
use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    public function index()
    {
        /* ================================================================== */
        /* Ini untuk Data Chart Rata-Rata Nilai Angket Anda Per Semester */
        /* ================================================================== */

        // Ambil distinct smt pada hasil angket
        $semuaSmt = AngketTf::query()
            ->select('smt')
            ->distinct()
            ->orderBy('smt', 'desc')
            ->get();

        $semuaSmt = $semuaSmt->pluck('smt');

        // Untuk 'hingga', ambil semester terbaru
        $hingga = $semuaSmt[0];
        // Untuk 'dari', jika smt nya lebih dari 6, maka ambil semester dengan index 5, kalo enggak ambil smt paling akhir
        $dari = $semuaSmt->count() > 6 ? $semuaSmt[5] : $semuaSmt->last();

        // Kumpulkan nilai-nilai yang diperlukan jadi satu array
        $chart_UL = compact('semuaSmt', 'hingga', 'dari');
        $chart_UL = (object) $chart_UL;

        /* ================================================================== */
        /* ================================================================== */


        $chart_SD = [];

        // Kalo yg login bukan role eksekutif, maka skip chart ini
        if (!auth()->user()->executive_only()) goto SKIP_CHART_SD;

        /* ====================================================================== */
        /* Ini untuk Data Chart Rata-Rata Nilai Angket Semua Dosen Per Semester */
        /* ====================================================================== */

        // Ambil semua prodi
        $semuaProdi = Prodi::query()
            ->select('id', 'alias', 'id_fakultas')
            ->aktif()
            // Kalo yang login adalah kaprodi, maka ambil prodi nya beliau saja
            ->when(auth()->user()->is_kaprodi, function ($query) {
                return $query->where('mngr_id', auth()->user()->nik);
            })
            // Kalo yang login adalah dekan atau admin fakultas, maka ambil prodi yang ada di fakultas yang beliau kelola saja
            ->when(auth()->user()->is_dekan || auth()->user()->is_admin_fakultas, function ($query) {
                return $query->whereHas('fakultas', function ($fakultas) {
                    $fakultas->where('mngr_id', auth()->user()->nik);
                });
            })
            ->orderBy('id')
            ->get();


        // Ambil semua fakultas
        $semuaFakultas = Fakultas::query()
            ->select('id', 'nama')
            ->aktif()
            // Kalo yang login adalah kaprodi, maka ambil fakultas dari prodi nya beliau saja
            ->when(auth()->user()->is_kaprodi, function ($query) use ($semuaProdi) {
                return $query->whereIn('id', $semuaProdi->pluck('id_fakultas'));
            })
            // Kalo yang login adalah dekan atau admin fakultas, maka ambil fakultas yang beliau kelola saja
            ->when(auth()->user()->is_dekan || auth()->user()->is_admin_fakultas, function ($query) {
                return $query->where('mngr_id', auth()->user()->nik);
            })
            ->orderBy('id')
            ->get();

        // Kumpulkan nilai-nilai yang diperlukan jadi satu array
        $chart_SD = compact('semuaProdi', 'semuaFakultas', 'semuaSmt', 'hingga', 'dari');
        $chart_SD = (object) $chart_SD;

        /* ====================================================================== */
        /* ====================================================================== */
        SKIP_CHART_SD:

        return view('home', compact('chart_UL', 'chart_SD'));
    }


    public function getAvgPerSmt($nik, $dari, $hingga)
    {
        // Kalo 'hingga' nya lebih kecil daripada 'dari' nya, maka balik saja nilainya
        if ($hingga < $dari) [$dari, $hingga] = [$hingga, $dari];

        // Ambil nilai rata-rata per semester
        $data = AngketTf::query()
            ->selectRaw('smt, ROUND(AVG(nilai), 2) AS rata_rata')
            ->where('nik', $nik)
            ->whereBetween('smt', [$dari, $hingga])
            ->groupBy('smt')
            ->orderBy('smt')
            ->get();

        // Lakukan mapping untuk membentuk hasil yang sesuai dengan format series apex chart
        $data = $data->map(function ($item, $key) use ($nik) {
            // Bentuk nilai enkripsi dari data
            // Ini digunakan untuk meredirect user ke detail angket
            $encData = [
                'smt' => $item->smt,
                'nik' => $nik,
            ];
            $encData = Crypt::encryptString(json_encode($encData));

            // Bentuk array sesuai dengan series apex chart
            $out = [
                'x' => $item->smt,
                'y' => $item->rata_rata,
                'encData' => $encData,
            ];

            return $out;
        });

        return response()->json($data);
    }

    public function getAvgAllDosenPerSmt($id_fakultas, $id_prodi, $dari, $hingga)
    {
        // Kalo 'hingga' nya lebih kecil daripada 'dari' nya, maka balik saja nilainya
        if ($hingga < $dari) [$dari, $hingga] = [$hingga, $dari];

        // Ambil nilai rata-rata per semester
        $data = AngketTf::query()
            ->selectRaw('smt, ROUND(AVG(nilai), 2) AS rata_rata')
            ->whereBetween('smt', [$dari, $hingga])
            ->groupBy('smt')
            ->orderBy('smt');

        // Kalo id_fakultas nya bukan 'all', maka ambil semua nilai yang prodi nya masuk ke fakultas tsb
        if ($id_fakultas != 'all') {
            $data = $data->whereHas('prodiAngket.fakultas', function (Builder $fakultas) use ($id_fakultas) {
                $fakultas->aktif()->where('id', $id_fakultas);
            });
        }

        // Kalo id_prodi nya bukan 'all', maka ambil semua nilai yang prodi nya sesuai
        if ($id_prodi != 'all') {
            $data = $data->where('prodi', $id_prodi);
        }

        $data = $data->get();

        // Lakukan mapping untuk membentuk hasil yang sesuai dengan format series apex chart
        $data = $data->map(function ($item, $key) {
            // Bentuk array sesuai dengan series apex chart
            $out = [
                'x' => $item->smt,
                'y' => $item->rata_rata,
            ];

            return $out;
        });

        return response()->json($data);

        /* return response()->json([
            ['x' => '212', 'y' => '18.78'],
            ['x' => '221', 'y' => '13.31'],
            ['x' => '222', 'y' => '15.09'],
            ['x' => '231', 'y' => '5.00']
        ]); */
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AngketTf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil distinct smt pada hasil angket dari user yang login
        $semuaSmt = AngketTf::query()
            ->select('smt')
            ->distinct()
            ->where('nik', auth()->user()->nik)
            ->orderBy('smt', 'desc')
            ->get();

        $semuaSmt = $semuaSmt->pluck('smt');

        // Untuk 'hingga', ambil semester terbaru
        $hingga = $semuaSmt[0];
        // Untuk 'dari', jika smt nya lebih dari 6, maka ambil semester dengan index 5, kalo enggak ambil smt paling akhir
        $dari = $semuaSmt->count() > 6 ? $semuaSmt[5] : $semuaSmt->last();

        return view('home', compact('semuaSmt', 'dari', 'hingga'));
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

        /* return response()->json([
            ['x' => '201', 'y' => '20.00'],
            ['x' => '202', 'y' => '11.23'],
            ['x' => '211', 'y' => '14.65'],
            ['x' => '212', 'y' => '18.78'],
            ['x' => '221', 'y' => '13.31'],
            ['x' => '222', 'y' => '15.09'],
            ['x' => '231', 'y' => '10.00']
        ]); */
    }
}

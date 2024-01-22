<?php

namespace App\Http\Controllers;

use App\Models\KategoriAngket;
use App\Models\NoSrKtr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class KategoriController extends Controller
{
    public function index()
    {
        $inPeriodeAngket = NoSrKtr::inPeriodeAngket()->count();

        $semuaKategori = KategoriAngket::query()
            ->withCount('pertanyaan as terikat_pertanyaan')
            ->orderBy('kd_kategori')
            ->get();

        return view('kategori.index', compact('semuaKategori', 'inPeriodeAngket'));
    }

    public function store(Request $req)
    {
        // Generate kd_kategori
        $kd_kategori = (int) KategoriAngket::max('kd_kategori') + 1;

        // Simpan data kategori
        KategoriAngket::create([
            'kd_kategori'   => $kd_kategori,
            'nama_kategori' => $req->nama_kategori
        ]);

        return redirect()->route('index.kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $req)
    {
        // Lakukan dekripsi pada data kategori yg dienkripsi
        $encKtgr = Crypt::decryptString($req->encKtgr);
        // Lalu decode json nya
        $encKtgr = json_decode($encKtgr, false);

        // Ambil data kategori
        $kategori = KategoriAngket::find($encKtgr->kd_kategori);

        // Update data kategori
        $kategori->nama_kategori = $req->nama_kategori;
        $kategori->save();

        return redirect()->route('index.kategori')->with('success', 'Kategori berhasil diubah.');
    }

    public function destroy(Request $req)
    {
        // Fungsi anonymous untuk mengembalikan respon
        $response = function ($tipe, $msg) {
            return redirect()->route('index.kategori')->with($tipe, $msg);
        };

        // Lakukan dekripsi pada data kategori yg dienkripsi
        $encKtgr = Crypt::decryptString($req->encKtgr);
        // Lalu decode json nya
        $encKtgr = json_decode($encKtgr, false);

        $kategori = KategoriAngket::query()
            ->where('kd_kategori', $encKtgr->kd_kategori)
            ->withCount('pertanyaan as terikat_pertanyaan')
            ->first();

        // Jika kategori nya tidak ada
        if (!$kategori) return $response('success', 'Kategori berhasil dihapus.');

        // Jika kategori nya masih terikat dengan pertanyaan
        if ($kategori->terikat_pertanyaan) return $response('danger', 'Gagal menghapus. Kategori masih terikat dengan pertanyaan.');

        // Hapus kategori
        $kategori->delete();

        return $response('success', 'Kategori berhasil dihapus.');
    }
}

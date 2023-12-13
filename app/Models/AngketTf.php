<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngketTf extends Model
{
    use HasFactory;

    protected $table = 'PRODI.ANGKET_TF';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'nik',
        'kode_mk',
        'kelas',
        'smt',
        'smt_mk',
        'kd_angket',
        'nilai',
        'tgl_entry',
        'saran',
        'soal',
        'jawab',
        'prodi',
    ];

    protected $casts = [
        'tgl_entry' => 'datetime',
    ];


    // RELATIONSHIP
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'nik', 'nik')->withoutGlobalScopes();
    }

    public function prodiAngket()
    {
        return $this->belongsTo(Prodi::class, 'prodi', 'id');
    }

    public function pertanyaan()
    {
        return $this->belongsTo(AngketMf::class, 'kd_angket', 'kd_angket');
    }



    // SCOPES

    /**
     * Scope ini untuk mengambil nik-nik dosen yang ada di angketTf berdasarkan semester yg diberikan
     */
    public function scopeDosenMengajarDiSmt($query, $smt)
    {
        $query = $query
            ->select('nik')
            ->distinct()
            ->where('smt', $smt)
            ->whereNotIn('nik', ['000']);

        $user = auth()->user();

        /* Kalau user yang login adalah Warek 1 atau P3AI, maka ambil semua dosen yang ada */
        $cekWarekIP3AI = in_array(1, [$user->is_warek_1, $user->is_p3ai]);
        if ($cekWarekIP3AI) return $query;


        /*
         | Kalau user yang login adalah Dekan atau Kaprodi, maka
         | Ambil semua dosen yang ada di fakultas atau prodi yang dipimpin
         */
        $cekDekapr = in_array(1, [$user->is_dekan, $user->is_kaprodi]);
        if ($cekDekapr) {
            $query = $query
                // Bungkus di dalam satu where
                ->where(function ($query) use ($user) {
                    $query
                        // Ambil angketTf yang prodi nya aktif dan mngr_id nya adalah nik user yg login
                        ->whereHas('prodiAngket', function (Builder $prodi) use ($user) {
                            $prodi->aktif()->where('mngr_id', $user->nik);
                        })
                        // ATAU
                        // Ambil angketTf yang prodi nya ada di fakultas yang aktif dan mngr_id nya adalah nik user yg login
                        ->orWhereHas('prodiAngket.fakultas', function (Builder $fakultas) use ($user) {
                            $fakultas->aktif()->where('mngr_id', $user->nik);
                        });
                });

            return $query;
        }


        /* Kalau user yang login adalah dosen, maka ambil data miliknya sendiri */
        if ($user->is_dosen) {
            $query = $query->where('nik', $user->nik);
        }

        return $query;
    }

    /**
     * Scope ini digunakan untuk mengambil data hasil angket per kelas
     * Perbedaan dengan scopeHasilPerKelasPerPertanyaan adalah
     * kolom nilai merupakan rata-rata dari SELURUH JAWABAN DALAM SATU KELAS
     */
    public function scopeHasilPerKelas($query, $smt, $nik)
    {
        $query = $query
            ->select('kode_mk', 'kelas', 'prodi')
            ->selectRaw('find_nama_mk(kode_mk) as nama_mk')
            ->selectRaw('round(avg(nilai), 2) as nilai')
            ->where('smt', $smt)
            ->where('nik', $nik)
            ->groupBy('kode_mk', 'kelas', 'prodi')
            ->orderBy('kode_mk')->orderBy('prodi');

        $user = auth()->user();

        /*
         | Kalau user yang login adalah Dekan atau Kaprodi, maka
         | Ambil semua kelas yang ada di prodi nya mereka
         */
        $cekDekapr = in_array(1, [$user->is_dekan, $user->is_kaprodi]);
        if ($cekDekapr) {
            $query = $query
                // Bungkus di dalam satu where
                ->where(function ($query) use ($user) {
                    $query
                        // Ambil angketTf yang prodi nya aktif dan mngr_id nya adalah nik user yg login
                        ->whereHas('prodiAngket', function (Builder $prodi) use ($user) {
                            $prodi->aktif()->where('mngr_id', $user->nik);
                        })
                        // ATAU
                        // Ambil angketTf yang prodi nya ada di fakultas yang aktif dan mngr_id nya adalah nik user yg login
                        ->orWhereHas('prodiAngket.fakultas', function (Builder $fakultas) use ($user) {
                            $fakultas->aktif()->where('mngr_id', $user->nik);
                        });
                });
        }

        return $query;
    }

    /**
     * Scope ini digunakan untuk mengambil data hasil angket per kelas per pertanyaan
     * Perbedaan dengan scopeHasilPerKelas adalah
     * kolom nilai merupakan rata-rata dari MASING-MASING JAWABAN DALAM SATU KELAS
     */
    public function scopeHasilPerKelasPerPertanyaan($query, $smt, $nik)
    {
        return $query
            ->select('kode_mk', 'kelas', 'prodi', 'kd_angket')
            ->selectRaw('round(avg(nilai), 2) as nilai')
            ->where('smt', $smt)
            ->where('nik', $nik)
            ->groupBy('kode_mk', 'kelas', 'prodi', 'kd_angket');
    }


    public function scopeHasilPerKelasPerDosen($query, $smt, $nik)
    {
        return $query
            ->select('kode_mk', 'kelas', 'prodi', 'nik')
            ->selectRaw('find_nama_mk(kode_mk) as nama_mk')
            ->selectRaw('find_nama_karyawan(nik) AS nama_dosen')
            ->selectRaw('round(avg(nilai), 2) as nilai')
            ->where('smt', $smt)
            ->whereIn('nik', $nik)
            ->groupBy('kode_mk', 'kelas', 'prodi', 'nik')
            ->orderBy('nik')->orderBy('kode_mk')->orderBy('prodi');
    }
}

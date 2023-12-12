<?php

namespace App\Models\API\Gate;

use App\Models\KurlklMf;
use App\Models\PesertaAngket;
use App\Models\PesertaAngketPrak;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory, Compoships;

    protected $keyType = 'string';

    public $timestamps = false;

    public $incrementing = false;

    protected $appends = [
        'nama_dosen',
        'nama_matakuliah',
        'nik_dosen',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set table
        $this->table = session('smt_aktif') == session('smt_yad') ? 'krs_tf' : 'krs_pw';
    }

    // ACCESSOR
    public function getNamaDosenAttribute()
    {
        // Kalo prk_group nya null, ambil dari jdwkul
        if (!$this->prk_group) return $this->jdwkul->nama_dosen ?? null;

        // Kalo prk_group nya tidak null, maka ambil dari jdwprk
        return $this->jdwprk->nama_dosen ?? null;
    }

    public function getNamaMatakuliahAttribute()
    {
        // Kalo prk_group nya null, ambil dari jdwkul
        if (!$this->prk_group) return $this->jdwkul->nama_mk ?? null;

        // Kalo prk_group nya tidak null, maka ambil dari jdwprk
        return $this->jdwprk->nama_mk ?? null;
    }

    public function getNikDosenAttribute()
    {
        // Kalo prk_group nya null, ambil dari jdwkul
        if (!$this->prk_group) return $this->jdwkul->kary_nik ?? null;

        // Kalo prk_group nya tidak null, maka ambil dari jdwprk
        return $this->jdwprk->kary_nik ?? null;
    }


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        $smt_lain = session('smt_lain');

        // Custom Select
        static::addGlobalScope('custom_select', function (Builder $builder) use ($smt_lain) {
            $builder->select('jkul_kelas', 'jkul_klkl_id', 'mhs_nim', 'prk_group')
                ->selectRaw('substr(mhs_nim, 3, 5) AS prodi')
                ->selectRaw('jkul_kelas AS kelas')
                ->selectRaw('prk_group AS group_praktikum')
                ->selectRaw("$smt_lain AS smt_lain");
        });

        // SMT_MK
        static::addGlobalScope('smt_mk', function (Builder $builder) {

            $kurlkl_mf = KurlklMf::make()->getTable();

            $sql = "(
                        SELECT semester FROM $kurlkl_mf
                        WHERE id = jkul_klkl_id
                          AND fakul_id = substr(mhs_nim, 3, 5)
                    ) AS smt_mk
            ";

            $builder->selectRaw($sql);
        });

        // Angket sudah terisi
        static::addGlobalScope('angket_sudah_terisi', function (Builder $builder) use ($smt_lain) {

            $smt_aktif = session('smt_aktif');

            $peserta_angket = PesertaAngket::make()->getTable();
            $peserta_angket_prak = PesertaAngketPrak::make()->getTable();

            $sql = "CASE
                        /*
                        | Ini untuk mengecek apakah matakuliah
                        | sudah terisi angket nya oleh mahasiswa ini atau belum
                        */
                        WHEN (
                                prk_group IS NULL
                                AND
                                EXISTS (
                                    SELECT 1 FROM $peserta_angket
                                    WHERE smt = $smt_lain
                                        AND nim = mhs_nim
                                        AND kode_mk = jkul_klkl_id
                                        AND kelas = jkul_kelas
                                )
                        ) THEN 1

                        WHEN (
                                prk_group IS NOT NULL
                                AND
                                EXISTS (
                                    SELECT 1 FROM $peserta_angket_prak
                                    WHERE smt = $smt_aktif
                                        AND nim = mhs_nim
                                        AND kode_mk = jkul_klkl_id
                                        AND kelas = jkul_kelas
                                        AND grup_prak = prk_group
                                )
                        ) THEN 1

                        ELSE 0
                    END AS angket_sudah_terisi
            ";

            $builder->selectRaw($sql);
        });
    }



    // RELATIONSHIP
    public function jdwkul()
    {
        return $this->belongsTo(Jdwkul::class, ['jkul_klkl_id', 'jkul_kelas', 'prodi'], ['klkl_id', 'kelas', 'prodi']);
    }

    public function jdwprk()
    {
        return $this->belongsTo(Jdwprk::class, ['jkul_klkl_id', 'prk_group', 'prodi'], ['klkl_id', 'jprk_group', 'prodi']);
    }
}

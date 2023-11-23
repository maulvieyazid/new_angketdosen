<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Karyawan extends Authenticatable
{
    use HasFactory;

    protected $table = 'V_KARYAWAN';

    /*
    | Agar login menggunakan model custom tidak bermasalah
    | maka 2 atribut di bawah ini harus selalu di set,
    | yaitu $primaryKey dan $keyType
    */
    protected $primaryKey = 'nik';

    protected $keyType = 'string';

    public $timestamps = false;

    public $incrementing = false;

    protected $appends = ['inisial'];


    // ACCESSOR
    public function getInisialAttribute()
    {
        // Melakukan explode per spasi, lalu menggunakan array_map untuk mengambil huruf pertama dan menjadikan uppercase
        // setelah itu digabung dengan menggunakan implode
        $initials = implode('', array_map(function ($word) {
            return strtoupper(substr($word, 0, 1));
        }, explode(" ", $this->nama)));

        // Mengambil 2 karakter di depan
        $initials = substr($initials, 0, 2);

        return $initials;
    }


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Custom Select
        static::addGlobalScope('custom_select', function (Builder $builder) {
            $builder->select('NIK', 'NAMA', 'BAGIAN', 'STATUS', 'KARY_TYPE');
        });

        // IS_DEKAN
        static::addGlobalScope('is_dekan', function (Builder $builder) {
            $fakultas = Fakultas::make()->getTable();
            $slctQry = "(
                            CASE
                                WHEN (
                                        NIK IN (SELECT MNGR_ID FROM $fakultas WHERE STS_AKTIF = 'Y')
                                        OR
                                        NIK IN (SELECT WKL_MNGR_ID FROM $fakultas WHERE STS_AKTIF = 'Y')
                                     )
                                THEN 1 ELSE NULL
                            END
                        ) AS IS_DEKAN
            ";
            $builder->selectRaw($slctQry);
        });

        // IS_WAREK_1
        static::addGlobalScope('is_warek_1', function (Builder $builder) {
            $departemen = Departemen::make()->getTable();
            $warek_1 = Departemen::WAREK_1;
            $slctQry = "(
                            CASE
                                WHEN NIK IN (SELECT MANAGER_ID FROM $departemen WHERE KODE = $warek_1)
                                THEN 1 ELSE NULL
                            END
                        ) AS IS_WAREK_1
            ";
            $builder->selectRaw($slctQry);
        });

        // IS_ADMIN_FAKULTAS
        static::addGlobalScope('is_admin_fakultas', function (Builder $builder) {
            $pet_admin = PetugasAdmin::make()->getTable();
            $slctQry = "(
                            CASE
                                WHEN NIK IN (SELECT NIK FROM $pet_admin WHERE USER_TMP IN ('FTI','FEB','FDIK'))
                                THEN 1 ELSE NULL
                            END
                        ) AS IS_ADMIN_FAKULTAS
            ";
            $builder->selectRaw($slctQry);
        });

        // IS_KAPRODI
        static::addGlobalScope('is_kaprodi', function (Builder $builder) {
            $prodi = Prodi::make()->getTable();
            $slctQry = "(
                            CASE
                                WHEN NIK IN (SELECT MNGR_ID FROM $prodi WHERE STS_AKTIF = 'Y')
                                THEN 1 ELSE NULL
                            END
                        ) AS IS_KAPRODI
            ";
            $builder->selectRaw($slctQry);
        });

        // IS_DOSEN
        static::addGlobalScope('is_dosen', function (Builder $builder) {
            $builder->selectRaw("(CASE WHEN KARY_TYPE LIKE '%D%' THEN 1 ELSE NULL END) AS IS_DOSEN");
        });

        // IS_P3AI
        static::addGlobalScope('is_p3ai', function (Builder $builder) {
            $p3ai = Departemen::P3AI;
            $builder->selectRaw("(CASE WHEN BAGIAN = $p3ai THEN 1 ELSE NULL END) AS IS_P3AI");
        });
    }


    // RELATIONSHIP
    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'bagian', 'kode');
    }


    // SCOPES
    public function scopeAktif($query)
    {
        return $query->where('status', 'A');
    }
}

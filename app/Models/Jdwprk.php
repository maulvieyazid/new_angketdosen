<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jdwprk extends Model
{
    use HasFactory, Compoships;

    protected $keyType = 'string';

    public $timestamps = false;

    public $incrementing = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set table
        $this->table = session('smt_aktif') == session('smt_yad') ? 'jdwprk_mf' : 'jdwprk_pw';
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
            $builder->select('kary_nik', 'klkl_id', 'jprk_group', 'prodi')
                ->selectRaw('AAK_MAN.NAMA_DOSEN(kary_nik) as nama_dosen')
                ->selectRaw('AAK_MAN.FIND_NAMA_MK(klkl_id) as nama_mk');
        });
    }


    // RELATIONSHIP
    public function krs()
    {
        $this->hasMany(Krs::class, ['jkul_klkl_id', 'prk_group', 'prodi'], ['klkl_id', 'jprk_group', 'prodi']);
    }
}

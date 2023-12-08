<?php

namespace App\Models;

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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set table
        $this->table = session('smt_aktif') == session('smt_yad') ? 'krs_tf' : 'krs_pw';
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
            $builder->select('jkul_kelas', 'jkul_klkl_id', 'mhs_nim', 'prk_group')
                ->selectRaw('substr(mhs_nim, 3, 5) as prodi');
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'V_FAKULTAS';

    public $timestamps = false;

    public $incrementing = false;



    // RELATIONSHIP
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'id_fakultas', 'id');
    }

    // SCOPE
    public function scopeAktif($query)
    {
        return $query->where('sts_aktif', 'Y');
    }
}

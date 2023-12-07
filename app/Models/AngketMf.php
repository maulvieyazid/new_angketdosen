<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngketMf extends Model
{
    use HasFactory;

    const PIL_GANDA = 'PG';
    const ISIAN_BEBAS = 'ESAI';
    const ISIAN_CAMPUR = 'CAMPUR';

    const AKTIF = 1;
    const NON_AKTIF = 0;

    protected $table = 'ANGKET_MF';

    protected $primaryKey = 'kd_angket';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'uraian',
        'status',
        'jenis',
        'kd_induk',
        'urut',
    ];
}

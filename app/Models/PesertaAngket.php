<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaAngket extends Model
{
    use HasFactory;

    protected $table = 'PRODI.PESERTA_ANGKET';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'smt',
        'nim',
        'kode_mk',
        'kelas',
    ];
}

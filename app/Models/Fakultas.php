<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'V_FAKUL';

    public $timestamps = false;

    public $incrementing = false;


    // SCOPE
    public function scopeAktif($query)
    {
        return $query->where('sts_aktif', 'Y');
    }
}

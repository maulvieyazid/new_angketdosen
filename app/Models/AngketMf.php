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

    protected $table = 'ANGKET_MF';

    public $timestamps = false;

    public $incrementing = false;
}

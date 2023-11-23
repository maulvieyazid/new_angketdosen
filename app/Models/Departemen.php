<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    const WAREK_1 = 38;
    const P3AI = 47;

    protected $table = 'V_DEPARTEMEN1';

    public $timestamps = false;

    public $incrementing = false;
}

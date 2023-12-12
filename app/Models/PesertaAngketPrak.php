<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaAngketPrak extends Model
{
    use HasFactory;

    protected $table = 'PRODI.PESERTA_ANGKETPRAK';

    public $timestamps = false;

    public $incrementing = false;
}

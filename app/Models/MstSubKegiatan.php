<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstSubKegiatan extends Model
{
    use HasFactory;

    protected $table = 'SSKM.MST_SUB_KEGIATAN';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'id_sub_kegiatan',
        'nm_sub_kegiatan',
        'id_sub_materi',
        'id_materi',
    ];
}

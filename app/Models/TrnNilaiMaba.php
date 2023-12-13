<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrnNilaiMaba extends Model
{
    use HasFactory;

    protected $table = 'SSKM.TRN_NILAI_MABA';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'nim',
        'sub_materi_id',
        'nilai',
        'id_materi',
        'tanggal',
        'group_id',
        'sub_keg_id',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];


    protected function performUpdate(Builder $query)
    {
        // TEMPORARY : INI HANYA UNTUK SEMENTARA, JAGA-JAGA BILA DISURUH BERUBAH PAKE PROSEDUR
        // KALO MISALKAN NGGAK DISURUH PAKE PROSEDUR, YAUDAH BIARIN AJA
        TrnNilaiMaba::where('nim', $this->nim)
            ->where('id_materi', $this->id_materi)
            ->where('sub_materi_id', $this->sub_materi_id)
            ->where('sub_keg_id', $this->sub_keg_id)
            ->update([
                'nilai' => $this->nilai
            ]);

        return true;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoSrKtr extends Model
{
    use HasFactory;

    protected $table = 'NO_SR_KTR';

    public $timestamps = false;

    public $incrementing = false;


    // SCOPES
    public function scopeInPeriodeAngket($query)
    {
        $no_sr_ktr_table = self::make()->getTable();

        $sql = "SYSDATE BETWEEN (SELECT TGL_BERLAKU FROM $no_sr_ktr_table WHERE KD_SR = 'TGL_ANGKET1')
                            AND (SELECT TGL_BERLAKU FROM $no_sr_ktr_table WHERE KD_SR = 'TGL_ANGKET2')
        ";

        return $query->from('dual')->whereRaw($sql);
    }
}

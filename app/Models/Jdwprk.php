<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jdwprk extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $timestamps = false;

    public $incrementing = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set table
        $this->table = session('smt_aktif') == session('smt_yad') ? 'jdwprk_mf' : 'jdwprk_pw';
    }
}

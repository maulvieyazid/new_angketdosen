<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jdwkul extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $timestamps = false;

    public $incrementing = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Jika sudah tutup semester
        $this->table = session('smt_aktif') == session('smt_yad') ? 'jdwkul_mf' : 'jdwkul_pw';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngketTf extends Model
{
    use HasFactory;

    protected $table = 'V_ANGKTTF';

    public $timestamps = false;

    public $incrementing = false;
}

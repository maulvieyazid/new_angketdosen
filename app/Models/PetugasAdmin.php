<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasAdmin extends Model
{
    use HasFactory;

    protected $table = 'V_PET_ADMIN';

    public $timestamps = false;

    public $incrementing = false;
}

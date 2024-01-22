<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriAngket extends Model
{
    use HasFactory;

    protected $table = 'PRODI.KATEGORI_ANGKET';

    protected $primaryKey = 'kd_kategori';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'kd_kategori',
        'nama_kategori',
    ];



    // RELATIONSHIP
    public function pertanyaan()
    {
        return $this->hasMany(AngketMf::class, 'kd_kategori', 'kd_kategori');
    }
}

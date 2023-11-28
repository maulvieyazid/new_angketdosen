<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngketTf extends Model
{
    use HasFactory;

    protected $table = 'V_ANGKTTF';

    public $timestamps = false;

    public $incrementing = false;


    // RELATIONSHIP
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'nik', 'nik')->withoutGlobalScopes();
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi', 'id');
    }

    // SCOPES

    /* Scope ini untuk mengambil nik-nik dosen yang ada di angketTf berdasarkan semester yg diberikan */
    public function scopeDosenMengajarDiSmt($query, $smt)
    {
        $query = $query
            ->select('nik')
            ->distinct()
            ->where('smt', $smt)
            ->whereNotIn('nik', ['000']);

        $user = auth()->user();

        /* Kalau user yang login adalah Warek 1 atau P3AI, maka ambil semua dosen yang ada */
        $cekWarekIP3AI = in_array(1, [$user->is_warek_1, $user->is_p3ai]);
        if ($cekWarekIP3AI) return $query;


        /*
         | Kalau user yang login adalah Dekan atau Kaprodi, maka
         | Ambil semua dosen yang ada di fakultas atau prodi yang dipimpin
         */
        $cekDekapr = in_array(1, [$user->is_dekan, $user->is_kaprodi]);
        if ($cekDekapr) {
            $query = $query
                // Bungkus di dalam satu where
                ->where(function ($query) use ($user) {
                    $query
                        // Ambil angketTf yang prodi nya aktif dan mngr_id nya adalah nik user yg login
                        ->whereHas('prodi', function (Builder $prodi) use ($user) {
                            $prodi->aktif()->where('mngr_id', $user->nik);
                        })
                        // ATAU
                        // Ambil angketTf yang prodi nya ada di fakultas yang aktif dan mngr_id nya adalah nik user yg login
                        ->orWhereHas('prodi.fakultas', function (Builder $fakultas) use ($user) {
                            $fakultas->aktif()->where('mngr_id', $user->nik);
                        });
                });

            return $query;
        }


        /* Kalau user yang login adalah dosen, maka ambil data miliknya sendiri */
        if ($user->is_dosen) {
            $query = $query->where('nik', $user->nik);
        }

        return $query;
    }
}

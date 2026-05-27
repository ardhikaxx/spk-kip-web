<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'tb_kriteria';

    protected $primaryKey = 'id_kriteria';

    protected $fillable = ['kode_kriteria', 'nama_kriteria', 'jenis_kriteria', 'nilai_bobot'];

    protected $casts = ['nilai_bobot' => 'decimal:2'];

    public function kategorisasiKriteria()
    {
        return $this->hasMany(KategorisasiKriteria::class, 'id_kriteria', 'id_kriteria')->orderByDesc('nilai');
    }

    public function bobot()
    {
        return $this->hasOne(Bobot::class, 'id_kriteria', 'id_kriteria');
    }
}

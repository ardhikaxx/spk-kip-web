<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategorisasiKriteria extends Model
{
    protected $table = 'tb_kategorisasi_kriteria';

    protected $primaryKey = 'id_kategorisasi_kriteria';

    protected $fillable = ['id_kriteria', 'nama_kategorisasi', 'nilai'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id_kriteria');
    }
}

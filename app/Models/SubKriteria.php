<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    protected $table = 'tb_sub_kriteria';

    protected $primaryKey = 'id_subkriteria';

    protected $fillable = ['id_kriteria', 'nama_subkriteria', 'nilai'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id_kriteria');
    }
}

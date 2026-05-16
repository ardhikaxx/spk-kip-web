<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bobot extends Model
{
    protected $table = 'tb_bobot';

    protected $primaryKey = 'id_bobot';

    protected $fillable = ['id_kriteria', 'nilai_bobot'];

    protected $casts = ['nilai_bobot' => 'decimal:4'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id_kriteria');
    }
}

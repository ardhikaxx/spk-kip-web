<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPerhitungan extends Model
{
    protected $table = 'tb_hasil_perhitungan';

    protected $primaryKey = 'id_hasil';

    protected $fillable = [
        'id_alternatif',
        'leaving_flow',
        'entering_flow',
        'net_flow',
        'ranking',
        'status',
        'tahun',
    ];

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'id_alternatif', 'id_alternatif');
    }
}

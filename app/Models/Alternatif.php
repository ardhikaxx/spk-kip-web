<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    protected $table = 'tb_alternatif';

    protected $primaryKey = 'id_alternatif';

    protected $fillable = [
        'nim',
        'tahun',
        'c1',
        'c2',
        'c3',
        'c4',
        'c5',
        'c6',
        'label_c1',
        'label_c2',
        'label_c3',
        'label_c4',
        'label_c5',
        'label_c6',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function hasil()
    {
        return $this->hasOne(HasilPerhitungan::class, 'id_alternatif', 'id_alternatif');
    }
}

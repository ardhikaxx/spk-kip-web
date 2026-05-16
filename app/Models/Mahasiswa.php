<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'tb_mahasiswa';

    protected $primaryKey = 'nim';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nim',
        'nama_mhs',
        'prodi',
        'jurusan',
        'kip',
        'dtk',
        'desil',
        'kerja_ayah',
        'penghasilan_ayah',
        'keterangan_ayah',
        'kerja_ibu',
        'penghasilan_ibu',
        'keterangan_ibu',
        'prestasi',
    ];

    public function alternatif()
    {
        return $this->hasMany(Alternatif::class, 'nim', 'nim');
    }
}

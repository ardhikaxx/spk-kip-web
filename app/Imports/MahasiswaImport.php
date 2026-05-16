<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class MahasiswaImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row): ?Mahasiswa
    {
        if (! ($row['nim'] ?? null)) {
            return null;
        }

        return new Mahasiswa([
            'nim' => (string) $row['nim'],
            'nama_mhs' => $row['nama_mhs'] ?? '-',
            'prodi' => $row['prodi'] ?? null,
            'jurusan' => $row['jurusan'] ?? null,
            'kip' => $row['kip'] ?? null,
            'dtk' => $row['dtk'] ?? null,
            'desil' => $row['desil'] ?? null,
            'kerja_ayah' => $row['kerja_ayah'] ?? null,
            'penghasilan_ayah' => $row['penghasilan_ayah'] ?? null,
            'keterangan_ayah' => $row['keterangan_ayah'] ?? null,
            'kerja_ibu' => $row['kerja_ibu'] ?? null,
            'penghasilan_ibu' => $row['penghasilan_ibu'] ?? null,
            'keterangan_ibu' => $row['keterangan_ibu'] ?? null,
            'prestasi' => $row['prestasi'] ?? 'Tidak ada',
        ]);
    }

    public function uniqueBy(): string
    {
        return 'nim';
    }
}

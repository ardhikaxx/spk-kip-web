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
        // Flexible mapping for NIM
        $nim = $row['nim'] ?? $row['nomor_induk'] ?? $row['no_induk'] ?? null;
        if (!$nim) return null;

        // Flexible mapping for Nama
        $nama = $row['nama_mhs'] ?? $row['nama_mahasiswa'] ?? $row['nama'] ?? '-';

        // Flexible mapping for KIP / Jalur Seleksi
        $kip = $row['kip'] ?? null;
        if (!$kip) {
            $jalur = $row['jalur_seleksi'] ?? $row['jalur'] ?? '';
            if (stripos($jalur, 'KIP') !== false) {
                $kip = 'Memiliki KIP';
            }
        }

        return new Mahasiswa([
            'nim' => (string) $nim,
            'nama_mhs' => $nama,
            'prodi' => $row['prodi'] ?? $row['program_studi'] ?? null,
            'jurusan' => $row['jurusan'] ?? null,
            'kip' => $kip,
            'dtk' => $row['dtk'] ?? $row['dtks'] ?? null,
            'desil' => $row['desil'] ?? null,
            'kerja_ayah' => $row['kerja_ayah'] ?? $row['pekerjaan_ayah'] ?? null,
            'penghasilan_ayah' => $row['penghasilan_ayah'] ?? null,
            'keterangan_ayah' => $row['keterangan_ayah'] ?? null,
            'kerja_ibu' => $row['kerja_ibu'] ?? $row['pekerjaan_ibu'] ?? null,
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

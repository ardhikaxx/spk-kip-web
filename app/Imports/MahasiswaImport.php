<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    /**
     * Count of duplicate rows skipped during import.
     */
    public int $duplicateCount = 0;

    public function model(array $row): ?Mahasiswa
    {
        // Flexible mapping for NIM
        $nim = $row['nim'] ?? $row['nomor_induk'] ?? $row['no_induk'] ?? $row['no_pendaftaran'] ?? $row['npsn'] ?? null;
        if (!$nim) return null;

        // Flexible mapping for Nama
        $nama = $row['nama_mhs'] ?? $row['nama_mahasiswa'] ?? $row['nama'] ?? $row['nama_lengkap'] ?? '-';

        // Check for duplicate by NIM or nama_mhs
        if (Mahasiswa::where('nim', $nim)->orWhere('nama_mhs', $nama)->exists()) {
            $this->duplicateCount++;
            return null; // Skip this row
        }

        // Flexible mapping for KIP / Jalur Seleksi
        $kip = $row['kip'] ?? null;
        if (!$kip) {
            $jalur = $row['jalur_seleksi'] ?? $row['jalur'] ?? $row['jalur_pendaftaran'] ?? $row['kategori'] ?? '';
            if (stripos($jalur, 'KIP') !== false) {
                $kip = 'Memiliki KIP';
            }
        }

        // Flexible mapping for Desil (Ensure it's integer)
        $desilValue = $row['desil'] ?? $row['data_desil'] ?? null;
        $desil = $desilValue ? (int) preg_replace('/[^0-9]/', '', $desilValue) : null;

        return new Mahasiswa([
            'nim' => (string) $nim,
            'nama_mhs' => $nama,
            'prodi' => $row['prodi'] ?? $row['program_studi'] ?? $row['prodi_pilihan'] ?? null,
            'jurusan' => $row['jurusan'] ?? $row['fakultas'] ?? null,
            'kip' => $kip,
            'dtk' => $row['dtk'] ?? $row['dtks'] ?? $row['status_dtks'] ?? null,
            'desil' => $desil,
            'kerja_ayah' => $row['kerja_ayah'] ?? $row['pekerjaan_ayah'] ?? null,
            'penghasilan_ayah' => $row['penghasilan_ayah'] ?? $row['gaji_ayah'] ?? null,
            'keterangan_ayah' => $row['keterangan_ayah'] ?? null,
            'kerja_ibu' => $row['kerja_ibu'] ?? $row['pekerjaan_ibu'] ?? null,
            'penghasilan_ibu' => $row['penghasilan_ibu'] ?? $row['gaji_ibu'] ?? null,
            'keterangan_ibu' => $row['keterangan_ibu'] ?? null,
            'prestasi' => $row['prestasi'] ?? $row['data_prestasi'] ?? 'Tidak ada',
        ]);
    }
}

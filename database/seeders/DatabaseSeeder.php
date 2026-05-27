<?php

namespace Database\Seeders;

use App\Models\Bobot;
use App\Models\Kriteria;
use App\Models\KategorisasiKriteria;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@polije.ac.id'],
            [
                'nama_lengkap' => 'Administrator SPK KIP-K',
                'nomor_telepon' => '080000000001',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        $prodiData = [
            "Jurusan Produksi Pertanian" => [
                "D3 Produksi Tanaman Hortikultura", "D3 Produksi Tanaman Perkebunan", "D4 Budidaya Tanaman Perkebunan", 
                "D4 Teknik Produksi Benih", "D4 Teknologi Produksi Tanaman Pangan", "D4 Pengelolaan Perkebunan Kopi"
            ],
            "Jurusan Teknologi Pertanian" => ["D3 Teknologi Industri Pangan", "D3 Keteknikan Pertanian", "D4 Teknologi Rekayasa Pangan"],
            "Jurusan Peternakan" => ["D3 Produksi Ternak", "D4 Manajemen Bisnis Unggas", "D4 Teknologi Pakan Ternak"],
            "Jurusan Manajemen Agribisnis" => ["D3 Manajemen Agribisnis", "D4 Manajemen Agroindustri"],
            "Jurusan Teknologi Informasi" => ["D3 Manajemen Informatika", "D3 Teknik Komputer", "D4 Teknik Informatika", "D4 Teknologi Rekayasa Komputer"],
            "Jurusan Bahasa, Komunikasi, dan Pariwisata" => ["D3 Bahasa Inggris", "D4 Destinasi Pariwisata"],
            "Jurusan Kesehatan" => ["D4 Manajemen Informasi Kesehatan", "D4 Gizi Klinik", "D4 Promosi Kesehatan"],
            "Jurusan Teknik" => ["D4 Teknik Energi Terbarukan", "D4 Mesin Otomotif", "D4 Teknologi Rekayasa Mekatronika"],
            "Jurusan Bisnis" => ["D4 Akuntansi Sektor Publik", "D4 Manajemen Pemasaran Internasional"],
            "Kelas Internasional" => ["Manajemen Informatika (INT)", "Teknik Informatika (INT)", "Manajemen Agroindustri (INT)"],
            "PSDKU Bondowoso (Kampus 2)" => ["D4 Manajemen Agribisnis", "D4 Produksi Media", "D4 Bisnis Digital"],
            "PSDKU Nganjuk (Kampus 3)" => ["D3 Manajemen Agribisnis", "D4 Teknik Informatika"],
            "PSDKU Sidoarjo (Kampus 4)" => ["D4 Manajemen Agroindustri", "D4 Teknik Informatika"],
            "PSDKU Ngawi (Kampus 5)" => ["D4 Manajemen Agribisnis", "D4 Manajemen Informasi Kesehatan"],
            "PSDKU Sabu Raijua (Kampus 6)" => ["D4 Teknologi Rekayasa Perangkat Lunak"]
        ];

        foreach ($prodiData as $jurusan => $prodis) {
            foreach ($prodis as $prodi) {
                // Shorten Campus Name
                $campusShort = 'jbr'; // Default Jember (Main)
                if (stripos($jurusan, 'Bondowoso') !== false) $campusShort = 'bws';
                elseif (stripos($jurusan, 'Nganjuk') !== false) $campusShort = 'ngj';
                elseif (stripos($jurusan, 'Sidoarjo') !== false) $campusShort = 'sda';
                elseif (stripos($jurusan, 'Ngawi') !== false) $campusShort = 'ngw';
                elseif (stripos($jurusan, 'Sabu Raijua') !== false) $campusShort = 'sbj';
                elseif (stripos($jurusan, 'Internasional') !== false) $campusShort = 'int';

                // Clean Prodi Name for email (e.g., "D4 Teknik Informatika" -> "ti")
                $cleanProdi = preg_replace('/^(D3|D4)\s+/i', '', $prodi);
                $words = explode(' ', preg_replace('/[^a-z0-9 ]/i', '', $cleanProdi));
                $prodiShort = '';
                foreach ($words as $word) {
                    if (strlen($word) >= 2) $prodiShort .= strtolower($word[0]);
                }
                
                // Special cases for better readability
                if (stripos($cleanProdi, 'Informatika') !== false) $prodiShort = 'ti';
                if (stripos($cleanProdi, 'Sektor Publik') !== false) $prodiShort = 'asp';
                if (stripos($cleanProdi, 'Gizi Klinik') !== false) $prodiShort = 'gzk';
                
                if (strlen($prodiShort) < 2) {
                    $prodiShort = strtolower(substr(preg_replace('/[^a-z0-9]/i', '', $cleanProdi), 0, 3));
                }

                // Final Email: kaprodi.ti.jbr@polije.ac.id
                $email = "kaprodi.{$prodiShort}.{$campusShort}@polije.ac.id";
                
                User::updateOrCreate(
                    ['email' => $email],
                    [
                        'nama_lengkap' => 'Kaprodi ' . $prodi . ' (' . $jurusan . ')',
                        'nomor_telepon' => '081234567890',
                        'role' => 'kaprodi',
                        'jurusan' => $jurusan,
                        'prodi' => $prodi,
                        'password' => Hash::make('password'),
                    ]
                );
            }
        }

        $criteria = [
            'C1' => ['Kepemilikan KIP SMA', 0.04, ['Memiliki KIP' => 4, 'Tidak memiliki KIP, tetapi termasuk keluarga penerima bantuan sosial lain' => 3, 'Tidak memiliki KIP, tetapi memiliki SKTM dari pihak berwenang' => 2, 'Tidak memiliki semuanya' => 1]],
            'C2' => ['Status DTKS', 0.17, ['Terdaftar dalam DTKS' => 3, 'Penerima bantuan sosial' => 2, 'Belum terdaftar' => 1]],
            'C3' => ['Desil', 0.49, ['Desil 1' => 4, 'Desil 2' => 3, 'Desil 3' => 2, 'Desil > 4' => 1]],
            'C4' => ['Penghasilan Orang Tua', 0.03, ['<= Rp 1.000.000' => 5, '> Rp 1.000.000 s.d. <= Rp 2.000.000' => 4, '> Rp 2.000.000 s.d. <= Rp 3.000.000' => 3, '> Rp 3.000.000 s.d. <= Rp 4.000.000' => 2, '> Rp 4.000.000' => 1]],
            'C5' => ['Status Orang Tua', 0.24, ['Yatim Piatu' => 4, 'Yatim / Piatu' => 3, 'Orang tua sakit / tidak bekerja' => 2, 'Orang tua masih bekerja' => 1]],
            'C6' => ['Prestasi', 0.03, ['Internasional' => 5, 'Nasional' => 4, 'Provinsi / Kota' => 3, 'Sekolah' => 2, 'Tidak ada' => 1]],
        ];

        foreach ($criteria as $code => [$name, $weight, $subs]) {
            $criterion = Kriteria::updateOrCreate(
                ['kode_kriteria' => $code],
                ['nama_kriteria' => $name, 'jenis_kriteria' => 'benefit', 'nilai_bobot' => $weight]
            );

            Bobot::updateOrCreate(
                ['id_kriteria' => $criterion->id_kriteria],
                ['nilai_bobot' => $weight]
            );

            foreach ($subs as $label => $value) {
                KategorisasiKriteria::updateOrCreate(
                    ['id_kriteria' => $criterion->id_kriteria, 'nama_kategorisasi' => $label],
                    ['nilai' => $value]
                );
            }
        }
    }
}


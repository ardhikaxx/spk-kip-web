<?php

namespace Database\Seeders;

use App\Models\Bobot;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'nama_lengkap' => 'Administrator SPK KIP-K',
                'nomor_telepon' => '080000000001',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'kaprodi@gmail.com'],
            [
                'nama_lengkap' => 'Kaprodi',
                'nomor_telepon' => '080000000002',
                'role' => 'kaprodi',
                'password' => Hash::make('password'),
            ]
        );

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
                SubKriteria::updateOrCreate(
                    ['id_kriteria' => $criterion->id_kriteria, 'nama_subkriteria' => $label],
                    ['nilai' => $value]
                );
            }
        }
    }
}

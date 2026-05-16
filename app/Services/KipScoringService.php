<?php

namespace App\Services;

use App\Models\Mahasiswa;

class KipScoringService
{
    public function scoreMahasiswa(Mahasiswa $mahasiswa): array
    {
        $c1 = $this->scoreC1($mahasiswa);
        $c2 = $this->scoreC2($mahasiswa->dtk);
        $c3 = $this->scoreC3($mahasiswa->desil);
        $income = $this->parseIncome($mahasiswa->penghasilan_ayah) + $this->parseIncome($mahasiswa->penghasilan_ibu);
        $c4 = $this->incomeToScore($income);
        $c5 = $this->scoreC5($mahasiswa);
        $c6 = $this->scoreC6($mahasiswa->prestasi);

        return [
            'c1' => $c1['score'],
            'c2' => $c2['score'],
            'c3' => $c3['score'],
            'c4' => $c4['score'],
            'c5' => $c5['score'],
            'c6' => $c6['score'],
            'label_c1' => $c1['label'],
            'label_c2' => $c2['label'],
            'label_c3' => $c3['label'],
            'label_c4' => $c4['label'],
            'label_c5' => $c5['label'],
            'label_c6' => $c6['label'],
        ];
    }

    public function detailForAjax(Mahasiswa $mahasiswa): array
    {
        $scores = $this->scoreMahasiswa($mahasiswa);

        return [
            'nama' => $mahasiswa->nama_mhs,
            'kip' => $scores['label_c1'],
            'dtks' => $scores['label_c2'],
            'desil' => $scores['label_c3'],
            'penghasilan' => $scores['label_c4'],
            'status_ortu' => $scores['label_c5'],
            'prestasi' => $scores['label_c6'],
            'scores' => $scores,
        ];
    }

    private function scoreC1(Mahasiswa $mahasiswa): array
    {
        $text = $this->normalize(implode(' ', [
            $mahasiswa->kip,
            $mahasiswa->prestasi,
        ]));

        if (str_contains($text, 'kip') || str_contains($text, 'kartu indonesia pintar') || str_contains($text, 'kipk')) {
            return ['score' => 4, 'label' => 'Memiliki KIP'];
        }

        if (str_contains($text, 'bansos') || str_contains($text, 'bantuan sosial') || str_contains($text, 'kks') || str_contains($text, 'pkh')) {
            return ['score' => 3, 'label' => 'Penerima bantuan sosial'];
        }

        if (str_contains($text, 'sktm')) {
            return ['score' => 2, 'label' => 'Memiliki SKTM'];
        }

        return ['score' => 1, 'label' => 'Tidak memiliki semuanya'];
    }

    private function scoreC2(?string $value): array
    {
        $text = $this->normalize($value);

        if (str_contains($text, 'belum') || str_contains($text, 'tidak') || str_contains($text, 'non dtks') || str_contains($text, 'non-dtks')) {
            return ['score' => 1, 'label' => 'Belum terdaftar'];
        }

        if (str_contains($text, 'terdaftar') || str_contains($text, 'terdata') || str_contains($text, 'dtks') || $text === 'ya') {
            return ['score' => 3, 'label' => 'Terdaftar dalam DTKS'];
        }

        if (str_contains($text, 'bansos') || str_contains($text, 'bantuan') || str_contains($text, 'kks') || str_contains($text, 'pkh')) {
            return ['score' => 2, 'label' => 'Penerima bantuan sosial'];
        }

        return ['score' => 1, 'label' => 'Belum terdaftar'];
    }

    private function scoreC3(null|int|string $value): array
    {
        preg_match('/\d+/', (string) $value, $match);
        $desil = isset($match[0]) ? (int) $match[0] : 0;

        return match ($desil) {
            1 => ['score' => 4, 'label' => 'Desil 1'],
            2 => ['score' => 3, 'label' => 'Desil 2'],
            3 => ['score' => 2, 'label' => 'Desil 3'],
            default => ['score' => 1, 'label' => 'Desil > 4'],
        };
    }

    private function scoreC5(Mahasiswa $mahasiswa): array
    {
        $ayah = $this->normalize($mahasiswa->keterangan_ayah);
        $ibu = $this->normalize($mahasiswa->keterangan_ibu);
        $kerja = $this->normalize($mahasiswa->kerja_ayah.' '.$mahasiswa->kerja_ibu);
        $ayahMeninggal = str_contains($ayah, 'meninggal') || str_contains($ayah, 'wafat');
        $ibuMeninggal = str_contains($ibu, 'meninggal') || str_contains($ibu, 'wafat');

        if ($ayahMeninggal && $ibuMeninggal) {
            return ['score' => 4, 'label' => 'Yatim Piatu'];
        }

        if ($ayahMeninggal || $ibuMeninggal) {
            return ['score' => 3, 'label' => 'Yatim / Piatu'];
        }

        if (str_contains($ayah.' '.$ibu.' '.$kerja, 'tidak bekerja') || str_contains($ayah.' '.$ibu.' '.$kerja, 'sakit') || str_contains($ayah.' '.$ibu.' '.$kerja, 'disabilitas')) {
            return ['score' => 2, 'label' => 'Orang tua sakit / tidak bekerja'];
        }

        return ['score' => 1, 'label' => 'Orang tua masih bekerja'];
    }

    private function scoreC6(?string $value): array
    {
        $text = $this->normalize($value);

        if ($text === '' || in_array($text, ['-', '_', '0', 'tidak ada', 'belum ada', 'tidak berprestasi'], true)) {
            return ['score' => 1, 'label' => 'Tidak ada'];
        }

        if (str_contains($text, 'internasional')) {
            return ['score' => 5, 'label' => 'Internasional'];
        }

        if (str_contains($text, 'nasional')) {
            return ['score' => 4, 'label' => 'Nasional'];
        }

        if (str_contains($text, 'provinsi') || str_contains($text, 'kabupaten') || str_contains($text, 'kota') || str_contains($text, 'kejurda') || str_contains($text, 'jawa timur')) {
            return ['score' => 3, 'label' => 'Provinsi / Kota'];
        }

        return ['score' => 2, 'label' => 'Sekolah'];
    }

    private function parseIncome(?string $value): int
    {
        $text = $this->normalize($value);
        if ($text === '' || in_array($text, ['-', '_', 'nan', 'none'], true)) {
            return 0;
        }

        preg_match_all('/\d[\d.]*/', $text, $matches);
        $numbers = array_map(fn ($item) => (int) preg_replace('/[^0-9]/', '', $item), $matches[0] ?? []);

        return $numbers ? max($numbers) : 0;
    }

    private function incomeToScore(int $amount): array
    {
        if ($amount <= 1000000) {
            return ['score' => 5, 'label' => '<= Rp 1.000.000'];
        }

        if ($amount <= 2000000) {
            return ['score' => 4, 'label' => '> Rp 1.000.000 s.d. <= Rp 2.000.000'];
        }

        if ($amount <= 3000000) {
            return ['score' => 3, 'label' => '> Rp 2.000.000 s.d. <= Rp 3.000.000'];
        }

        if ($amount <= 4000000) {
            return ['score' => 2, 'label' => '> Rp 3.000.000 s.d. <= Rp 4.000.000'];
        }

        return ['score' => 1, 'label' => '> Rp 4.000.000'];
    }

    private function normalize(?string $value): string
    {
        return trim(preg_replace('/\s+/', ' ', strtolower((string) $value)) ?? '');
    }
}

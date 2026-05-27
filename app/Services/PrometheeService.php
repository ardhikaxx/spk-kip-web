<?php

namespace App\Services;

use App\Models\Alternatif;
use App\Models\Bobot;
use App\Models\HasilPerhitungan;
use App\Models\Kriteria;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PrometheeService
{
    private const TIE_BREAKERS = ['c3', 'c5', 'c2', 'c4', 'c1', 'c6'];

    public function calculate(int $tahun, ?int $quota = null): array
    {
        $criteria = Kriteria::orderBy('kode_kriteria')->get();
        $weights = Bobot::with('kriteria')->get()->keyBy(fn (Bobot $bobot) => $bobot->kriteria->kode_kriteria);
        $alternatives = Alternatif::with('mahasiswa')->where('tahun', $tahun)->get();

        if ($criteria->count() !== 6) {
            throw new RuntimeException('Jumlah kriteria harus lengkap C1 sampai C6.');
        }

        if ($alternatives->count() < 2) {
            throw new RuntimeException('Minimal diperlukan 2 alternatif pada tahun yang dipilih.');
        }

        $weightVector = [];
        foreach ($criteria as $criterion) {
            $code = strtolower($criterion->kode_kriteria);
            $weight = (float) ($weights[$criterion->kode_kriteria]->nilai_bobot ?? $criterion->nilai_bobot);
            $weightVector[$code] = $weight;
        }

        $totalWeight = array_sum($weightVector);
        if (abs($totalWeight - 1.0) > 0.000001) {
            $formattedTotal = round($totalWeight, 2);
            throw new RuntimeException("Total bobot harus 1. Total saat ini {$formattedTotal}.");
        }

        $rows = $alternatives->values();
        $n = $rows->count();
        $pi = array_fill(0, $n, array_fill(0, $n, 0.0));

        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($i === $j) {
                    continue;
                }

                foreach ($weightVector as $code => $weight) {
                    $diff = (int) $rows[$i]->{$code} - (int) $rows[$j]->{$code};
                    $pi[$i][$j] += $weight * ($diff > 0 ? 1.0 : 0.0);
                }
            }
        }

        $ranked = [];
        for ($i = 0; $i < $n; $i++) {
            $leaving = array_sum($pi[$i]) / ($n - 1);
            $entering = array_sum(array_column($pi, $i)) / ($n - 1);
            $net = $leaving - $entering;
            $ranked[] = [
                'alternative' => $rows[$i],
                'leaving_flow' => $leaving,
                'entering_flow' => $entering,
                'net_flow' => $net,
            ];
        }

        usort($ranked, function (array $a, array $b): int {
            foreach (['net_flow', 'leaving_flow'] as $key) {
                if (abs($a[$key] - $b[$key]) > 0.00000001) {
                    return $a[$key] < $b[$key] ? 1 : -1;
                }
            }

            foreach (self::TIE_BREAKERS as $column) {
                if ($a['alternative']->{$column} !== $b['alternative']->{$column}) {
                    return $a['alternative']->{$column} < $b['alternative']->{$column} ? 1 : -1;
                }
            }

            return strcmp($a['alternative']->mahasiswa->nama_mhs, $b['alternative']->mahasiswa->nama_mhs);
        });

        $quota ??= $n;

        DB::transaction(function () use ($ranked, $tahun, $quota): void {
            HasilPerhitungan::where('tahun', $tahun)->delete();

            foreach ($ranked as $index => $row) {
                HasilPerhitungan::create([
                    'id_alternatif' => $row['alternative']->id_alternatif,
                    'leaving_flow' => round($row['leaving_flow'], 8),
                    'entering_flow' => round($row['entering_flow'], 8),
                    'net_flow' => round($row['net_flow'], 8),
                    'ranking' => $index + 1,
                    'status' => ($index + 1) <= $quota ? 'Penerima' : 'Bukan Penerima',
                    'tahun' => $tahun,
                ]);
            }
        });

        return [
            'total' => $n,
            'tahun' => $tahun,
            'quota' => $quota,
        ];
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\Bobot;
use App\Models\Kriteria;
use App\Services\PrometheeService;
use Illuminate\Http\Request;
use Throwable;

class PrometheeController extends Controller
{
    public function index(Request $request)
    {
        $years = Alternatif::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');
        $tahun = (int) ($request->query('tahun') ?: ($years->first() ?: now()->year));
        $kriteria = Kriteria::with('bobot')->orderBy('kode_kriteria')->get();
        $totalWeight = round($kriteria->sum(fn ($item) => (float) ($item->bobot->nilai_bobot ?? $item->nilai_bobot)), 2);

        return view('admin.promethee.index', [
            'kriteria' => $kriteria,
            'years' => $years,
            'tahun' => $tahun,
            'statusBobot' => abs($totalWeight - 1.0) <= 0.0001,
            'totalAlternatif' => Alternatif::where('tahun', $tahun)->count(),
            'totalKriteria' => $kriteria->count(),
        ]);
    }

    public function hitung(Request $request, PrometheeService $promethee)
    {
        // Increase execution time limit for large calculations
        ini_set('max_execution_time', 300); // 5 minutes

        $data = $request->validate([
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'quota' => ['nullable', 'integer', 'min:1'],
        ]);

        try {
            $promethee->calculate((int) $data['tahun'], $data['quota'] ?? null);
        } catch (Throwable $e) {
            return back()->withErrors(['promethee' => $e->getMessage()]);
        }

        return redirect()->route('hasil.index', ['tahun' => $data['tahun']])->with('success', 'Perhitungan PROMETHEE berhasil dijalankan.');
    }
}

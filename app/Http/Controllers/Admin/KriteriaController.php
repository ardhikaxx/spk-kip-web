<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bobot;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->paginate(10);
        $totalWeight = Kriteria::sum('nilai_bobot');
        
        return view('admin.kriteria.index', [
            'kriteria' => $kriteria,
            'totalWeight' => $totalWeight
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        
        $currentTotal = Kriteria::sum('nilai_bobot');
        if (($currentTotal + $data['nilai_bobot']) > 1.0001) {
            $maxAllowed = 1.0 - $currentTotal;
            return back()->withErrors(['nilai_bobot' => "Total bobot tidak boleh melebihi 1. Sisa bobot yang tersedia: " . number_format($maxAllowed, 2)])->withInput();
        }

        $criterion = Kriteria::create($data);
        Bobot::create(['id_kriteria' => $criterion->id_kriteria, 'nilai_bobot' => $data['nilai_bobot']]);

        return back()->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function update(Request $request, Kriteria $kriterium)
    {
        $data = $this->validated($request, $kriterium->id_kriteria);
        
        $currentTotal = Kriteria::where('id_kriteria', '!=', $kriterium->id_kriteria)->sum('nilai_bobot');
        if (($currentTotal + $data['nilai_bobot']) > 1.0001) {
            $maxAllowed = 1.0 - $currentTotal;
            return back()->withErrors(['nilai_bobot' => "Total bobot tidak boleh melebihi 1. Sisa bobot yang tersedia: " . number_format($maxAllowed, 2)])->withInput();
        }

        $kriterium->update($data);
        Bobot::updateOrCreate(['id_kriteria' => $kriterium->id_kriteria], ['nilai_bobot' => $data['nilai_bobot']]);

        return back()->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Kriteria $kriterium)
    {
        $kriterium->delete();

        return back()->with('success', 'Kriteria berhasil dihapus.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'kode_kriteria' => ['required', 'string', 'max:10', $ignoreId ? "unique:tb_kriteria,kode_kriteria,{$ignoreId},id_kriteria" : 'unique:tb_kriteria,kode_kriteria'],
            'nama_kriteria' => ['required', 'string', 'max:255'],
            'jenis_kriteria' => ['required', 'in:benefit,cost'],
            'nilai_bobot' => ['required', 'numeric', 'min:0', 'max:1'],
        ]);
    }
}

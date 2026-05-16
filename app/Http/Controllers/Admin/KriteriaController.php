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
        return view('admin.kriteria.index', ['kriteria' => Kriteria::orderBy('kode_kriteria')->paginate(10)]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $criterion = Kriteria::create($data);
        Bobot::create(['id_kriteria' => $criterion->id_kriteria, 'nilai_bobot' => $data['nilai_bobot']]);

        return back()->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function update(Request $request, Kriteria $kriterium)
    {
        $data = $this->validated($request, $kriterium->id_kriteria);
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

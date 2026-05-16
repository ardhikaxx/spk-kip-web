<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function index()
    {
        return view('admin.sub-kriteria.index', ['kriteria' => Kriteria::with('subKriteria')->orderBy('kode_kriteria')->get()]);
    }

    public function edit(Kriteria $sub_kriterium)
    {
        return view('admin.sub-kriteria.edit', ['kriteria' => $sub_kriterium->load('subKriteria')]);
    }

    public function update(Request $request, Kriteria $sub_kriterium)
    {
        $data = $request->validate([
            'sub' => ['array'],
            'sub.*.nilai' => ['required', 'integer', 'min:1'],
            'sub.*.nama_subkriteria' => ['required', 'string', 'max:255'],
        ]);

        $sub_kriterium->subKriteria()->delete();
        foreach ($data['sub'] ?? [] as $row) {
            SubKriteria::create([
                'id_kriteria' => $sub_kriterium->id_kriteria,
                'nilai' => $row['nilai'],
                'nama_subkriteria' => $row['nama_subkriteria'],
            ]);
        }

        return redirect()->route('sub-kriteria.index')->with('success', 'Sub kriteria berhasil disimpan.');
    }
}

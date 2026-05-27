<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\KategorisasiKriteria;
use Illuminate\Http\Request;

class KategorisasiKriteriaController extends Controller
{
    public function index()
    {
        return view('admin.kategorisasi-kriteria.index', ['kriteria' => Kriteria::with('kategorisasiKriteria')->orderBy('kode_kriteria')->get()]);
    }

    public function edit(Kriteria $kategorisasi_kriterium)
    {
        return view('admin.kategorisasi-kriteria.edit', ['kriteria' => $kategorisasi_kriterium->load('kategorisasiKriteria')]);
    }

    public function update(Request $request, Kriteria $kategorisasi_kriterium)
    {
        $data = $request->validate([
            'kategori' => ['array'],
            'kategori.*.nilai' => ['required', 'integer', 'min:1'],
            'kategori.*.nama_kategorisasi' => ['required', 'string', 'max:255'],
        ]);

        $kategorisasi_kriterium->kategorisasiKriteria()->delete();
        foreach ($data['kategori'] ?? [] as $row) {
            KategorisasiKriteria::create([
                'id_kriteria' => $kategorisasi_kriterium->id_kriteria,
                'nilai' => $row['nilai'],
                'nama_kategorisasi' => $row['nama_kategorisasi'],
            ]);
        }

        return redirect()->route('kategorisasi-kriteria.index')->with('success', 'Kategorisasi kriteria berhasil disimpan.');
    }
}

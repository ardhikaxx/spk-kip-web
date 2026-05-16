<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bobot;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class BobotController extends Controller
{
    public function index()
    {
        return view('admin.bobot.index', ['kriteria' => Kriteria::with('bobot')->orderBy('kode_kriteria')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['bobot' => ['required', 'array'], 'bobot.*' => ['required', 'numeric', 'min:0', 'max:1']]);
        $total = round(array_sum($data['bobot']), 4);

        if (abs($total - 1.0) > 0.0001) {
            return back()->withErrors(['bobot' => "Total bobot harus 1.0000. Total saat ini {$total}."])->withInput();
        }

        foreach ($data['bobot'] as $idKriteria => $nilai) {
            Bobot::updateOrCreate(['id_kriteria' => $idKriteria], ['nilai_bobot' => $nilai]);
            Kriteria::whereKey($idKriteria)->update(['nilai_bobot' => $nilai]);
        }

        return back()->with('success', 'Bobot kriteria berhasil disimpan.');
    }
}

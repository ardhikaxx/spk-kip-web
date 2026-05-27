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
        $total = array_sum($data['bobot']);

        if (abs($total - 1.0) > 0.000001) {
            $currentTotal = round($total, 2);
            return back()->withErrors(['bobot' => "Total bobot harus 1. Total saat ini {$currentTotal}."])->withInput();
        }

        foreach ($data['bobot'] as $idKriteria => $nilai) {
            Bobot::updateOrCreate(['id_kriteria' => $idKriteria], ['nilai_bobot' => $nilai]);
            Kriteria::whereKey($idKriteria)->update(['nilai_bobot' => $nilai]);
        }

        return back()->with('success', 'Bobot kriteria berhasil disimpan.');
    }
}

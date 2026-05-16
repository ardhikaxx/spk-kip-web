<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\HasilPerhitungan;
use App\Models\Kriteria;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $hasil = HasilPerhitungan::with('alternatif.mahasiswa')->orderBy('ranking')->limit(10)->get();

        return view('admin.dashboard.index', [
            'totalPendaftar' => Alternatif::count(),
            'totalPenerima' => HasilPerhitungan::where('status', 'Penerima')->count(),
            'totalKriteria' => Kriteria::count(),
            'chartLabels' => $hasil->map(fn ($row) => $row->alternatif?->mahasiswa?->nama_mhs)->values(),
            'chartValues' => $hasil->pluck('net_flow')->map(fn ($value) => (float) $value)->values(),
        ]);
    }
}

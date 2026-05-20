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

        // Data for Distribution Chart (Recipients vs Non-Recipients)
        $penerimaCount = HasilPerhitungan::where('status', 'Penerima')->count();
        $tidakPenerimaCount = HasilPerhitungan::where('status', 'Tidak Penerima')->count();

        // Data for Jurusan Chart
        $jurusanStats = \App\Models\Mahasiswa::select('jurusan', \DB::raw('count(*) as total'))
            ->whereNotNull('jurusan')
            ->groupBy('jurusan')
            ->get();

        return view('admin.dashboard.index', [
            'totalPendaftar' => Alternatif::count(),
            'totalPenerima' => $penerimaCount,
            'totalKriteria' => Kriteria::count(),
            
            // Ranking Chart Data
            'chartLabels' => $hasil->map(fn ($row) => $row->alternatif?->mahasiswa?->nama_mhs)->values(),
            'chartValues' => $hasil->pluck('net_flow')->map(fn ($value) => (float) $value)->values(),

            // Distribution Chart Data
            'distributionLabels' => ['Penerima', 'Tidak Penerima'],
            'distributionValues' => [$penerimaCount, $tidakPenerimaCount],

            // Jurusan Chart Data
            'jurusanLabels' => $jurusanStats->pluck('jurusan')->values(),
            'jurusanValues' => $jurusanStats->pluck('total')->values(),
        ]);
    }
}

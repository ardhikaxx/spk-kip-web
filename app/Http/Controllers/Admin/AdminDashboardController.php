<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\HasilPerhitungan;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $years = HasilPerhitungan::distinct()->pluck('tahun')->sortDesc()->toArray();
        
        // Default to the latest year available, or current year if no data exists
        $defaultYear = !empty($years) ? $years[0] : date('Y');
        $tahun = $request->query('tahun', $defaultYear);

        // If requested year is not in available years, force default to latest
        if (!empty($years) && !in_array($tahun, $years)) {
            $tahun = $years[0];
        }

        $hasil = HasilPerhitungan::with('alternatif.mahasiswa')
            ->where('tahun', $tahun)
            ->orderBy('ranking')
            ->limit(10)
            ->get();

        $penerimaCount = HasilPerhitungan::where('status', 'Penerima')->where('tahun', $tahun)->count();
        $tidakPenerimaCount = HasilPerhitungan::where('status', 'Tidak Penerima')->where('tahun', $tahun)->count();

        $jurusanStats = \App\Models\Mahasiswa::select('jurusan', \DB::raw('count(*) as total'))
            ->whereNotNull('jurusan')
            ->groupBy('jurusan')
            ->get();

        return view('admin.dashboard.index', [
            'totalPendaftar' => Alternatif::where('tahun', $tahun)->count(),
            'totalPenerima' => $penerimaCount,
            'totalKriteria' => Kriteria::count(),
            'tahun' => $tahun,
            'years' => $years,
            
            'chartLabels' => $hasil->map(fn ($row) => $row->alternatif?->mahasiswa?->nama_mhs)->values(),
            'chartValues' => $hasil->pluck('net_flow')->map(fn ($value) => (float) $value)->values(),

            'distributionLabels' => ['Penerima', 'Tidak Penerima'],
            'distributionValues' => ($penerimaCount > 0 || $tidakPenerimaCount > 0) ? [$penerimaCount, $tidakPenerimaCount] : null,

            'jurusanLabels' => $jurusanStats->pluck('jurusan')->values(),
            'jurusanValues' => $jurusanStats->pluck('total')->values(),
        ]);
    }
}

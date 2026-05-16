<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilPerhitungan;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index(Request $request)
    {
        $years = HasilPerhitungan::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');
        $tahun = (int) ($request->query('tahun') ?: ($years->first() ?: now()->year));
        $hasil = HasilPerhitungan::with('alternatif.mahasiswa')
            ->where('tahun', $tahun)
            ->orderBy('ranking')
            ->paginate(20)
            ->withQueryString();
        $top = HasilPerhitungan::with('alternatif.mahasiswa')->where('tahun', $tahun)->orderBy('ranking')->first();

        return view('admin.hasil.index', [
            'hasil' => $hasil,
            'years' => $years,
            'tahun' => $tahun,
            'top' => $top,
            'totalPenerima' => HasilPerhitungan::where('tahun', $tahun)->where('status', 'Penerima')->count(),
        ]);
    }

    public function downloadPdf(int $tahun)
    {
        $hasil = HasilPerhitungan::with('alternatif.mahasiswa')->where('tahun', $tahun)->orderBy('ranking')->get();
        $html = view('admin.hasil.pdf', compact('hasil', 'tahun'))->render();

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->download("hasil-promethee-{$tahun}.pdf");
        }

        return response($html);
    }
}

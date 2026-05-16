<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Mahasiswa;
use App\Services\KipScoringService;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $alternatif = Alternatif::with('mahasiswa')
            ->when($search, fn ($query) => $query->whereHas('mahasiswa', fn ($q) => $q->where('nama_mhs', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%")))
            ->orderByDesc('tahun')
            ->paginate(10)
            ->withQueryString();

        return view('admin.alternatif.index', [
            'alternatif' => $alternatif,
            'mahasiswa' => Mahasiswa::orderBy('nama_mhs')->get(),
            'kriteria' => Kriteria::orderBy('kode_kriteria')->get(),
            'search' => $search,
        ]);
    }

    public function store(Request $request, KipScoringService $scoring)
    {
        $data = $request->validate([
            'nim' => ['required', 'exists:tb_mahasiswa,nim'],
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
        ]);

        $mahasiswa = Mahasiswa::findOrFail($data['nim']);
        $scores = $scoring->scoreMahasiswa($mahasiswa);

        Alternatif::updateOrCreate(
            ['nim' => $data['nim'], 'tahun' => $data['tahun']],
            array_merge($scores, ['nim' => $data['nim'], 'tahun' => $data['tahun']])
        );

        return back()->with('success', 'Alternatif berhasil disimpan.');
    }

    public function bulkStore(Request $request, KipScoringService $scoring)
    {
        $request->validate([
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
        ]);

        $tahun = $request->tahun;
        $mahasiswaList = Mahasiswa::all();

        foreach ($mahasiswaList as $mahasiswa) {
            $scores = $scoring->scoreMahasiswa($mahasiswa);
            Alternatif::updateOrCreate(
                ['nim' => $mahasiswa->nim, 'tahun' => $tahun],
                array_merge($scores, ['nim' => $mahasiswa->nim, 'tahun' => $tahun])
            );
        }

        return back()->with('success', "Semua data mahasiswa berhasil ditambahkan sebagai alternatif tahun {$tahun}.");
    }

    public function destroy(Alternatif $alternatif)
    {
        $alternatif->delete();

        return back()->with('success', 'Alternatif berhasil dihapus.');
    }

    public function getMahasiswaDetail(string $nim, KipScoringService $scoring)
    {
        $mahasiswa = Mahasiswa::find($nim);
        if (! $mahasiswa) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($scoring->detailForAjax($mahasiswa));
    }
}

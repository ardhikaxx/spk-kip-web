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

        // Check if alternatif already exists for this nim and tahun
        if (Alternatif::where('nim', $data['nim'])->where('tahun', $data['tahun'])->exists()) {
            return back()->with('error', 'Data alternatif untuk NIM ini dan tahun yang sama sudah ada.');
        }

        $mahasiswa = Mahasiswa::findOrFail($data['nim']);
        $scores = $scoring->scoreMahasiswa($mahasiswa);

        Alternatif::create(array_merge($scores, ['nim' => $data['nim'], 'tahun' => $data['tahun']]));

        return back()->with('success', 'Alternatif berhasil disimpan.');
    }

    public function bulkStore(Request $request, KipScoringService $scoring)
    {
        $request->validate([
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
        ]);

        $tahun = $request->tahun;
        $mahasiswaList = Mahasiswa::all();
        $createdCount = 0;
        $skippedCount = 0;

        foreach ($mahasiswaList as $mahasiswa) {
            // Check if alternatif already exists for this nim and tahun
            if (Alternatif::where('nim', $mahasiswa->nim)->where('tahun', $tahun)->exists()) {
                $skippedCount++;
                continue;
            }

            $scores = $scoring->scoreMahasiswa($mahasiswa);
            Alternatif::create(array_merge($scores, ['nim' => $mahasiswa->nim, 'tahun' => $tahun]));
            $createdCount++;
        }

        $successMessage = "Berhasil menambahkan {$createdCount} data mahasiswa sebagai alternatif tahun {$tahun}.";
        if ($skippedCount > 0) {
            $successMessage .= " {$skippedCount} data diabaikan karena sudah ada untuk tahun tersebut.";
        }

        return back()->with('success', $successMessage);
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

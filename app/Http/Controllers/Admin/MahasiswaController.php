<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\MahasiswaImport;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $mahasiswa = Mahasiswa::query()
            ->when($search, fn ($query) => $query->where('nim', 'like', "%{$search}%")->orWhere('nama_mhs', 'like', "%{$search}%"))
            ->orderBy('nama_mhs')
            ->paginate(10)
            ->withQueryString();

        return view('admin.mahasiswa.index', compact('mahasiswa', 'search'));
    }

    public function store(Request $request)
    {
        Mahasiswa::create($this->validated($request));

        return back()->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $mahasiswa->update($this->validated($request, $mahasiswa->nim));

        return back()->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return back()->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    public function destroyAll(Request $request)
    {
        $request->validate([
            'nims' => ['required', 'string'],
        ]);

        $nims = json_decode($request->nims, true);
        
        if (!is_array($nims) || count($nims) === 0) {
            return back()->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
        }

        // Delete all selected mahasiswa
        $deletedCount = Mahasiswa::whereIn('nim', $nims)->delete();

        return back()->with('success', "{$deletedCount} data mahasiswa berhasil dihapus.");
    }

    public function import(Request $request)
    {
        $request->validate(['file' => ['required', 'file', 'mimes:xlsx,xls,csv,txt']]);
        $import = new MahasiswaImport;
        Excel::import($import, $request->file('file'));

        $successMessage = 'Data mahasiswa berhasil diimpor.';
        if ($import->duplicateCount > 0) {
            $successMessage .= " {$import->duplicateCount} data duplikat (NIM atau nama sudah ada) telah diabaikan.";
        }

        return back()->with('success', $successMessage);
    }

    public function template()
    {
        $headers = ['nim', 'nama_mhs', 'prodi', 'jurusan', 'kip', 'dtk', 'desil', 'kerja_ayah', 'penghasilan_ayah', 'keterangan_ayah', 'kerja_ibu', 'penghasilan_ibu', 'keterangan_ibu', 'prestasi'];

        return Response::streamDownload(function () use ($headers): void {
            $out = fopen('php://output', 'w');
            fputcsv($out, $headers);
            fclose($out);
        }, 'template-mahasiswa.csv', ['Content-Type' => 'text/csv']);
    }

    private function validated(Request $request, ?string $ignoreNim = null): array
    {
        return $request->validate([
            'nim' => ['required', 'string', 'max:30', $ignoreNim ? "unique:tb_mahasiswa,nim,{$ignoreNim},nim" : 'unique:tb_mahasiswa,nim'],
            'nama_mhs' => ['required', 'string', 'max:255', $ignoreNim ? "unique:tb_mahasiswa,nama_mhs,{$ignoreNim},nim" : 'unique:tb_mahasiswa,nama_mhs'],
            'prodi' => ['required', 'string', 'max:255'],
            'jurusan' => ['required', 'string', 'max:255'],
            'kip' => ['required', 'string', 'max:255'],
            'dtk' => ['required', 'string', 'max:255'],
            'desil' => ['required', 'integer'],
            'kerja_ayah' => ['required', 'string', 'max:255'],
            'penghasilan_ayah' => ['required', 'string', 'max:255'],
            'keterangan_ayah' => ['required', 'string', 'max:255'],
            'kerja_ibu' => ['required', 'string', 'max:255'],
            'penghasilan_ibu' => ['required', 'string', 'max:255'],
            'keterangan_ibu' => ['required', 'string', 'max:255'],
            'prestasi' => ['required', 'string', 'max:255'],
        ]);
    }
}

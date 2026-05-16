<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class KaprodiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $mahasiswa = Mahasiswa::query()
            ->when($search, fn ($query) => $query->where('nim', 'like', "%{$search}%")->orWhere('nama_mhs', 'like', "%{$search}%"))
            ->orderBy('nama_mhs')
            ->paginate(10)
            ->withQueryString();

        return view('kaprodi.dashboard', compact('mahasiswa', 'search'));
    }

    public function suratRekomendasi(string $nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);

        return view('kaprodi.surat', compact('mahasiswa'));
    }

    public function downloadSurat(string $nim)
    {
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $html = view('kaprodi.surat-pdf', compact('mahasiswa'))->render();

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->download("surat-rekomendasi-{$nim}.pdf");
        }

        return response($html);
    }
}

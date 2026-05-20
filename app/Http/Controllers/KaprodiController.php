<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class KaprodiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $user = auth()->user();

        $mahasiswa = Mahasiswa::query()
            ->when($user->role === 'kaprodi', fn ($query) => $query->where('prodi', $user->prodi))
            ->when($search, fn ($query) => $query->where(function($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                  ->orWhere('nama_mhs', 'like', "%{$search}%");
            }))
            ->orderBy('nama_mhs')
            ->paginate(10)
            ->withQueryString();

        return view('kaprodi.dashboard', compact('mahasiswa', 'search'));
    }

    public function suratRekomendasi(string $nim)
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('nim', $nim)
            ->when($user->role === 'kaprodi', fn ($query) => $query->where('prodi', $user->prodi))
            ->firstOrFail();

        return view('kaprodi.surat', compact('mahasiswa'));
    }

    public function downloadSurat(string $nim)
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('nim', $nim)
            ->when($user->role === 'kaprodi', fn ($query) => $query->where('prodi', $user->prodi))
            ->firstOrFail();

        $html = view('kaprodi.surat-pdf', compact('mahasiswa'))->render();

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->download("surat-rekomendasi-{$nim}.pdf");
        }

        return response($html);
    }
}

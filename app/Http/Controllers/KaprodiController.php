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
            ->when($user->role === 'kaprodi', function ($query) use ($user) {
                $this->applyKaprodiFilter($query, $user);
            })
            ->when($search, fn ($query) => $query->where(function($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                  ->orWhere('nama_mhs', 'like', "%{$search}%");
            }))
            ->orderBy('nama_mhs')
            ->paginate(10)
            ->withQueryString();

        return view('kaprodi.dashboard', compact('mahasiswa', 'search'));
    }

    /**
     * Applies student filtering based on Kaprodi's assigned prodi and jurusan.
     */
    private function applyKaprodiFilter($query, $user)
    {
        $coreProdi = $this->getCoreName($user->prodi);
        $campus = $this->getCampusName($user->jurusan);

        // Filter by Program Studi (and handle typos)
        if ($coreProdi) {
            $query->where(function ($q) use ($coreProdi) {
                // Direct match
                $q->where('prodi', 'LIKE', "%{$coreProdi}%")
                  ->orWhere('jurusan', 'LIKE', "%{$coreProdi}%");

                // Handle common typos (Informatika -> Infomatika, Akuntansi -> Akutansi, Teknologi -> Teknik)
                $typos = [];
                if (stripos($coreProdi, 'Informatika') !== false) {
                    $typos[] = str_ireplace('Informatika', 'Infomatika', $coreProdi);
                }
                if (stripos($coreProdi, 'Akuntansi') !== false) {
                    $typos[] = str_ireplace('Akuntansi', 'Akutansi', $coreProdi);
                }
                if (stripos($coreProdi, 'Teknologi') !== false) {
                    $typos[] = str_ireplace('Teknologi', 'Teknik', $coreProdi);
                }

                foreach ($typos as $typo) {
                    $q->orWhere('prodi', 'LIKE', "%{$typo}%")
                      ->orWhere('jurusan', 'LIKE', "%{$typo}%");
                }
            });
        }

        // Filter by Campus/Jurusan
        if ($campus) {
            $query->where(function ($q) use ($campus) {
                $q->where('prodi', 'LIKE', "%{$campus}%")
                  ->orWhere('jurusan', 'LIKE', "%{$campus}%");
            });
        } else {
            // If no specific campus (Main Campus), exclude other campuses
            $query->where(function ($q) {
                $q->where('prodi', 'NOT LIKE', '%PSDKU%')
                  ->where('prodi', 'NOT LIKE', '%Kampus%')
                  ->where(function ($q) {
                      $q->whereNull('jurusan')
                        ->orWhere(function ($q) {
                            $q->where('jurusan', 'NOT LIKE', '%PSDKU%')
                              ->where('jurusan', 'NOT LIKE', '%Kampus%');
                        });
                  });
            });
        }
    }

    /**
     * Extracts a core name for more flexible matching.
     */
    private function getCoreName(string $name): string
    {
        $name = preg_replace('/^(D3|D4)\s+/i', '', $name);
        $name = preg_replace('/\s*\(.*?\)\s*/', '', $name);
        $name = preg_replace('/^(Jurusan|Program Studi)\s+/i', '', $name);
        return trim($name);
    }

    /**
     * Extracts campus name from jurusan string.
     */
    private function getCampusName(string $jurusan): ?string
    {
        if (stripos($jurusan, 'PSDKU') !== false || stripos($jurusan, 'Kampus') !== false) {
            // Match "PSDKU [Name]" or "Kampus [Name]"
            if (preg_match('/(PSDKU|Kampus)\s+([^\s\(]+)/i', $jurusan, $matches)) {
                return $matches[2];
            }
        }
        return null;
    }

    public function suratRekomendasi(string $nim)
    {
        $user = auth()->user();

        $mahasiswa = Mahasiswa::where('nim', $nim)
            ->when($user->role === 'kaprodi', function ($query) use ($user) {
                $this->applyKaprodiFilter($query, $user);
            })
            ->firstOrFail();

        return view('kaprodi.surat', compact('mahasiswa'));
    }

    public function downloadSurat(string $nim)
    {
        $user = auth()->user();

        $mahasiswa = Mahasiswa::where('nim', $nim)
            ->when($user->role === 'kaprodi', function ($query) use ($user) {
                $this->applyKaprodiFilter($query, $user);
            })
            ->firstOrFail();

        $html = view('kaprodi.surat-pdf', compact('mahasiswa'))->render();

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->download("surat-rekomendasi-{$nim}.pdf");
        }

        return response($html);
    }
}

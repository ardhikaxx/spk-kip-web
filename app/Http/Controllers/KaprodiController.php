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
                $coreProdi = $this->getCoreName($user->prodi);
                $campus = $this->getCampusName($user->jurusan);

                // Apply prodi filter
                if ($coreProdi) {
                    // Handle common typos in imported data
                    $typoMap = [
                        'Informatika' => 'Infom', // Matches Informatika and Infomatika
                        'Akuntansi' => 'Akutansi', // Matches Akuntansi and Akutansi
                    ];
                    
                    $searchProdi = $coreProdi;
                    foreach ($typoMap as $correct => $typo) {
                        if (stripos($coreProdi, $correct) !== false) {
                            $searchProdi = str_ireplace($correct, $typo, $coreProdi);
                            break;
                        }
                    }
                    
                    $query->where('prodi', 'LIKE', "%{$searchProdi}%");
                }

                // Apply campus filter
                if ($campus) {
                    $query->where('prodi', 'LIKE', "%{$campus}%");
                } else {
                    // If no specific campus (Main Campus), exclude other campuses
                    $query->where(function($q) {
                        $q->where('prodi', 'NOT LIKE', '%PSDKU%')
                          ->where('prodi', 'NOT LIKE', '%Kampus%');
                    });
                }
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
                $coreProdi = $this->getCoreName($user->prodi);
                $campus = $this->getCampusName($user->jurusan);

                if ($coreProdi) {
                    $typoMap = ['Informatika' => 'Infom', 'Akuntansi' => 'Akutansi'];
                    $searchProdi = $coreProdi;
                    foreach ($typoMap as $correct => $typo) {
                        if (stripos($coreProdi, $correct) !== false) {
                            $searchProdi = str_ireplace($correct, $typo, $coreProdi);
                            break;
                        }
                    }
                    $query->where('prodi', 'LIKE', "%{$searchProdi}%");
                }

                if ($campus) {
                    $query->where('prodi', 'LIKE', "%{$campus}%");
                } else {
                    $query->where(function($q) {
                        $q->where('prodi', 'NOT LIKE', '%PSDKU%')
                          ->where('prodi', 'NOT LIKE', '%Kampus%');
                    });
                }
            })
            ->firstOrFail();

        return view('kaprodi.surat', compact('mahasiswa'));
    }

    public function downloadSurat(string $nim)
    {
        $user = auth()->user();

        $mahasiswa = Mahasiswa::where('nim', $nim)
            ->when($user->role === 'kaprodi', function ($query) use ($user) {
                $coreProdi = $this->getCoreName($user->prodi);
                $campus = $this->getCampusName($user->jurusan);

                if ($coreProdi) {
                    $typoMap = ['Informatika' => 'Infom', 'Akuntansi' => 'Akutansi'];
                    $searchProdi = $coreProdi;
                    foreach ($typoMap as $correct => $typo) {
                        if (stripos($coreProdi, $correct) !== false) {
                            $searchProdi = str_ireplace($correct, $typo, $coreProdi);
                            break;
                        }
                    }
                    $query->where('prodi', 'LIKE', "%{$searchProdi}%");
                }

                if ($campus) {
                    $query->where('prodi', 'LIKE', "%{$campus}%");
                } else {
                    $query->where(function($q) {
                        $q->where('prodi', 'NOT LIKE', '%PSDKU%')
                          ->where('prodi', 'NOT LIKE', '%Kampus%');
                    });
                }
            })
            ->firstOrFail();

        $html = view('kaprodi.surat-pdf', compact('mahasiswa'))->render();

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->download("surat-rekomendasi-{$nim}.pdf");
        }

        return response($html);
    }
}

# Rule SPK Web — Sistem Pendukung Keputusan Beasiswa KIP-K
## Politeknik Negeri Jember | Metode PROMETHEE | Laravel + MySQL

---

## 1. Gambaran Umum Proyek

Website ini adalah Sistem Pendukung Keputusan (SPK) berbasis web untuk membantu proses seleksi penerima beasiswa KIP-K (Kartu Indonesia Pintar – Kuliah) di Politeknik Negeri Jember menggunakan metode **PROMETHEE (Preference Ranking Organization Method for Enrichment Evaluation)**.

| Item | Detail |
|---|---|
| Framework | Laravel (versi terbaru) |
| Database | MySQL |
| Nama Database | `spk_kip_web` |
| Template Engine | Blade |
| CSS Framework | Bootstrap (CDN) |
| Alert Library | SweetAlert2 (CDN) |
| Select Library | Select2 (CDN) |

---

## 2. Role & Hak Akses

| Role | Deskripsi |
|---|---|
| `admin` | Mengelola seluruh sistem, input data, dan melakukan perhitungan PROMETHEE |
| `kaprodi` | Memberikan rekomendasi mahasiswa dan men-generate surat rekomendasi |

---

## 3. Struktur Database

### Tabel `tb_user`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id_user | INT, PK, AI | Primary key |
| nama_lengkap | VARCHAR | Nama lengkap user |
| email | VARCHAR, UNIQUE | Email login |
| password | VARCHAR | Hash bcrypt |
| nomor_telepon | VARCHAR | Nomor HP |
| role | ENUM('admin','kaprodi') | Role user |

### Tabel `tb_mahasiswa`
| Kolom | Tipe | Keterangan |
|---|---|---|
| nim | VARCHAR, PK | Nomor Induk Mahasiswa |
| nama_mhs | VARCHAR | Nama mahasiswa |
| prodi | VARCHAR | Program studi |
| jurusan | VARCHAR | Jurusan |
| kip | VARCHAR | Jalur seleksi (mengandung 'KIPK' = Ada) |
| dtk | VARCHAR | Status DTKS (Ya/Tidak) |
| desil | INT | Desil (1-4+) |
| kerja_ayah | VARCHAR | Pekerjaan ayah |
| penghasilan_ayah | VARCHAR | Range penghasilan ayah |
| keterangan_ayah | VARCHAR | Keterangan kondisi ayah |
| kerja_ibu | VARCHAR | Pekerjaan ibu |
| penghasilan_ibu | VARCHAR | Range penghasilan ibu |
| keterangan_ibu | VARCHAR | Keterangan kondisi ibu |
| prestasi | VARCHAR | Prestasi olahraga/akademik |

### Tabel `tb_kriteria`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id_kriteria | INT, PK, AI | Primary key |
| nama_kriteria | VARCHAR | Nama kriteria |
| jenis_kriteria | ENUM('benefit','cost') | Jenis kriteria |
| nilai_bobot | DECIMAL(5,2) | Bobot kriteria (0–1) |

### Tabel `tb_kategorisasi_kriteria`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id_kategorisasi_kriteria | INT, PK, AI | Primary key |
| id_kriteria | INT, FK | Relasi ke tb_kriteria |
| nama_kategorisasi | VARCHAR | Deskripsi kategorisasi kriteria |
| nilai | INT | Nilai skala numerik |

### Tabel `tb_bobot`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id_bobot | INT, PK, AI | Primary key |
| id_kriteria | INT, FK | Relasi ke tb_kriteria |
| nilai_bobot | DECIMAL(5,4) | Nilai bobot desimal (total = 1.0) |

### Tabel `tb_alternatif`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id_alternatif | INT, PK, AI | Primary key |
| nim | VARCHAR, FK | Relasi ke tb_mahasiswa |
| id_kategorisasi_kriteria | INT, FK | Relasi ke tb_kategorisasi_kriteria |
| tahun | YEAR | Tahun seleksi |

### Tabel `tb_hasil_perhitungan`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id_hasil | INT, PK, AI | Primary key |
| id_alternatif | INT, FK | Relasi ke tb_alternatif |
| leaving_flow | DECIMAL(10,6) | Nilai Leaving Flow |
| entering_flow | DECIMAL(10,6) | Nilai Entering Flow |
| net_flow | DECIMAL(10,6) | Net Flow (leaving - entering) |
| ranking | INT | Urutan peringkat |
| tahun | YEAR | Tahun perhitungan |

---

## 4. Struktur Proyek Laravel

```
resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php          # Layout utama (dengan @stack)
│   ├── partials/
│   │   ├── sidebar.blade.php      # Sidebar navigasi
│   │   ├── header.blade.php       # Header / navbar
│   │   └── breadcrumb.blade.php   # Breadcrumb dinamis
│   ├── admin/
│   │   ├── dashboard.blade.php
│   │   ├── mahasiswa/
│   │   │   └── index.blade.php
│   │   ├── kriteria/
│   │   │   └── index.blade.php
│   │   ├── kategorisasi-kriteria/
│   │   │   ├── index.blade.php
│   │   │   └── edit.blade.php
│   │   ├── bobot/
│   │   │   └── index.blade.php
│   │   ├── alternatif/
│   │   │   └── index.blade.php
│   │   ├── promethee/
│   │   │   └── index.blade.php
│   │   └── hasil/
│   │       └── index.blade.php
│   └── kaprodi/
│       └── dashboard.blade.php
```

---

## 5. Layout Utama (`layouts/app.blade.php`)

Layout utama harus mendukung `@stack` untuk JavaScript dan CSS per-halaman:

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SPK KIP-K | @yield('title')</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Select2 CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <!-- Custom CSS per halaman -->
    @stack('styles')
</head>
<body>
    @include('partials.sidebar')
    @include('partials.header')

    <main>
        @include('partials.breadcrumb')
        @yield('content')
    </main>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select2 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Custom JS per halaman -->
    @stack('scripts')
</body>
</html>
```

### Cara penggunaan `@push` di setiap halaman:

```blade
@extends('layouts.app')

@section('title', 'Nama Halaman')

@push('styles')
<style>
    /* CSS khusus halaman ini */
</style>
@endpush

@section('content')
    {{-- Konten halaman --}}
@endsection

@push('scripts')
<script>
    // JavaScript khusus halaman ini
</script>
@endpush
```

---

## 6. Fitur per Halaman — Role Admin

### 6.1 Dashboard Admin

**Route:** `GET /admin/dashboard`

**Komponen UI:**
- 3 Stats Card:
  1. **Total Pendaftar Beasiswa** — total semua mahasiswa di `tb_alternatif`
  2. **Total Penerima Beasiswa** — jumlah mahasiswa yang mendapat beasiswa (berdasarkan ranking)
  3. **Jumlah Kriteria** — total baris di `tb_kriteria`
- 1 Grafik: **Grafik Hasil Perankingan** — Bar chart (gunakan Chart.js atau library serupa via CDN), menampilkan nama mahasiswa vs net flow

---

### 6.2 Data Mahasiswa

**Route:** `GET /admin/mahasiswa`

**Komponen UI:**
- **Search bar** — filter berdasarkan NIM atau Nama Mahasiswa (AJAX atau query param)
- **Tombol Import** — membuka modal upload file Excel/CSV
  - Gunakan library `maatwebsite/excel` di Laravel
  - Template download tersedia
- **Tombol Tambah Data** — membuka modal popup tambah mahasiswa dengan field:
  - NIM, Nama Mahasiswa, Program Studi, Jurusan
  - KIP (jalur seleksi), DTKS, Desil
  - Penghasilan Ayah, Keterangan Ayah
  - Penghasilan Ibu, Keterangan Ibu
  - Prestasi
- **Tabel Data Mahasiswa:**

| No | NIM | Nama Mahasiswa | Program Studi | Jurusan | Aksi |
|---|---|---|---|---|---|
| 1 | ... | ... | ... | ... | ⋮ |

- **Kolom Aksi** — tombol icon 3 titik (dots menu), jika diklik muncul dropdown dengan:
  - Edit (buka modal popup edit mahasiswa)
  - Hapus (konfirmasi SweetAlert sebelum delete)

---

### 6.3 Data Kriteria

**Route:** `GET /admin/kriteria`

**Komponen UI:**
- **Tombol Tambah Data** — modal popup dengan field:
  - Kode Kriteria (auto-generate atau manual)
  - Nama Kriteria
  - Jenis Kriteria (benefit / cost) — select option
  - Nilai Bobot (desimal)
- **Tabel Data Kriteria:**

| No | Kode Kriteria | Nama Kriteria | Jenis | Bobot | Aksi |
|---|---|---|---|---|---|
| 1 | K1 | Status KIP | benefit | 0.25 | ⋮ |

- **Kolom Aksi** — dots menu: Edit, Hapus (dengan konfirmasi SweetAlert)

---

### 6.4 Data Kategorisasi Kriteria

**Route:** `GET /admin/kategorisasi-kriteria`

**Tampilan halaman index:**
- Daftar **card per kriteria** — setiap card berisi:
  - Icon sesuai kriteria + Kode Kriteria - Nama Kriteria
  - Tombol **Edit** di sisi kanan (justify-between), arahkan ke halaman edit kategorisasi kriteria

**Route halaman edit kategorisasi kriteria:** `GET /admin/kategorisasi-kriteria/{id}/edit`

**Komponen UI halaman edit:**
- Header: Kode Kriteria - Nama Kriteria
- **Tabel/Form dinamis** dengan kolom:
  - Nilai Skala (input number)
  - Deskripsi Kategorisasi (input text)
  - Tombol **Hapus** (icon minus/trash) — hapus baris tersebut
- **Tombol Tambah** — menambah baris baru di bawah
- **Tombol Simpan Semua Perubahan** — submit semua data sekaligus (bulk save via AJAX atau form biasa)

---

### 6.5 Pengaturan Bobot

**Route:** `GET /admin/bobot`

**Layout dua kolom (side-by-side):**

**Kolom Kiri — Card Input Bobot:**
- Form input bobot untuk setiap kriteria (label: Kode - Nama Kriteria, input: number step 0.01)
- Peringatan di bawah form:
  > ⚠️ Total bobot harus bernilai 1 (100%). Gunakan desimal untuk input bobot.
- Tombol **Simpan Bobot**

**Kolom Kanan — Card Ringkasan Bobot:**
- List: `Kode - Nama Kriteria` ... `Nilai Bobot`
- Garis pembatas (`<hr>`)
- Total bobot dengan **warna dinamis:**
  - 🔴 Merah → total > 1.00 (SweetAlert: "Total bobot melebihi 1.00, harap periksa kembali")
  - 🟡 Kuning → total < 1.00 (SweetAlert: "Total bobot belum mencapai 1.00, lengkapi bobot")
  - 🟢 Hijau → total = 1.00 (SweetAlert: "Bobot berhasil disimpan!")
- Tombol **Simpan Bobot**
- Tombol **Lanjutkan ke Perhitungan** → redirect ke `/admin/promethee`

**Validasi real-time:**
```javascript
// Hitung total bobot secara real-time saat nilai diubah
document.querySelectorAll('.input-bobot').forEach(input => {
    input.addEventListener('input', hitungTotalBobot);
});

function hitungTotalBobot() {
    let total = 0;
    document.querySelectorAll('.input-bobot').forEach(i => {
        total += parseFloat(i.value) || 0;
    });
    total = Math.round(total * 10000) / 10000;
    const elTotal = document.getElementById('total-bobot');
    elTotal.textContent = total.toFixed(2);
    elTotal.classList.remove('text-danger','text-warning','text-success');
    if (total > 1.00) elTotal.classList.add('text-danger');
    else if (total < 1.00) elTotal.classList.add('text-warning');
    else elTotal.classList.add('text-success');
}
```

---

### 6.6 Kelola Alternatif

**Route:** `GET /admin/alternatif`

**Komponen UI:**
- **Search bar** — filter berdasarkan nama mahasiswa
- **Tombol Tambah Data** — modal popup dengan:
  - Select2 pilih mahasiswa (berdasarkan NIM/Nama)
  - Setelah mahasiswa dipilih → semua kolom kriteria **terisi otomatis** via AJAX menggunakan fungsi `getMahasiswaDetail($nim)`
  - Input tahun seleksi
- **Tabel Kelola Alternatif:**

| No | Nama Mahasiswa | K1 (Status KIP) | K2 (DTKS) | K3 (Desil) | K4 (Penghasilan) | K5 (Status Ortu) | K6 (Prestasi) | Aksi |
|---|---|---|---|---|---|---|---|---|

> Kolom kriteria bersifat dinamis sesuai data `tb_kriteria`

**AJAX Autoisi Kriteria:**
```javascript
$('#select-mahasiswa').on('change', function () {
    const nim = $(this).val();
    $.get(`/admin/alternatif/mahasiswa/${nim}`, function (data) {
        $('#input-kip').val(data.kip);
        $('#input-dtks').val(data.dtks);
        $('#input-desil').val(data.desil);
        $('#input-penghasilan').val(data.penghasilan);
        $('#input-status-ortu').val(data.status_ortu);
        $('#input-prestasi').val(data.prestasi);
    });
});
```

---

### 6.7 Hitung PROMETHEE

**Route:** `GET /admin/promethee`

**Komponen UI:**

**3 Stats Card di atas:**
1. **Status Bobot Kriteria** — ✅ Tersedia / ❌ Tidak Tersedia
2. **Total Alternatif** — jumlah mahasiswa dalam seleksi
3. **Total Kriteria** — jumlah kriteria aktif

**Card Bobot Kriteria:**
- Header: "Bobot Kriteria"
- Tabel list: Kode Kriteria | Nama Kriteria | Bobot
- **Dropdown filter tahun** — pilih tahun data yang akan dihitung

**Card Tahapan Perhitungan PROMETHEE:**
Tampilkan sebagai list dengan step indicator / timeline UI:
1. Menghitung selisih antar alternatif
2. Menghitung indeks preferensi multikriteria
3. Menghitung Leaving Flow
4. Menghitung Entering Flow
5. Menghitung Net Flow
6. Mengurutkan hasil perankingan

**Tombol Hitung Sekarang:**
- Tampilkan SweetAlert loading saat proses berjalan
- Setelah selesai → redirect ke `/admin/hasil`
- Jika gagal → SweetAlert error dengan pesan penyebab

**Algoritma PROMETHEE yang diimplementasikan di Controller:**
```php
// 1. Hitung selisih (d) antar pasangan alternatif per kriteria
// 2. Hitung preferensi (P) dengan fungsi preferensi Usual
//    P(a,b) = 0 jika d <= 0; P(a,b) = 1 jika d > 0
// 3. Hitung indeks preferensi multikriteria:
//    π(a,b) = Σ [w_j * P_j(a,b)]
// 4. Leaving Flow: φ+(a) = 1/(n-1) * Σ π(a,x)
// 5. Entering Flow: φ-(a) = 1/(n-1) * Σ π(x,a)
// 6. Net Flow: φ(a) = φ+(a) - φ-(a)
// 7. Ranking berdasarkan Net Flow tertinggi
```

---

### 6.8 Hasil Perangkingan

**Route:** `GET /admin/hasil`

**Komponen UI:**
- **2 Stats Card:**
  1. **Peringkat Tertinggi** — nama mahasiswa dengan net flow tertinggi
  2. **Total Penerima Beasiswa** — jumlah penerima
- **Dropdown Filter Tahun** — tampilkan hasil sesuai tahun
- **Tombol Download PDF** — generate PDF hasil perankingan
- **Tabel Hasil PROMETHEE:**

| Peringkat | NIM | Nama Mahasiswa | Leaving Flow | Entering Flow | Net Flow | Status |
|---|---|---|---|---|---|---|
| 1 | ... | ... | 0.xxxx | 0.xxxx | 0.xxxx | Penerima |

---

## 7. Fitur — Role Kaprodi

### 7.1 Dashboard Kaprodi

**Route:** `GET /kaprodi/dashboard`

**Komponen UI:**
- **Search bar** — filter berdasarkan nama atau NIM mahasiswa
- **Tabel Data Mahasiswa:**

| No | NIM | Nama Mahasiswa | Program Studi | Jurusan | Aksi |
|---|---|---|---|---|---|
| 1 | ... | ... | ... | ... | Pilih |

- **Tombol Pilih** — membuka modal popup surat rekomendasi:
  - Tampilkan preview HTML surat rekomendasi (print-ready)
  - Isi surat: kop surat Politeknik Negeri Jember, data mahasiswa, tanda tangan kaprodi
  - Tombol **Batal** — tutup modal
  - Tombol **Download** — generate dan unduh PDF surat rekomendasi

---

## 8. Fungsi Otomatis `getMahasiswaDetail`

Fungsi ini dipanggil via AJAX saat memilih mahasiswa di form Kelola Alternatif:

```php
public function getMahasiswaDetail($nim)
{
    $mhs = Mahasiswa::where('nim', $nim)->first();

    if (!$mhs) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }

    // 1. Kategorisasi KIP
    $skorKip = !empty($mhs->kip) && str_contains($mhs->kip, 'KIPK') ? 'Ada' : 'Tidak Ada';

    // 2. DTKS
    $skorDtks = (strtolower($mhs->dtk) == 'ya') ? 'Ya' : 'Tidak';

    // 3. Desil
    $skorDesil = $this->hitungSkorDesil($mhs->desil);

    // 4. Penghasilan Ortu (gabungkan ayah & ibu)
    $totalPenghasilan = $this->parsePenghasilan($mhs->penghasilan_ayah)
                      + $this->parsePenghasilan($mhs->penghasilan_ibu);
    $skorPenghasilan = $this->hitungSkorPenghasilan($totalPenghasilan);

    // 5. Status Orang Tua
    $skorStatusOrtu = $this->hitungSkorStatusOrtu($mhs->keterangan_ayah, $mhs->keterangan_ibu);

    return response()->json([
        'nama'        => $mhs->nama_mhs,
        'kip'         => $skorKip,
        'dtks'        => $skorDtks,
        'desil'       => $skorDesil,
        'penghasilan' => $skorPenghasilan,
        'status_ortu' => $skorStatusOrtu,
        'prestasi'    => $mhs->prestasi ?? 'Tidak Ada',
    ]);
}

private function hitungSkorDesil($desil): int
{
    if ($desil == 1) return 4;
    if ($desil == 2) return 3;
    if ($desil == 3) return 2;
    return 1;
}

private function parsePenghasilan($string): int
{
    $clean = preg_replace('/[^0-9]/', '', substr($string, strpos($string, '-') ?: 0));
    return (int) $clean ?: 0;
}

private function hitungSkorPenghasilan($total): int
{
    if ($total <= 1000000) return 5;
    if ($total <= 2000000) return 4;
    if ($total <= 3000000) return 3;
    if ($total <= 4000000) return 2;
    return 1;
}

private function hitungSkorStatusOrtu($ketAyah, $ketIbu): int
{
    $ayahMeninggal = str_contains(strtolower($ketAyah), 'meninggal')
                  || str_contains(strtolower($ketAyah), 'wafat');
    $ibuMeninggal  = str_contains(strtolower($ketIbu), 'meninggal')
                  || str_contains(strtolower($ketIbu), 'wafat');

    if ($ayahMeninggal && $ibuMeninggal) return 4; // Yatim Piatu
    if ($ayahMeninggal || $ibuMeninggal) return 3; // Yatim / Piatu
    if (str_contains(strtolower($ketAyah), 'tidak bekerja')) return 2;
    return 1;
}
```

---

## 9. CDN Library yang Digunakan

```html
<!-- Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Font Awesome (untuk icon) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
```

---

## 10. Konfigurasi `.env`

```env
APP_NAME=SPK KIP-K Polinema
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spk_kip_web
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
```

---

## 11. Route Utama

```php
// routes/web.php

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('mahasiswa', MahasiswaController::class);
    Route::post('mahasiswa/import', [MahasiswaController::class, 'import'])->name('mahasiswa.import');

    Route::resource('kriteria', KriteriaController::class);
    Route::resource('kategorisasi-kriteria', KategorisasiKriteriaController::class);

    Route::get('bobot', [BobotController::class, 'index'])->name('bobot.index');
    Route::post('bobot', [BobotController::class, 'store'])->name('bobot.store');

    Route::resource('alternatif', AlternatifController::class);
    Route::get('alternatif/mahasiswa/{nim}', [AlternatifController::class, 'getMahasiswaDetail']);

    Route::get('promethee', [PrometheeController::class, 'index'])->name('promethee.index');
    Route::post('promethee/hitung', [PrometheeController::class, 'hitung'])->name('promethee.hitung');

    Route::get('hasil', [HasilController::class, 'index'])->name('hasil.index');
    Route::get('hasil/pdf/{tahun}', [HasilController::class, 'downloadPdf'])->name('hasil.pdf');
});

// Kaprodi
Route::prefix('kaprodi')->middleware(['auth', 'role:kaprodi'])->group(function () {
    Route::get('/dashboard', [KaprodiController::class, 'index'])->name('kaprodi.dashboard');
    Route::get('/surat/{nim}', [KaprodiController::class, 'suratRekomendasi'])->name('kaprodi.surat');
    Route::get('/surat/{nim}/download', [KaprodiController::class, 'downloadSurat'])->name('kaprodi.surat.download');
});
```

---

## 12. Middleware Role

```php
// app/Http/Middleware/CheckRole.php

public function handle(Request $request, Closure $next, string $role): Response
{
    if (!auth()->check() || auth()->user()->role !== $role) {
        abort(403, 'Akses ditolak.');
    }
    return $next($request);
}
```

Daftarkan di `bootstrap/app.php` atau `Kernel.php`:
```php
'role' => \App\Http\Middleware\CheckRole::class,
```

---

## 13. Panduan Desain UI

### Warna Tema
| Elemen | Warna |
|---|---|
| Primary (sidebar, header) | `#1a3c5e` (biru gelap) |
| Accent | `#f0a500` (kuning emas) |
| Background | `#f5f7fa` |
| Card | `#ffffff` |
| Text utama | `#2d3748` |
| Success | `#38a169` |
| Warning | `#d69e2e` |
| Danger | `#e53e3e` |

### Sidebar
- Latar belakang dark biru Politeknik Negeri Jember
- Logo/nama instansi di bagian atas
- Menu navigasi dengan icon Font Awesome
- Active state dengan highlight accent kuning-emas
- Tampilkan nama & role user di bagian bawah sidebar

### Cards Stats
- Shadow ringan (`box-shadow: 0 2px 8px rgba(0,0,0,0.08)`)
- Icon besar berwarna di sudut kanan
- Angka statistik dengan font besar (24-32px bold)
- Label deskriptif di bawahnya

### Tabel Data
- Header tabel warna primary
- Baris zebra striping
- Hover efek highlight
- Responsif dengan horizontal scroll pada layar kecil
- Pagination bawaan Laravel

### Modal Popup
- Bootstrap Modal ukuran `modal-lg` untuk form kompleks
- Validasi client-side sebelum submit
- Tombol Batal (outline) dan Simpan (primary)

### SweetAlert2 Pattern
```javascript
// Konfirmasi hapus
Swal.fire({
    title: 'Yakin ingin menghapus?',
    text: 'Data yang dihapus tidak dapat dikembalikan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#e53e3e',
    cancelButtonColor: '#718096',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
}).then((result) => {
    if (result.isConfirmed) {
        // lanjutkan proses hapus
    }
});

// Loading proses PROMETHEE
Swal.fire({
    title: 'Memproses Perhitungan...',
    html: 'Mohon tunggu, sistem sedang menghitung PROMETHEE',
    allowOutsideClick: false,
    didOpen: () => { Swal.showLoading(); }
});
```

---

## 14. Panduan Import Excel/CSV (Data Mahasiswa)

Gunakan package `maatwebsite/excel`:

```bash
composer require maatwebsite/excel
```

**Format kolom Excel/CSV yang diharapkan:**

| nim | nama_mhs | prodi | jurusan | kip | dtk | desil | kerja_ayah | penghasilan_ayah | keterangan_ayah | kerja_ibu | penghasilan_ibu | keterangan_ibu | prestasi |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|

**Import Class:**
```php
// app/Imports/MahasiswaImport.php
class MahasiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Mahasiswa
    {
        return new Mahasiswa([
            'nim'              => $row['nim'],
            'nama_mhs'         => $row['nama_mhs'],
            'prodi'            => $row['prodi'],
            'jurusan'          => $row['jurusan'],
            'kip'              => $row['kip'] ?? null,
            'dtk'              => $row['dtk'] ?? 'Tidak',
            'desil'            => $row['desil'] ?? 0,
            'kerja_ayah'       => $row['kerja_ayah'] ?? null,
            'penghasilan_ayah' => $row['penghasilan_ayah'] ?? null,
            'keterangan_ayah'  => $row['keterangan_ayah'] ?? null,
            'kerja_ibu'        => $row['kerja_ibu'] ?? null,
            'penghasilan_ibu'  => $row['penghasilan_ibu'] ?? null,
            'keterangan_ibu'   => $row['keterangan_ibu'] ?? null,
            'prestasi'         => $row['prestasi'] ?? 'Tidak Ada',
        ]);
    }
}
```

---

## 15. Generate PDF

Gunakan package `barryvdh/laravel-dompdf`:

```bash
composer require barryvdh/laravel-dompdf
```

Contoh di controller:
```php
use Barryvdh\DomPDF\Facade\Pdf;

public function downloadPdf($tahun)
{
    $hasil = HasilPerhitungan::with('alternatif.mahasiswa')
             ->where('tahun', $tahun)
             ->orderBy('ranking')
             ->get();

    $pdf = Pdf::loadView('admin.hasil.pdf', compact('hasil', 'tahun'));
    return $pdf->download("hasil-promethee-{$tahun}.pdf");
}
```

---

## 16. Checklist Implementasi

- [ ] Setup proyek Laravel baru
- [ ] Konfigurasi `.env` dan koneksi database
- [ ] Buat semua migrasi tabel
- [ ] Buat Seeder data awal (user admin, kaprodi, kriteria default)
- [ ] Buat layout Blade utama dengan sidebar, header, breadcrumb
- [ ] Implementasi Auth (login, logout, middleware role)
- [ ] Halaman Admin: Dashboard
- [ ] Halaman Admin: Data Mahasiswa + Import Excel
- [ ] Halaman Admin: Data Kriteria
- [ ] Halaman Admin: Data Kategorisasi Kriteria
- [ ] Halaman Admin: Pengaturan Bobot
- [ ] Halaman Admin: Kelola Alternatif + AJAX autoisi
- [ ] Halaman Admin: Hitung PROMETHEE (algoritma lengkap)
- [ ] Halaman Admin: Hasil Perankingan + Download PDF
- [ ] Halaman Kaprodi: Dashboard + Surat Rekomendasi
- [ ] Testing seluruh alur perhitungan PROMETHEE
- [ ] Validasi form semua halaman
- [ ] Responsif mobile

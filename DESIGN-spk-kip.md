# DESIGN.md — UI Design System
## SPK KIP-K | Politeknik Negeri Jember | PROMETHEE

---

## 1. Design Token & CSS Variables

Tempelkan variabel berikut di root CSS (`app.css` atau dalam tag `<style>` pada `layouts/app.blade.php`):

```css
:root {
  /* ==========================================================================
     1. BRAND & PRIMARY COLORS (Tema Periwinkle Blue Utama)
     ========================================================================== */
  --color-primary: #5A81FA;
  --color-primary-hover: #476CD4;
  --color-primary-active: #3654AD;
  --color-primary-light: #8FA9FF;
  --color-primary-tint: #D6E0FF;
  --color-primary-glow: #F3F6FF;

  /* ==========================================================================
     2. MULTI-ACCENT PALETTE
     ========================================================================== */
  --color-pink: #FF63A5;
  --color-pink-light: #FFD3E6;
  --color-pink-glow: #FFF0F6;

  --color-purple: #924FEF;
  --color-purple-light: #E2D1FC;
  --color-purple-glow: #F7F3FE;

  --color-purple-dark: #4B3E9D;
  --color-purple-dark-light: #DCD9F0;
  --color-purple-dark-glow: #F4F2FA;

  --color-cyan: #409CFF;
  --color-cyan-light: #D4E8FF;
  --color-cyan-glow: #F0F6FF;

  --color-coral: #FF6680;

  /* ==========================================================================
     3. NEUTRAL SCALE
     ========================================================================== */
  --neutral-50: #EEF2F6;
  --neutral-100: #FFFFFF;
  --neutral-200: #E6ECF4;
  --neutral-300: #CBD5E1;
  --neutral-400: #A0AEC0;
  --neutral-500: #718096;
  --neutral-600: #4A5568;
  --neutral-700: #2D3748;
  --neutral-800: #1A202C;
  --neutral-900: #111827;
  --neutral-white: #FFFFFF;

  /* ==========================================================================
     4. STATUS MAPPING
     ========================================================================== */
  --color-success: var(--color-cyan);
  --bg-success: var(--color-cyan-glow);
  --text-success: #1E40AF;

  --color-danger: var(--color-pink);
  --bg-danger: var(--color-pink-glow);
  --text-danger: #9D174D;

  --color-warning: var(--color-purple);
  --bg-warning: var(--color-purple-glow);
  --text-warning: #6B21A8;

  --color-info: var(--color-primary);
  --bg-info: var(--color-primary-glow);
  --text-info: #2563EB;

  /* ==========================================================================
     5. SHADOWS & OPACITY
     ========================================================================== */
  --opac-primary-10: rgba(90, 129, 250, 0.1);
  --opac-primary-20: rgba(90, 129, 250, 0.2);
  --opac-dark-50: rgba(17, 24, 39, 0.4);
  --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.02);
  --shadow-md: 0 8px 24px rgba(149, 157, 165, 0.05);
  --shadow-card: 0 2px 12px rgba(90, 129, 250, 0.08);

  /* ==========================================================================
     6. LAYOUT
     ========================================================================== */
  --sidebar-width: 260px;
  --header-height: 64px;
  --border-radius-sm: 8px;
  --border-radius-md: 12px;
  --border-radius-lg: 16px;
  --border-radius-xl: 24px;
}
```

---

## 2. Typography

```css
/* Import Google Fonts di <head> layout */
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

body {
  font-family: 'Plus Jakarta Sans', sans-serif;
  background-color: var(--neutral-50);
  color: var(--neutral-700);
}
```

| Elemen | Font | Size | Weight | Color |
|---|---|---|---|---|
| Logo / Brand | Plus Jakarta Sans | 18px | 800 | `--neutral-white` |
| Sub brand | Plus Jakarta Sans | 10px | 600 | `--color-primary-tint` (letter-spacing: 1.5px, uppercase) |
| Judul halaman (h1) | Plus Jakarta Sans | 22px | 700 | `--neutral-900` |
| Sub judul / section | Plus Jakarta Sans | 16px | 600 | `--neutral-800` |
| Menu sidebar aktif | Plus Jakarta Sans | 14px | 600 | `--neutral-white` |
| Menu sidebar non-aktif | Plus Jakarta Sans | 14px | 500 | `--neutral-white` (opacity 0.75) |
| Teks body / label | Plus Jakarta Sans | 14px | 400 | `--neutral-700` |
| Teks muted / placeholder | Plus Jakarta Sans | 13px | 400 | `--neutral-400` |
| Angka stat card | Plus Jakarta Sans | 28px | 700 | `--neutral-900` |
| Badge / chip | Plus Jakarta Sans | 12px | 600 | sesuai konteks |

---

## 3. Halaman Login

> **Referensi:** Gambar `Halaman_Login.png`

### Layout
- **Full-screen split layout** — tidak ada scroll
- **Kiri (40% lebar):** Latar belakang warna `--color-primary` (`#5A81FA`), tidak ada elemen dekorasi berlebihan, hanya teks branding di tengah-kiri secara vertikal
- **Kanan (60% lebar):** Juga background `--color-primary`, menempatkan card login di tengah secara absolut

### Elemen Kiri (Hero Text)
```
Teks 1: "Sistem Pendukung Keputusan"
Teks 2: "Penerima Beasiswa KIP-K"
Teks 3: "Politeknik Negeri Jember"
Teks 4: "PROMETHEE"
```
- Warna teks: `--neutral-white`
- Font: Plus Jakarta Sans, 28–32px, weight 700
- Tidak ada ilustrasi/gambar dekorasi
- Teks diposisikan vertikal-center, horizontal kiri dengan padding kiri `~60px`

### Card Login (Kanan)
- Background: `--neutral-white`
- Border radius: `24px` (besar, rounded)
- Padding: `40px`
- Lebar card: `~460px`
- Shadow: ringan — `0 20px 60px rgba(0,0,0,0.12)`
- Posisi: center vertikal & horizontal dalam kolom kanan

**Isi Card:**
1. **Logo + Brand** di bagian atas card (center):
   - Icon logo Politeknik Negeri Jember (bulat dengan daun hijau)
   - Teks **"SPK KIP-K"** — biru `--color-primary`, font 20px bold
   - Teks **"POLITEKNIK NEGERI JEMBER"** — merah atau warna khas institusi, font 10px, uppercase, tracking lebar

2. **Form login** (di tengah card):
   - Input **Email** — label di atas, placeholder "Masukkan email"
   - Input **Password** — label di atas, placeholder "Masukkan password", ada icon toggle show/hide

3. **Tombol Login** (di bawah card, full-width):
   - Background: `--color-primary-active` (`#3654AD`) — biru tua seperti gambar
   - Teks: "Login", putih, font 16px, weight 600
   - Border radius: `12px`
   - Padding: `14px`
   - Hover: sedikit lebih gelap (`--color-primary-hover`)

### Input Style (Global)
```css
.form-control {
  border: 1.5px solid var(--neutral-300);
  border-radius: var(--border-radius-sm);
  padding: 10px 14px;
  font-size: 14px;
  color: var(--neutral-700);
  background: var(--neutral-white);
  transition: border-color 0.2s;
}
.form-control:focus {
  border-color: var(--color-primary);
  box-shadow: 0 0 0 3px var(--opac-primary-10);
  outline: none;
}
```

---

## 4. Sidebar

> **Referensi:** Gambar `sidebar-spk.png`

### Spesifikasi Sidebar
- **Lebar:** `260px` (fixed, tidak collapsible pada desktop)
- **Tinggi:** 100vh (full height)
- **Background:** `--color-primary` (`#5A81FA`) — biru periwinkle solid
- **Posisi:** Fixed left, z-index tinggi

### Area Logo / Brand (Atas Sidebar)
```
[Icon Logo Politeknik] SPK KIP-K
                       POLITEKNIK NEGERI JEMBER
```
- Logo: gambar bulat hitam-hijau (logo Polinema), ukuran `~44px`
- "SPK KIP-K" — warna putih, font 18px, weight 800
- "POLITEKNIK NEGERI JEMBER" — warna `--color-primary-tint` atau putih opacity 0.7, font 9px, uppercase, letter-spacing: 1.2px
- Padding area atas: `24px 20px`
- Separator: garis tipis `rgba(255,255,255,0.15)` di bawah area brand

### Menu Navigation
Padding per item: `12px 20px`
Margin antar item: `2px`
Border radius item: `10px` (dalam sidebar, sedikit indent kiri-kanan)

**Daftar menu (sesuai gambar) — Role Admin:**
| Icon | Label |
|---|---|
| `bi-graph-up-arrow` / chart icon | Dashboard |
| `bi-people-fill` | Data Mahasiswa |
| `bi-person-badge` | Data Pengguna |
| `bi-file-text` | Data Kriteria |
| `bi-folder-fill` | Data Kategorisasi Kriteria |
| `bi-gear-fill` | Pengaturan Bobot |
| `bi-table` / grid icon | Kelola Alternatif |
| `bi-calculator` | Hitung Promethee |
| `bi-list-ol` | Hasil Seleksi |

**Daftar menu — Role Kaprodi:**
| Icon | Label |
|---|---|
| `bi-house-fill` | Dashboard |

**State Menu:**

*Non-aktif:*
```css
.sidebar-menu-item {
  color: rgba(255, 255, 255, 0.75);
  background: transparent;
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 11px 16px;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.2s ease;
}
```

*Aktif (seperti "Dashboard" di gambar — background putih transparan rounded):*
```css
.sidebar-menu-item.active {
  background: rgba(255, 255, 255, 0.20);
  color: var(--neutral-white);
  font-weight: 600;
}
```

*Hover:*
```css
.sidebar-menu-item:hover {
  background: rgba(255, 255, 255, 0.12);
  color: var(--neutral-white);
}
```

### Area Bawah Sidebar
- Separator `rgba(255,255,255,0.15)` di atas
- **"Keluar dari akun"** — warna putih opacity 0.75, icon `bi-box-arrow-right`
- Padding bawah: `24px 20px`

---

## 5. Header / Topbar

### Spesifikasi
- **Tinggi:** `64px`
- **Background:** `--neutral-white`
- **Border bawah:** `1px solid var(--neutral-200)`
- **Shadow:** `var(--shadow-sm)`
- **Posisi:** Fixed top, kiri offset `260px` (lebar sidebar), width `calc(100% - 260px)`

### Isi Header (flex, justify-between)
**Kiri:**
- Breadcrumb halaman aktif (teks `--neutral-500` → `--neutral-900`)
- Judul halaman saat ini (font 18px, weight 700, `--neutral-900`)

**Kanan:**
- **Badge notifikasi** (icon lonceng, `--neutral-600`)
- **Avatar user** — lingkaran kecil `36px`, initial nama atau foto, background `--color-primary-tint`, warna teks `--color-primary`
- Nama user dan role — teks kecil di samping avatar
- Dropdown saat diklik: Profil & Logout

---

## 6. Breadcrumb

```html
<!-- Contoh struktur breadcrumb -->
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="#">Home</a>
    </li>
    <li class="breadcrumb-item active">Data Mahasiswa</li>
  </ol>
</nav>
```

```css
.breadcrumb {
  background: transparent;
  padding: 0;
  margin: 0 0 16px 0;
  font-size: 13px;
}
.breadcrumb-item a {
  color: var(--color-primary);
  text-decoration: none;
}
.breadcrumb-item.active {
  color: var(--neutral-500);
}
.breadcrumb-item + .breadcrumb-item::before {
  color: var(--neutral-400);
  content: "/";
}
```

---

## 7. Layout Konten Utama

```css
.main-wrapper {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: var(--sidebar-width);   /* 260px */
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  z-index: 1000;
}

.content-area {
  margin-left: var(--sidebar-width);
  width: calc(100% - var(--sidebar-width));
  min-height: 100vh;
  background: var(--neutral-50);
}

.topbar {
  height: var(--header-height);   /* 64px */
  position: sticky;
  top: 0;
  z-index: 999;
  background: var(--neutral-white);
  border-bottom: 1px solid var(--neutral-200);
}

.page-content {
  padding: 28px 32px;
}
```

---

## 8. Card Komponen

### Card Standar (Wrapper konten)
```css
.card-spk {
  background: var(--neutral-white);
  border-radius: var(--border-radius-md);   /* 12px */
  border: 1px solid var(--neutral-200);
  box-shadow: var(--shadow-md);
  padding: 24px;
}

.card-spk .card-header-spk {
  font-size: 15px;
  font-weight: 700;
  color: var(--neutral-800);
  margin-bottom: 20px;
  padding-bottom: 14px;
  border-bottom: 1px solid var(--neutral-200);
  display: flex;
  align-items: center;
  justify-content: space-between;
}
```

### Stats Card (Dashboard)
```css
.stats-card {
  background: var(--neutral-white);
  border-radius: var(--border-radius-md);
  border: 1px solid var(--neutral-200);
  box-shadow: var(--shadow-card);
  padding: 20px 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
}

.stats-card .stats-icon {
  width: 52px;
  height: 52px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  flex-shrink: 0;
}

.stats-card .stats-value {
  font-size: 28px;
  font-weight: 700;
  color: var(--neutral-900);
  line-height: 1;
  margin-bottom: 4px;
}

.stats-card .stats-label {
  font-size: 13px;
  color: var(--neutral-500);
  font-weight: 500;
}
```

**Variant warna icon stats card:**

| Stat | Icon BG | Icon Color |
|---|---|---|
| Total Pendaftar | `--color-primary-glow` | `--color-primary` |
| Total Penerima | `--color-cyan-glow` | `--color-cyan` |
| Jumlah Kriteria | `--color-purple-glow` | `--color-purple` |
| Status Bobot | `--color-pink-glow` | `--color-pink` |

---

## 9. Tabel Data

```css
.table-spk {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  font-size: 14px;
}

.table-spk thead th {
  background: var(--color-primary-glow);
  color: var(--color-primary-active);
  font-weight: 600;
  font-size: 13px;
  padding: 12px 16px;
  border-bottom: 2px solid var(--color-primary-tint);
  white-space: nowrap;
}

.table-spk thead th:first-child {
  border-radius: 8px 0 0 0;
}
.table-spk thead th:last-child {
  border-radius: 0 8px 0 0;
}

.table-spk tbody tr {
  border-bottom: 1px solid var(--neutral-200);
  transition: background 0.15s;
}

.table-spk tbody tr:hover {
  background: var(--color-primary-glow);
}

.table-spk tbody td {
  padding: 13px 16px;
  color: var(--neutral-700);
  vertical-align: middle;
}

/* Zebra striping ringan */
.table-spk tbody tr:nth-child(even) {
  background: var(--neutral-50);
}
.table-spk tbody tr:nth-child(even):hover {
  background: var(--color-primary-glow);
}
```

---

## 10. Tombol (Button)

```css
/* Primary Button */
.btn-spk-primary {
  background: var(--color-primary);
  color: var(--neutral-white);
  border: none;
  border-radius: var(--border-radius-sm);
  padding: 9px 18px;
  font-size: 14px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 7px;
  cursor: pointer;
  transition: background 0.2s, transform 0.1s;
}
.btn-spk-primary:hover {
  background: var(--color-primary-hover);
}
.btn-spk-primary:active {
  background: var(--color-primary-active);
  transform: scale(0.98);
}

/* Outline Button */
.btn-spk-outline {
  background: transparent;
  color: var(--color-primary);
  border: 1.5px solid var(--color-primary);
  border-radius: var(--border-radius-sm);
  padding: 9px 18px;
  font-size: 14px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 7px;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-spk-outline:hover {
  background: var(--color-primary-glow);
}

/* Danger Button */
.btn-spk-danger {
  background: var(--color-pink-glow);
  color: var(--color-pink);
  border: 1.5px solid var(--color-pink-light);
  border-radius: var(--border-radius-sm);
  padding: 7px 14px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-spk-danger:hover {
  background: var(--color-pink-light);
}

/* Tombol icon dots menu aksi */
.btn-dots {
  background: var(--neutral-50);
  border: 1px solid var(--neutral-200);
  border-radius: 8px;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--neutral-600);
  cursor: pointer;
  transition: all 0.2s;
}
.btn-dots:hover {
  background: var(--color-primary-glow);
  border-color: var(--color-primary-tint);
  color: var(--color-primary);
}
```

---

## 11. Modal Popup

```css
.modal-spk .modal-content {
  border: none;
  border-radius: var(--border-radius-lg);
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.modal-spk .modal-header {
  background: var(--color-primary-glow);
  border-bottom: 1px solid var(--color-primary-tint);
  border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
  padding: 18px 24px;
}

.modal-spk .modal-title {
  font-size: 16px;
  font-weight: 700;
  color: var(--color-primary-active);
}

.modal-spk .modal-body {
  padding: 24px;
}

.modal-spk .modal-footer {
  border-top: 1px solid var(--neutral-200);
  padding: 16px 24px;
  gap: 10px;
}
```

---

## 12. Halaman Dashboard — Admin

### Layout Konten
```
[Breadcrumb: Home / Dashboard]
[Judul: Dashboard]

[Row: 3 Stats Card]
  Card 1: Total Pendaftar Beasiswa  (icon: bi-people-fill, warna primary)
  Card 2: Total Penerima Beasiswa   (icon: bi-award-fill, warna cyan)
  Card 3: Jumlah Kriteria           (icon: bi-list-check, warna purple)

[Card Grafik Perankingan — full width]
  Header: "Grafik Hasil Perankingan"
  Konten: Bar chart horizontal atau vertikal
          Sumbu X: Nama Mahasiswa
          Sumbu Y: Nilai Net Flow
          Warna bar: gradient primary → cyan
          Library: Chart.js via CDN
```

**Chart.js config minimal:**
```javascript
const ctx = document.getElementById('chartPelangi').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: namaAlternatif,   // dari Blade/JSON
    datasets: [{
      label: 'Net Flow',
      data: nilaiNetFlow,
      backgroundColor: 'rgba(90, 129, 250, 0.7)',
      borderColor: '#5A81FA',
      borderWidth: 2,
      borderRadius: 6,
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: false } },
    scales: {
      y: {
        grid: { color: '#E6ECF4' },
        ticks: { color: '#718096', font: { size: 12 } }
      },
      x: {
        grid: { display: false },
        ticks: { color: '#718096', font: { size: 12 } }
      }
    }
  }
});
```

---

## 13. Halaman Data Mahasiswa

### Layout Konten
```
[Breadcrumb: Home / Data Mahasiswa]
[Judul: Data Mahasiswa]

[Card: Tabel Data Mahasiswa]
  [Toolbar — flex, justify-between]
    Kiri: Search Input (placeholder "Cari NIM atau Nama...")
    Kanan: [Tombol Import Excel] [Tombol Tambah Data]

  [Tabel .table-spk]
    Kolom: No | NIM | Nama Mahasiswa | Program Studi | Jurusan | Aksi
    Aksi: tombol .btn-dots → dropdown (Edit, Hapus)
```

**Toolbar search style:**
```css
.search-spk {
  position: relative;
  width: 280px;
}
.search-spk input {
  padding-left: 38px;
  border-radius: 8px;
  border: 1.5px solid var(--neutral-300);
  height: 38px;
  font-size: 14px;
  width: 100%;
}
.search-spk .search-icon {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--neutral-400);
}
```

**Dropdown aksi dots:**
```css
.dropdown-action .dropdown-menu {
  border: 1px solid var(--neutral-200);
  border-radius: 10px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.1);
  padding: 6px;
  min-width: 130px;
}
.dropdown-action .dropdown-item {
  border-radius: 7px;
  font-size: 13px;
  font-weight: 500;
  color: var(--neutral-700);
  padding: 8px 12px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.dropdown-action .dropdown-item:hover {
  background: var(--color-primary-glow);
  color: var(--color-primary);
}
.dropdown-action .dropdown-item.text-danger:hover {
  background: var(--color-pink-glow);
  color: var(--color-pink);
}
```

**Modal Tambah/Edit Mahasiswa:**
- Size: `modal-lg`
- Form grid 2 kolom untuk field: NIM, Nama, Prodi, Jurusan, KIP, DTKS, Desil
- Field penghasilan ayah/ibu: 1 kolom full width per baris

---

## 14. Halaman Data Kriteria

### Layout Konten
```
[Breadcrumb: Home / Data Kriteria]
[Judul: Data Kriteria]

[Card: Tabel Data Kriteria]
  [Toolbar]
    Kanan: [Tombol Tambah Kriteria]

  [Tabel .table-spk]
    Kolom: No | Kode Kriteria | Nama Kriteria | Jenis | Bobot | Aksi
```

**Badge Jenis Kriteria:**
```css
.badge-benefit {
  background: var(--bg-success);
  color: var(--text-success);
  border-radius: 20px;
  padding: 3px 10px;
  font-size: 12px;
  font-weight: 600;
}
.badge-cost {
  background: var(--bg-danger);
  color: var(--text-danger);
  border-radius: 20px;
  padding: 3px 10px;
  font-size: 12px;
  font-weight: 600;
}
```

---

## 15. Halaman Data Kategorisasi Kriteria

### Layout — Index (Daftar Card Kriteria)
```
[Breadcrumb: Home / Data Kategorisasi Kriteria]
[Judul: Data Kategorisasi Kriteria]

[Grid 2 atau 3 kolom — card per kriteria]
  Card 1: [Icon Kriteria] K1 - Status KIP         [Tombol Edit →]
  Card 2: [Icon Kriteria] K2 - DTKS               [Tombol Edit →]
  Card 3: [Icon Kriteria] K3 - Desil              [Tombol Edit →]
  ...dst
```

**Card Kriteria style:**
```css
.card-kriteria {
  background: var(--neutral-white);
  border: 1px solid var(--neutral-200);
  border-radius: var(--border-radius-md);
  padding: 18px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: var(--shadow-sm);
  transition: box-shadow 0.2s, border-color 0.2s;
}
.card-kriteria:hover {
  border-color: var(--color-primary-tint);
  box-shadow: var(--shadow-card);
}

.card-kriteria .kriteria-left {
  display: flex;
  align-items: center;
  gap: 14px;
}
.card-kriteria .icon-kriteria {
  width: 42px;
  height: 42px;
  background: var(--color-primary-glow);
  color: var(--color-primary);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
}
.card-kriteria .kriteria-kode {
  font-size: 12px;
  font-weight: 600;
  color: var(--color-primary);
}
.card-kriteria .kriteria-nama {
  font-size: 15px;
  font-weight: 600;
  color: var(--neutral-800);
}
```

### Halaman Edit Kategorisasi Kriteria
```
[Breadcrumb: Home / Data Kategorisasi Kriteria / K1 - Status KIP]
[Judul: Kelola Kategorisasi Kriteria — K1 Status KIP]

[Card: Form Kategorisasi Kriteria]
  [Tabel dinamis dengan header: Nilai Skala | Deskripsi | Hapus]
    Row 1: [input number] | [input text] | [icon hapus merah]
    Row 2: [input number] | [input text] | [icon hapus merah]
    ...
  [Tombol + Tambah Baris] — outline, kiri
  ---
  [Tombol Simpan Semua Perubahan] — primary, kanan
```

---

## 16. Halaman Pengaturan Bobot

### Layout Dua Kolom
```
[Breadcrumb: Home / Pengaturan Bobot]
[Judul: Pengaturan Bobot Kriteria]

[Row]
  [Col-7: Card Input Bobot]           [Col-5: Card Ringkasan Bobot]
    Form label + input per kriteria     List kode - nama - nilai bobot
    ⚠️ Peringatan total = 1.00           <hr>
    [Tombol Simpan Bobot]               Total: [nilai — warna dinamis]
    [Tombol Lanjut ke Perhitungan]      [Tombol Simpan Bobot]
```

**Total bobot warna dinamis:**
```css
.total-bobot { font-size: 18px; font-weight: 700; transition: color 0.3s; }
.total-bobot.kurang   { color: var(--color-warning); }   /* < 1.00 — ungu */
.total-bobot.lebih    { color: var(--color-danger); }    /* > 1.00 — pink/merah */
.total-bobot.tepat    { color: var(--color-success); }   /* = 1.00 — cyan/hijau */
```

**Alert info bobot:**
```css
.alert-bobot {
  background: var(--color-purple-glow);
  border: 1px solid var(--color-purple-light);
  border-radius: 8px;
  padding: 10px 14px;
  font-size: 13px;
  color: var(--color-warning);
  display: flex;
  align-items: center;
  gap: 8px;
}
```

---

## 17. Halaman Kelola Alternatif

```
[Breadcrumb: Home / Kelola Alternatif]
[Judul: Kelola Alternatif]

[Card: Tabel Alternatif]
  [Toolbar]
    Kiri: Search Input (nama mahasiswa)
    Kanan: [Tombol Tambah Alternatif]

  [Tabel .table-spk — horizontal scroll jika banyak kriteria]
    Kolom: No | Nama Mahasiswa | K1 | K2 | K3 | K4 | K5 | K6 | Aksi
    (kolom Kn = nama sub kriteria terpilih)
```

**Modal Tambah Alternatif:**
- Field 1: Select2 pilih mahasiswa (width 100%)
- Setelah pilih → section "Detail Kriteria" muncul (fade in)
- Field kriteria: readonly input yang terisi otomatis
- Ada indikator loading spinner kecil saat fetch AJAX

```css
.select2-container--default .select2-selection--single {
  height: 42px;
  border: 1.5px solid var(--neutral-300);
  border-radius: var(--border-radius-sm);
  display: flex;
  align-items: center;
}
.select2-container--default .select2-selection--single:focus-within,
.select2-container--focus .select2-selection--single {
  border-color: var(--color-primary);
  box-shadow: 0 0 0 3px var(--opac-primary-10);
}
.select2-dropdown {
  border: 1.5px solid var(--color-primary-tint);
  border-radius: var(--border-radius-sm);
  box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}
```

---

## 18. Halaman Hitung PROMETHEE

```
[Breadcrumb: Home / Hitung PROMETHEE]
[Judul: Hitung PROMETHEE]

[Row: 3 Stats Card]
  Card 1: Status Bobot     (✅ Tersedia / ❌ Tidak Tersedia)
  Card 2: Total Alternatif (icon: bi-people)
  Card 3: Total Kriteria   (icon: bi-list-check)

[Row]
  [Col-8: Card Bobot Kriteria]
    Dropdown filter tahun
    Tabel: Kode | Nama Kriteria | Bobot

  [Col-4: Card Tahapan Perhitungan]
    List step dengan icon/nomor:
    1. Menghitung selisih antar alternatif
    2. Menghitung indeks preferensi multikriteria
    3. Menghitung Leaving Flow
    4. Menghitung Entering Flow
    5. Menghitung Net Flow
    6. Mengurutkan hasil perankingan

[Tombol Hitung Sekarang — full width, primary besar]
```

**Step list style:**
```css
.step-list { list-style: none; padding: 0; margin: 0; }
.step-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 0;
  border-bottom: 1px solid var(--neutral-200);
  font-size: 14px;
  color: var(--neutral-600);
}
.step-item:last-child { border-bottom: none; }
.step-number {
  width: 26px;
  height: 26px;
  background: var(--color-primary-glow);
  color: var(--color-primary);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  font-weight: 700;
  flex-shrink: 0;
}
```

**Badge Status Bobot:**
```css
.badge-tersedia {
  background: var(--bg-success);
  color: var(--text-success);
  border-radius: 20px;
  padding: 4px 12px;
  font-size: 12px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 5px;
}
.badge-tidak-tersedia {
  background: var(--bg-danger);
  color: var(--text-danger);
  border-radius: 20px;
  padding: 4px 12px;
  font-size: 12px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 5px;
}
```

---

## 19. Halaman Hasil Perankingan

```
[Breadcrumb: Home / Hasil Perankingan]
[Judul: Hasil Perankingan]

[Row: 2 Stats Card + Dropdown Tahun]
  Card 1: Peringkat Tertinggi (nama mahasiswa terbaik)
  Card 2: Total Penerima Beasiswa
  [Dropdown filter tahun — posisi kanan atas]

[Tombol Download PDF — outline dengan icon download]

[Card: Tabel Hasil PROMETHEE]
  Kolom: Peringkat | NIM | Nama | Leaving Flow | Entering Flow | Net Flow | Status
```

**Badge ranking & status:**
```css
/* Ranking 1 special */
.rank-badge-1 {
  background: linear-gradient(135deg, #FFD700, #FFA500);
  color: white;
  border-radius: 50%;
  width: 30px;
  height: 30px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 13px;
}

.badge-penerima {
  background: var(--bg-success);
  color: var(--text-success);
  border-radius: 20px;
  padding: 3px 10px;
  font-size: 12px;
  font-weight: 600;
}
.badge-tidak-penerima {
  background: var(--neutral-50);
  color: var(--neutral-500);
  border-radius: 20px;
  padding: 3px 10px;
  font-size: 12px;
  font-weight: 600;
}
```

---

## 20. Halaman Dashboard Kaprodi

```
[Breadcrumb: Home / Dashboard]
[Judul: Dashboard Kaprodi]

[Card: Tabel Mahasiswa untuk Rekomendasi]
  [Toolbar]
    Kiri: Search Input (NIM atau Nama)
    
  [Tabel .table-spk]
    Kolom: No | NIM | Nama Mahasiswa | Program Studi | Jurusan | Aksi

  [Kolom Aksi: Tombol "Pilih" — biru primary kecil]
```

**Modal Surat Rekomendasi:**
- Size: `modal-xl`
- Body: Preview HTML surat rekomendasi bergaya dokumen resmi
- Kop surat: Logo Polinema + nama instansi
- Konten: data mahasiswa terpilih
- Footer: Tombol **Batal** (outline merah) + **Download PDF** (primary)

**Style preview surat dalam modal:**
```css
.surat-preview {
  background: white;
  border: 1px solid var(--neutral-300);
  border-radius: 8px;
  padding: 40px;
  font-family: 'Times New Roman', serif;
  font-size: 12pt;
  color: #000;
  min-height: 500px;
}
.surat-preview .kop-surat {
  display: flex;
  align-items: center;
  gap: 16px;
  padding-bottom: 12px;
  border-bottom: 3px solid #000;
  margin-bottom: 20px;
}
```

---

## 21. SweetAlert2 Theme & Patterns

```javascript
// Konfigurasi default SweetAlert sesuai warna primary
const SwalSpk = Swal.mixin({
  confirmButtonColor: '#5A81FA',
  cancelButtonColor: '#A0AEC0',
  customClass: {
    confirmButton: 'btn-swal-confirm',
    cancelButton: 'btn-swal-cancel',
  }
});

// Konfirmasi Hapus
SwalSpk.fire({
  title: 'Hapus Data?',
  text: 'Data yang dihapus tidak dapat dikembalikan.',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Ya, Hapus',
  cancelButtonText: 'Batal',
});

// Loading saat proses hitung PROMETHEE
Swal.fire({
  title: 'Memproses...',
  html: 'Sistem sedang menghitung PROMETHEE.<br>Mohon tunggu sebentar.',
  allowOutsideClick: false,
  showConfirmButton: false,
  didOpen: () => Swal.showLoading(),
});

// Sukses simpan bobot (total = 1.00)
SwalSpk.fire({
  icon: 'success',
  title: 'Berhasil!',
  text: 'Bobot kriteria berhasil disimpan.',
  timer: 2000,
  showConfirmButton: false,
});

// Warning bobot kurang
SwalSpk.fire({
  icon: 'warning',
  title: 'Total Bobot Belum Lengkap',
  text: 'Total bobot saat ini kurang dari 1.00. Pastikan total bobot tepat 1.00 sebelum menyimpan.',
});

// Error bobot lebih
SwalSpk.fire({
  icon: 'error',
  title: 'Total Bobot Melebihi 1.00',
  text: 'Kurangi nilai bobot agar total tidak melebihi 1.00.',
});
```

---

## 22. Pagination

```css
.pagination .page-link {
  border-radius: 8px;
  margin: 0 2px;
  font-size: 13px;
  font-weight: 600;
  color: var(--color-primary);
  border: 1.5px solid var(--neutral-200);
  padding: 6px 12px;
}
.pagination .page-item.active .page-link {
  background: var(--color-primary);
  border-color: var(--color-primary);
  color: white;
}
.pagination .page-link:hover {
  background: var(--color-primary-glow);
  border-color: var(--color-primary-tint);
}
```

---

## 23. Responsive

- Breakpoint utama menggunakan Bootstrap default (`md: 768px`, `lg: 992px`)
- Sidebar collapse menjadi offcanvas pada layar `< 768px`
- Stats card tumpuk menjadi 1 kolom pada mobile
- Tabel dengan `.table-responsive` (horizontal scroll) pada mobile
- Modal full-screen pada mobile: `.modal-fullscreen-sm-down`

---

## 24. Checklist Komponen Design

- [ ] CSS Variables terpasang di root
- [ ] Font Plus Jakarta Sans di-import
- [ ] Sidebar sesuai gambar (biru solid, menu, logo)
- [ ] Header/topbar dengan breadcrumb
- [ ] Halaman Login (split layout, card rounded besar)
- [ ] Stats card dashboard (3 card + icon warna-warni)
- [ ] Grafik Chart.js dashboard
- [ ] Tabel dengan header biru, hover, zebra strip
- [ ] Search bar dengan icon
- [ ] Dropdown dots menu aksi
- [ ] Modal form tambah/edit
- [ ] Badge jenis kriteria (benefit/cost)
- [ ] Card sub kriteria dengan icon
- [ ] Form bobot dengan total dinamis (merah/kuning/hijau)
- [ ] Step list tahapan PROMETHEE
- [ ] Badge ranking hasil
- [ ] Preview surat rekomendasi dalam modal
- [ ] SweetAlert terkonfigurasi
- [ ] Pagination styled
- [ ] Select2 styled
- [ ] Responsif mobile

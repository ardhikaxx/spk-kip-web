# 🎓 Sistem Pendukung Keputusan Penerima Beasiswa KIP-K
### Politeknik Negeri Jember - Metode PROMETHEE

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![SweetAlert2](https://img.shields.io/badge/SweetAlert2-FF5C5C?style=for-the-badge&logo=sweetalert2&logoColor=white)

---

## 📌 Tentang Proyek
**SPK KIP-K** adalah platform berbasis web yang dirancang untuk membantu proses seleksi penerima beasiswa KIP-Kuliah di **Politeknik Negeri Jember**. Sistem ini menggunakan metode **PROMETHEE (Preference Ranking Organization Method for Enrichment Evaluation)** untuk memberikan hasil perankingan yang objektif, transparan, dan akurat berdasarkan berbagai kriteria yang telah ditentukan.

## ✨ Fitur Utama
Sistem ini dilengkapi dengan berbagai fitur unggulan untuk memudahkan Admin dan Kaprodi:

### 🛡️ Dashboard & Manajemen
- **Modern Dashboard:** Visualisasi data ringkas bagi Admin dan Kaprodi.
- **Manajemen Pengguna:** Admin dapat mengelola akun (tambah/edit/hapus) untuk Admin lain maupun Kaprodi.
- **Data Mahasiswa:** Pengelolaan data calon penerima beasiswa (Import Excel didukung).

### ⚙️ Engine SPK (PROMETHEE)
- **Kriteria & Sub-Kriteria:** Pengaturan bobot dan kriteria yang fleksibel.
- **Perhitungan Otomatis:** Proses kalkulasi metode PROMETHEE yang cepat dan transparan.
- **Hasil Seleksi:** Laporan perankingan otomatis berdasarkan skor akhir tertinggi.

### 💎 Antarmuka (UI/UX)
- **Modern Login:** Desain login premium dengan gradasi warna indigo yang elegan.
- **Pill-Shaped Sidebar:** Navigasi modern sesuai dengan standar UI masa kini.
- **SweetAlert2 Integration:** Notifikasi interaktif untuk setiap aksi sistem.

## 🚀 Teknologi yang Digunakan
- **Framework:** Laravel 11
- **Styling:** Bootstrap 5 & Custom CSS (Vanilla)
- **Database:** MySQL
- **Library Tambahan:**
  - SweetAlert2 (Notifikasi & Konfirmasi)
  - Bootstrap Icons
  - Chart.js (Visualisasi Dashboard)
  - Maatwebsite Excel (Import Data)

## 🛠️ Instalasi Lokal

1. **Clone Repository**
   ```bash
   git clone https://github.com/ardhikaxx/spk-kip-web.git
   cd spk-kip-web
   ```

2. **Install Dependensi**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi & Seeder**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Server**
   ```bash
   php artisan serve
   ```

## 🔑 Akun Default (Demo)
| Role | Email | Password |
| --- | --- | --- |
| **Admin** | `admin@spkkip.test` | `password` |


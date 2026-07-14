# 🎓 Sistem Pendukung Keputusan Penerima Beasiswa KIP-K
### Politeknik Negeri Jember - Metode PROMETHEE

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![SweetAlert2](https://img.shields.io/badge/SweetAlert2-FF5C5C?style=for-the-badge&logo=sweetalert2&logoColor=white)

---

## 📌 Tentang Proyek
**SPK KIP-K** adalah sistem pendukung keputusan berbasis web yang dirancang untuk membantu proses seleksi penerima beasiswa KIP-Kuliah di **Politeknik Negeri Jember**. Sistem ini menerapkan metode **PROMETHEE (Preference Ranking Organization Method for Enrichment Evaluation)** guna memastikan proses perankingan dilakukan secara objektif, transparan, dan akurat berdasarkan berbagai parameter kriteria yang ditentukan.

## 👥 Peran Pengguna
1. **Administrator:** Memiliki akses penuh ke manajemen pengguna (Admin/Kaprodi), import data mahasiswa, pengaturan kriteria & bobot, serta pemantauan dashboard secara menyeluruh.
2. **Kaprodi:** Memiliki akses untuk memantau mahasiswa di bawah program studinya, melakukan seleksi, serta mencetak atau mengunduh surat rekomendasi beasiswa.

## ✨ Fitur Utama
- **Multi-Role Authentication:** Sistem manajemen peran yang ketat antara Admin dan Kaprodi.
- **Dynamic Dashboard:** Visualisasi data penerima, statistik per jurusan, dan perankingan, yang dapat difilter berdasarkan tahun.
- **PROMETHEE Engine:** Perhitungan *leaving flow*, *entering flow*, dan *net flow* secara otomatis.
- **Data Import:** Fitur *bulk import* mahasiswa via Excel dengan *loading indicator* yang informatif.
- **Interactive UI:** Pengalaman pengguna yang modern menggunakan SweetAlert2 untuk notifikasi dan konfirmasi aksi sensitif.

## 🛠️ Stack Teknologi
- **Framework:** Laravel 11 (PHP 8.2+)
- **Styling:** Bootstrap 5 & Vanilla CSS (Modern Design)
- **Database:** MySQL
- **Library Utama:** 
    - [Maatwebsite Excel](https://laravel-excel.com/) (Import Data)
    - [Chart.js](https://www.chartjs.org/) (Dashboard Visualization)
    - [SweetAlert2](https://sweetalert2.github.io/) (Interaktif Notifikasi)

## 🔑 Akun & Credential
Sistem menggunakan autentikasi berbasis email internal `@polije.ac.id`. 
*   **Admin:** `admin@polije.ac.id`
*   **Kaprodi:** Daftar akun prodi otomatis dibuat saat `php artisan migrate:fresh --seed` dijalankan (contoh: `d3manajemeninformatika@polije.ac.id`).
*   **Password:** Seluruh akun menggunakan password default: `password`.

## 🚀 Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/ardhikaxx/spk-kip-web.git
   cd spk-kip-web
   ```

2. **Setup Environment**
   ```bash
   cp .env.example .env
   # Atur database di file .env
   ```

3. **Install & Build**
   ```bash
   composer install
   npm install && npm run build
   ```

4. **Database & Seeder**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```
   Akses aplikasi di `http://127.0.0.1:8000`.

---
*Dikembangkan oleh Tim IT SPK KIP-K Politeknik Negeri Jember.*


## Donasi

Jika project ini bermanfaat, Anda dapat mendukung pengembangan selanjutnya melalui donasi:

<div align="center">

![QRIS](public/assets/qris.png)

**Scan QRIS di atas untuk berdonasi**

Setiap donasi akan digunakan untuk:
- Pengembangan fitur baru
- Perbaikan bug & maintenance
- Infrastruktur server

</div>
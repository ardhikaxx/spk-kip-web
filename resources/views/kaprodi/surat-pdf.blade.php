<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Rekomendasi {{ $mahasiswa->nim }}</title>
    <style>
        body { font-family: "Times New Roman", serif; color: #000; background: #fff; }
        .surat { max-width: 760px; margin: 20px auto; padding: 40px; border: 1px solid #ccc; }
        .kop { display: flex; align-items: flex-start; gap: 16px; border-bottom: 3px solid #000; padding-bottom: 12px; margin-bottom: 28px; }
        .kop img { width: 72px; }
        .kop h1 { font-size: 18px; margin: 0; text-align: center; }
        .kop p { margin: 3px 0; text-align: center; font-size: 12px; }
        table { margin: 18px 0; }
        td { padding: 4px 8px; vertical-align: top; }
        .ttd { width: 260px; margin-left: auto; margin-top: 50px; text-align: center; }
        @media print { .surat { border: 0; margin: 0; } button { display: none; } }
    </style>
</head>
<body>
    <button onclick="window.print()">Cetak / Simpan PDF</button>
    <div class="surat">
        <div class="kop">
            <img src="{{ asset('assets/logo-polije.png') }}" alt="Logo">
            <div style="flex:1">
                <h1>POLITEKNIK NEGERI JEMBER</h1>
                <p>Jl. Mastrip PO BOX 164, Jember, Jawa Timur</p>
                <p>Surat Rekomendasi Beasiswa KIP-K</p>
            </div>
        </div>
        <p>Yang bertanda tangan di bawah ini menerangkan bahwa mahasiswa berikut:</p>
        <table>
            <tr><td>NIM</td><td>:</td><td>{{ $mahasiswa->nim }}</td></tr>
            <tr><td>Nama</td><td>:</td><td>{{ $mahasiswa->nama_mhs }}</td></tr>
            <tr><td>Program Studi</td><td>:</td><td>{{ $mahasiswa->prodi }}</td></tr>
            <tr><td>Jurusan</td><td>:</td><td>{{ $mahasiswa->jurusan }}</td></tr>
        </table>
        <p>Direkomendasikan untuk mengikuti proses seleksi penerima Beasiswa KIP-K sesuai ketentuan yang berlaku di Politeknik Negeri Jember.</p>
        <p>Surat rekomendasi ini dibuat untuk digunakan sebagaimana mestinya.</p>
        <div class="ttd">
            <p>Jember, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Kaprodi,</p>
            <br><br><br>
            <p><strong>{{ auth()->user()->nama_lengkap ?? 'Kaprodi' }}</strong></p>
        </div>
    </div>
</body>
</html>

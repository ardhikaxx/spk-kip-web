<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil PROMETHEE {{ $tahun }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; }
        h1 { font-size: 20px; text-align: center; margin-bottom: 4px; }
        h2 { font-size: 14px; text-align: center; margin-top: 0; font-weight: normal; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
        th, td { border: 1px solid #777; padding: 7px; }
        th { background: #e8eefc; }
        @media print { button { display: none; } }
    </style>
</head>
<body>
    <button onclick="window.print()">Cetak / Simpan PDF</button>
    <h1>Hasil Perankingan PROMETHEE II</h1>
    <h2>Seleksi Beasiswa KIP-K Politeknik Negeri Jember Tahun {{ $tahun }}</h2>
    <table>
        <thead><tr><th>Rank</th><th>NIM</th><th>Nama</th><th>Leaving</th><th>Entering</th><th>Net Flow</th><th>Status</th></tr></thead>
        <tbody>
            @foreach($hasil as $row)
                <tr><td>{{ $row->ranking }}</td><td>{{ $row->alternatif->nim }}</td><td>{{ $row->alternatif->mahasiswa->nama_mhs }}</td><td>{{ number_format((float) $row->leaving_flow, 6) }}</td><td>{{ number_format((float) $row->entering_flow, 6) }}</td><td>{{ number_format((float) $row->net_flow, 6) }}</td><td>{{ $row->status }}</td></tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

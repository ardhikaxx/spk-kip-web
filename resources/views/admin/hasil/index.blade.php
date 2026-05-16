@extends('layouts.app')

@section('title', 'Hasil Perankingan')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-5"><div class="stats-card"><div><div class="stats-value fs-5">{{ $top?->alternatif?->mahasiswa?->nama_mhs ?? '-' }}</div><div class="stats-label">Peringkat Tertinggi</div></div><div class="stats-icon"><i class="bi bi-trophy-fill"></i></div></div></div>
    <div class="col-md-4"><div class="stats-card"><div><div class="stats-value">{{ $totalPenerima }}</div><div class="stats-label">Total Penerima Beasiswa</div></div><div class="stats-icon"><i class="bi bi-award-fill"></i></div></div></div>
    <div class="col-md-3">
        <form class="card-spk p-3" method="GET">
            <label class="form-label small">Filter Tahun</label>
            <select class="form-select" name="tahun" onchange="this.form.submit()">@forelse($years as $year)<option value="{{ $year }}" @selected($tahun == $year)>{{ $year }}</option>@empty<option value="{{ $tahun }}">{{ $tahun }}</option>@endforelse</select>
        </form>
    </div>
</div>
<div class="mb-3"><a href="{{ route('hasil.pdf', $tahun) }}" class="btn-spk-outline" target="_blank"><i class="bi bi-file-earmark-pdf"></i> Download PDF</a></div>
<div class="card-spk">
    <div class="card-header-spk">Tabel Hasil PROMETHEE</div>
    <div class="table-responsive">
        <table class="table-spk">
            <thead><tr><th>Peringkat</th><th>NIM</th><th>Nama Mahasiswa</th><th>Leaving Flow</th><th>Entering Flow</th><th>Net Flow</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($hasil as $row)
                    <tr>
                        <td>{!! $row->ranking == 1 ? '<span class="rank-badge-1">1</span>' : $row->ranking !!}</td>
                        <td>{{ $row->alternatif->nim }}</td>
                        <td>{{ $row->alternatif->mahasiswa->nama_mhs }}</td>
                        <td>{{ number_format((float) $row->leaving_flow, 6) }}</td>
                        <td>{{ number_format((float) $row->entering_flow, 6) }}</td>
                        <td><strong>{{ number_format((float) $row->net_flow, 6) }}</strong></td>
                        <td><span class="{{ $row->status === 'Penerima' ? 'badge-penerima' : 'badge-tidak-penerima' }}">{{ $row->status }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">Belum ada hasil perhitungan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $hasil->links() }}</div>
</div>
@endsection

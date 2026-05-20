@extends('layouts.app')

@section('title', 'Hitung PROMETHEE')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="stats-card"><div><div class="stats-value">{!! $statusBobot ? '<span class="badge-tersedia">Tersedia</span>' : '<span class="badge-tidak-tersedia">Tidak Tersedia</span>' !!}</div><div class="stats-label">Status Bobot Kriteria</div></div><div class="stats-icon"><i class="bi bi-sliders"></i></div></div></div>
    <div class="col-md-4"><div class="stats-card"><div><div class="stats-value">{{ $totalAlternatif }}</div><div class="stats-label">Total Alternatif</div></div><div class="stats-icon"><i class="bi bi-people"></i></div></div></div>
    <div class="col-md-4"><div class="stats-card"><div><div class="stats-value">{{ $totalKriteria }}</div><div class="stats-label">Total Kriteria</div></div><div class="stats-icon"><i class="bi bi-list-check"></i></div></div></div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-spk">
            <div class="card-header-spk">
                <span>Bobot Kriteria</span>
                <div class="ms-auto">
                    <form method="GET" class="d-flex align-items-center gap-2">
                        <label class="form-label mb-0 small text-muted">Tahun:</label>
                        <select class="form-select form-select-sm" name="tahun" onchange="this.form.submit()" style="width: auto; min-width: 100px;">
                            @forelse($years as $year)
                                <option value="{{ $year }}" @selected($tahun == $year)>{{ $year }}</option>
                            @empty
                                <option value="{{ $tahun }}">{{ $tahun }}</option>
                            @endforelse
                        </select>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table-spk">
                    <thead><tr><th>Kode</th><th>Nama Kriteria</th><th>Bobot</th></tr></thead>
                    <tbody>@foreach($kriteria as $row)<tr><td>{{ $row->kode_kriteria }}</td><td>{{ $row->nama_kriteria }}</td><td>{{ (float) ($row->bobot->nilai_bobot ?? $row->nilai_bobot) }}</td></tr>@endforeach</tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-spk">
            <div class="card-header-spk">Tahapan Perhitungan</div>
            <ol class="step-list">
                @foreach(['Menghitung selisih antar alternatif','Menghitung indeks preferensi multikriteria','Menghitung Leaving Flow','Menghitung Entering Flow','Menghitung Net Flow','Mengurutkan hasil perankingan'] as $step)
                    <li class="step-item"><span class="step-number">{{ $loop->iteration }}</span>{{ $step }}</li>
                @endforeach
            </ol>
        </div>
    </div>
</div>

<form class="mt-4" method="POST" action="{{ route('promethee.hitung') }}" id="formHitung">
    @csrf
    <input type="hidden" name="tahun" value="{{ $tahun }}">
    <div class="row g-2 align-items-end">
        <div class="col-md-3"><label class="form-label">Kuota Penerima</label><input class="form-control" type="number" name="quota" min="1" value="{{ $totalAlternatif }}"></div>
        <div class="col-md-9"><button class="btn-spk-primary w-100 justify-content-center py-3"><i class="bi bi-calculator"></i> Hitung Sekarang</button></div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.getElementById('formHitung').addEventListener('submit', () => {
    Swal.fire({ title: 'Memproses...', html: 'Sistem sedang menghitung PROMETHEE.<br>Mohon tunggu sebentar.', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });
});
</script>
@endpush

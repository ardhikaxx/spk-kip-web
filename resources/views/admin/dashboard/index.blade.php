@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="stats-card"><div><div class="stats-value">{{ $totalPendaftar }}</div><div class="stats-label">Total Pendaftar Beasiswa</div></div><div class="stats-icon"><i class="bi bi-people-fill"></i></div></div></div>
    <div class="col-md-4"><div class="stats-card"><div><div class="stats-value">{{ $totalPenerima }}</div><div class="stats-label">Total Penerima Beasiswa</div></div><div class="stats-icon" style="background:var(--color-cyan-glow);color:var(--color-cyan)"><i class="bi bi-award-fill"></i></div></div></div>
    <div class="col-md-4"><div class="stats-card"><div><div class="stats-value">{{ $totalKriteria }}</div><div class="stats-label">Jumlah Kriteria</div></div><div class="stats-icon" style="background:var(--color-purple-glow);color:var(--color-purple)"><i class="bi bi-list-check"></i></div></div></div>
</div>
<div class="card-spk">
    <div class="card-header-spk">Grafik Hasil Perankingan</div>
    <canvas id="rankingChart" height="110"></canvas>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('rankingChart'), {
    type: 'bar',
    data: {
        labels: @json($chartLabels),
        datasets: [{ label: 'Net Flow', data: @json($chartValues), backgroundColor: 'rgba(90,129,250,.7)', borderColor: '#5A81FA', borderWidth: 2, borderRadius: 6 }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { grid: { color: '#E6ECF4' } }, x: { grid: { display: false } } } }
});
</script>
@endpush

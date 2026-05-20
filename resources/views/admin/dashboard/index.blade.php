@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stats-card">
            <div>
                <div class="stats-value">{{ $totalPendaftar }}</div>
                <div class="stats-label">Total Pendaftar Beasiswa</div>
            </div>
            <div class="stats-icon"><i class="bi bi-people-fill"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div>
                <div class="stats-value">{{ $totalPenerima }}</div>
                <div class="stats-label">Total Penerima Beasiswa</div>
            </div>
            <div class="stats-icon" style="background:var(--color-cyan-glow);color:var(--color-cyan)"><i class="bi bi-award-fill"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div>
                <div class="stats-value">{{ $totalKriteria }}</div>
                <div class="stats-label">Jumlah Kriteria</div>
            </div>
            <div class="stats-icon" style="background:var(--color-purple-glow);color:var(--color-purple)"><i class="bi bi-list-check"></i></div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-spk h-100">
            <div class="card-header-spk">Distribusi Penerima</div>
            <div class="card-body-spk d-flex align-items-center justify-content-center" style="min-height: 300px;">
                <canvas id="distributionChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card-spk h-100">
            <div class="card-header-spk">Jumlah Mahasiswa per Jurusan</div>
            <div class="card-body-spk">
                <canvas id="jurusanChart" height="150"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card-spk">
    <div class="card-header-spk">Visualisasi 10 Besar Hasil Perankingan (Net Flow)</div>
    <div class="card-body-spk">
        <canvas id="rankingChart" height="100"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Ranking Chart
    new Chart(document.getElementById('rankingChart'), {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Net Flow',
                data: @json($chartValues),
                backgroundColor: 'rgba(90, 129, 250, 0.7)',
                borderColor: '#5A81FA',
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { grid: { color: '#E6ECF4' }, beginAtZero: true },
                x: { grid: { display: false } }
            }
        }
    });

    // Distribution Chart
    new Chart(document.getElementById('distributionChart'), {
        type: 'doughnut',
        data: {
            labels: @json($distributionLabels),
            datasets: [{
                data: @json($distributionValues),
                backgroundColor: ['#22C55E', '#EF4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            },
            cutout: '70%'
        }
    });

    // Jurusan Chart
    new Chart(document.getElementById('jurusanChart'), {
        type: 'bar',
        data: {
            labels: @json($jurusanLabels),
            datasets: [{
                label: 'Jumlah Mahasiswa',
                data: @json($jurusanValues),
                backgroundColor: 'rgba(6, 182, 212, 0.7)',
                borderColor: '#06B6D4',
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { grid: { color: '#E6ECF4' }, beginAtZero: true },
                y: { grid: { display: false } }
            }
        }
    });
</script>
@endpush

@extends('layouts.app')

@section('title', 'Data Kategorisasi Kriteria')

@section('content')
<div class="row g-3 kategorisasi-kriteria-grid">
    @foreach($kriteria as $row)
        <div class="col-sm-6 col-xl-4">
            <div class="card-spk kategorisasi-kriteria-card">
                <div class="kategorisasi-kriteria-card-body">
                    <div class="stats-icon kategorisasi-kriteria-icon"><i class="bi bi-folder-fill"></i></div>
                    <div class="kategorisasi-kriteria-info">
                        <div class="text-primary small fw-bold">{{ $row->kode_kriteria }}</div>
                        <div class="fw-bold kategorisasi-kriteria-title">{{ $row->nama_kriteria }}</div>
                        <div class="text-muted small">{{ $row->kategorisasiKriteria->count() }} kategorisasi</div>
                    </div>
                </div>
                <a class="btn-spk-outline kategorisasi-kriteria-action" href="{{ route('kategorisasi-kriteria.edit', $row) }}"><i class="bi bi-pencil"></i> Edit</a>
            </div>
        </div>
    @endforeach
</div>
@endsection

@push('styles')
<style>
    .kategorisasi-kriteria-grid {
        align-items: stretch;
    }

    .kategorisasi-kriteria-grid > [class*="col-"] {
        display: flex;
    }

    .kategorisasi-kriteria-card {
        width: 100%;
        min-height: 124px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
    }

    .kategorisasi-kriteria-card-body {
        min-width: 0;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .kategorisasi-kriteria-icon {
        flex: 0 0 52px;
    }

    .kategorisasi-kriteria-info {
        min-width: 0;
    }

    .kategorisasi-kriteria-title {
        line-height: 1.35;
        overflow-wrap: anywhere;
    }

    .kategorisasi-kriteria-action {
        flex: 0 0 auto;
        margin-bottom: 0;
        white-space: nowrap;
    }

    @media (max-width: 767.98px) {
        .kategorisasi-kriteria-card {
            min-height: 112px;
            padding: 16px;
            gap: 14px;
        }

        .kategorisasi-kriteria-icon {
            flex-basis: 46px;
            width: 46px;
            height: 46px;
            font-size: 20px;
        }
    }

    @media (max-width: 420px) {
        .kategorisasi-kriteria-card {
            align-items: stretch;
            flex-direction: column;
        }

        .kategorisasi-kriteria-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

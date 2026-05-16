@extends('layouts.app')

@section('title', 'Data Sub Kriteria')

@section('content')
<div class="row g-3 sub-kriteria-grid">
    @foreach($kriteria as $row)
        <div class="col-sm-6 col-xl-4">
            <div class="card-spk sub-kriteria-card">
                <div class="sub-kriteria-card-body">
                    <div class="stats-icon sub-kriteria-icon"><i class="bi bi-folder-fill"></i></div>
                    <div class="sub-kriteria-info">
                        <div class="text-primary small fw-bold">{{ $row->kode_kriteria }}</div>
                        <div class="fw-bold sub-kriteria-title">{{ $row->nama_kriteria }}</div>
                        <div class="text-muted small">{{ $row->subKriteria->count() }} sub kriteria</div>
                    </div>
                </div>
                <a class="btn-spk-outline sub-kriteria-action" href="{{ route('sub-kriteria.edit', $row) }}"><i class="bi bi-pencil"></i> Edit</a>
            </div>
        </div>
    @endforeach
</div>
@endsection

@push('styles')
<style>
    .sub-kriteria-grid {
        align-items: stretch;
    }

    .sub-kriteria-grid > [class*="col-"] {
        display: flex;
    }

    .sub-kriteria-card {
        width: 100%;
        min-height: 124px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
    }

    .sub-kriteria-card-body {
        min-width: 0;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .sub-kriteria-icon {
        flex: 0 0 52px;
    }

    .sub-kriteria-info {
        min-width: 0;
    }

    .sub-kriteria-title {
        line-height: 1.35;
        overflow-wrap: anywhere;
    }

    .sub-kriteria-action {
        flex: 0 0 auto;
        margin-bottom: 0;
        white-space: nowrap;
    }

    @media (max-width: 767.98px) {
        .sub-kriteria-card {
            min-height: 112px;
            padding: 16px;
            gap: 14px;
        }

        .sub-kriteria-icon {
            flex-basis: 46px;
            width: 46px;
            height: 46px;
            font-size: 20px;
        }
    }

    @media (max-width: 420px) {
        .sub-kriteria-card {
            align-items: stretch;
            flex-direction: column;
        }

        .sub-kriteria-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

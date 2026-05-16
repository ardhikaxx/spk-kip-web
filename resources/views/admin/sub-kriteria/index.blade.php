@extends('layouts.app')

@section('title', 'Data Sub Kriteria')

@section('content')
<div class="row g-3">
    @foreach($kriteria as $row)
        <div class="col-md-6 col-xl-4">
            <div class="card-spk d-flex align-items-center justify-content-between flex-row">
                <div class="d-flex align-items-center gap-3">
                    <div class="stats-icon"><i class="bi bi-folder-fill"></i></div>
                    <div>
                        <div class="text-primary small fw-bold">{{ $row->kode_kriteria }}</div>
                        <div class="fw-bold">{{ $row->nama_kriteria }}</div>
                        <div class="text-muted small">{{ $row->subKriteria->count() }} sub kriteria</div>
                    </div>
                </div>
                <a class="btn-spk-outline" href="{{ route('sub-kriteria.edit', $row) }}"><i class="bi bi-pencil"></i> Edit</a>
            </div>
        </div>
    @endforeach
</div>
@endsection

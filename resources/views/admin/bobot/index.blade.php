@extends('layouts.app')

@section('title', 'Pengaturan Bobot')

@section('content')
<form method="POST" action="{{ route('bobot.store') }}">
    @csrf
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card-spk">
                <div class="card-header-spk">Input Bobot Kriteria</div>
                @foreach($kriteria as $row)
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ $row->kode_kriteria }} - {{ $row->nama_kriteria }}</label>
                        <input class="form-control input-bobot" type="number" step="any" min="0" max="1" name="bobot[{{ $row->id_kriteria }}]" value="{{ old("bobot.{$row->id_kriteria}", (float) ($row->bobot->nilai_bobot ?? $row->nilai_bobot)) }}" required>
                    </div>
                @endforeach
                <div class="alert alert-warning small"><i class="bi bi-exclamation-triangle"></i> Total bobot harus bernilai 1.000000.</div>
                <div class="d-flex gap-2 flex-wrap"><button class="btn-spk-primary"><i class="bi bi-save"></i> Simpan Bobot</button><a href="{{ route('promethee.index') }}" class="btn-spk-outline">Lanjutkan ke Perhitungan</a></div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card-spk">
                <div class="card-header-spk">Ringkasan Bobot</div>
                @foreach($kriteria as $row)
                    <div class="d-flex justify-content-between py-2 border-bottom"><span>{{ $row->kode_kriteria }} - {{ $row->nama_kriteria }}</span><strong class="summary-bobot">{{ (float) ($row->bobot->nilai_bobot ?? $row->nilai_bobot) }}</strong></div>
                @endforeach
                <div class="d-flex justify-content-between align-items-center mt-3"><span class="fw-bold">Total Bobot</span><span id="total-bobot" class="fw-bold fs-5">0</span></div>
                <button class="btn-spk-primary w-100 justify-content-center mt-3"><i class="bi bi-save"></i> Simpan Bobot</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
function hitungTotalBobot() {
    let total = 0;
    document.querySelectorAll('.input-bobot').forEach(input => total += parseFloat(input.value) || 0);
    total = Math.round(total * 1000000) / 1000000;
    const el = document.getElementById('total-bobot');
    el.textContent = parseFloat(total.toFixed(6));
    el.classList.remove('text-danger', 'text-warning', 'text-success');
    if (total > 1.000001) el.classList.add('text-danger');
    else if (total < 0.999999) el.classList.add('text-warning');
    else el.classList.add('text-success');
}
document.querySelectorAll('.input-bobot').forEach(input => input.addEventListener('input', hitungTotalBobot));
hitungTotalBobot();
</script>
@endpush

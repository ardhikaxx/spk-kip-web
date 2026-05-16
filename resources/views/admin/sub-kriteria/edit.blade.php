@extends('layouts.app')

@section('title', 'Kelola Sub Kriteria')

@section('content')
<form class="card-spk" method="POST" action="{{ route('sub-kriteria.update', $kriteria) }}">
    @csrf @method('PUT')
    <div class="card-header-spk">{{ $kriteria->kode_kriteria }} - {{ $kriteria->nama_kriteria }}</div>
    <div class="table-responsive">
        <table class="table-spk" id="subTable">
            <thead><tr><th style="width:160px">Nilai Skala</th><th>Deskripsi Sub Kriteria</th><th style="width:80px">Hapus</th></tr></thead>
            <tbody>
                @foreach($kriteria->subKriteria as $index => $sub)
                    <tr>
                        <td><input type="number" name="sub[{{ $index }}][nilai]" class="form-control" value="{{ $sub->nilai }}" required></td>
                        <td><input name="sub[{{ $index }}][nama_subkriteria]" class="form-control" value="{{ $sub->nama_subkriteria }}" required></td>
                        <td><button type="button" class="btn-spk-danger remove-row"><i class="bi bi-trash"></i></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between mt-3">
        <button type="button" class="btn-spk-outline" id="addRow"><i class="bi bi-plus"></i> Tambah Baris</button>
        <button class="btn-spk-primary"><i class="bi bi-save"></i> Simpan Semua Perubahan</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
let rowIndex = {{ $kriteria->subKriteria->count() }};
document.getElementById('addRow').addEventListener('click', () => {
    document.querySelector('#subTable tbody').insertAdjacentHTML('beforeend', `<tr><td><input type="number" name="sub[${rowIndex}][nilai]" class="form-control" required></td><td><input name="sub[${rowIndex}][nama_subkriteria]" class="form-control" required></td><td><button type="button" class="btn-spk-danger remove-row"><i class="bi bi-trash"></i></button></td></tr>`);
    rowIndex++;
});
document.addEventListener('click', (event) => {
    if (event.target.closest('.remove-row')) event.target.closest('tr').remove();
});
</script>
@endpush

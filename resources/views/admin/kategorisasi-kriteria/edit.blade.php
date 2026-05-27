@extends('layouts.app')

@section('title', 'Kelola Kategorisasi Kriteria')

@section('content')
<form class="card-spk" method="POST" action="{{ route('kategorisasi-kriteria.update', $kriteria) }}">
    @csrf @method('PUT')
    <div class="card-header-spk">{{ $kriteria->kode_kriteria }} - {{ $kriteria->nama_kriteria }}</div>
    <div class="table-responsive">
        <table class="table-spk" id="kategoriTable">
            <thead><tr><th style="width:160px">Nilai Skala</th><th>Deskripsi Kategorisasi</th><th style="width:80px">Hapus</th></tr></thead>
            <tbody>
                @foreach($kriteria->kategorisasiKriteria as $index => $sub)
                    <tr>
                        <td><input type="number" name="kategori[{{ $index }}][nilai]" class="form-control" value="{{ $sub->nilai }}" required></td>
                        <td><input name="kategori[{{ $index }}][nama_kategorisasi]" class="form-control" value="{{ $sub->nama_kategorisasi }}" required></td>
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
let rowIndex = {{ $kriteria->kategorisasiKriteria->count() }};
document.getElementById('addRow').addEventListener('click', () => {
    document.querySelector('#kategoriTable tbody').insertAdjacentHTML('beforeend', `<tr><td><input type="number" name="kategori[${rowIndex}][nilai]" class="form-control" required></td><td><input name="kategori[${rowIndex}][nama_kategorisasi]" class="form-control" required></td><td><button type="button" class="btn-spk-danger remove-row"><i class="bi bi-trash"></i></button></td></tr>`);
    rowIndex++;
});
document.addEventListener('click', (event) => {
    if (event.target.closest('.remove-row')) event.target.closest('tr').remove();
});
</script>
@endpush

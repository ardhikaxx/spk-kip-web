@extends('layouts.app')

@section('title', 'Kelola Alternatif')

@section('content')
<div class="card-spk">
    <div class="card-header-spk">
        <form class="search-spk" method="GET"><i class="bi bi-search search-icon"></i><input name="search" value="{{ $search }}" placeholder="Cari nama mahasiswa..."></form>
        <div class="d-flex gap-2">
            <button class="btn-spk-outline" data-bs-toggle="modal" data-bs-target="#modalBulk"><i class="bi bi-layers-fill"></i> Tambah Semua</button>
            <button class="btn-spk-primary" data-bs-toggle="modal" data-bs-target="#modalCreate"><i class="bi bi-plus-lg"></i> Tambah Alternatif</button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table-spk">
            <thead><tr><th>No</th><th>Nama Mahasiswa</th><th>Tahun</th>@foreach($kriteria as $k)<th>{{ $k->kode_kriteria }}</th>@endforeach<th>Aksi</th></tr></thead>
            <tbody>
                @forelse($alternatif as $index => $row)
                    <tr>
                        <td>{{ $alternatif->firstItem() + $index }}</td>
                        <td><strong>{{ $row->mahasiswa->nama_mhs }}</strong><div class="text-muted small">{{ $row->nim }}</div></td>
                        <td>{{ $row->tahun }}</td>
                        @foreach(range(1, 6) as $i)
                            <td><span class="fw-bold">{{ $row->{"c{$i}"} }}</span><div class="text-muted small">{{ $row->{"label_c{$i}"} }}</div></td>
                        @endforeach
                        <td><form method="POST" action="{{ route('alternatif.destroy', $row) }}" data-confirm-delete>@csrf @method('DELETE')<button class="btn-spk-danger"><i class="bi bi-trash"></i></button></form></td>
                    </tr>
                @empty
                    <tr><td colspan="{{ 4 + $kriteria->count() }}" class="text-center text-muted">Belum ada alternatif.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $alternatif->links('partials.pagination') }}</div>
</div>

<div class="modal fade modal-spk" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-lg"><form class="modal-content" method="POST" action="{{ route('alternatif.store') }}">
        @csrf
        <div class="modal-header"><h5 class="modal-title">Tambah Alternatif</h5><button class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Mahasiswa</label>
                    <select class="form-select select2" id="select-mahasiswa" name="nim" required>
                        <option value="">Pilih mahasiswa</option>
                        @foreach($mahasiswa as $mhs)
                            <option value="{{ $mhs->nim }}">{{ $mhs->nim }} - {{ $mhs->nama_mhs }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4"><label class="form-label">Tahun Seleksi</label><input class="form-control" type="number" name="tahun" value="{{ now()->year }}" required></div>
            </div>
            <div class="mt-4 d-none" id="detail-kriteria">
                <div class="fw-bold mb-2">Detail Kriteria Otomatis</div>
                <div class="row g-3">
                    @foreach(range(1, 6) as $i)
                        <div class="col-md-4"><label class="form-label">C{{ $i }}</label><input class="form-control" id="input-c{{ $i }}" readonly></div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal" type="button">Batal</button><button class="btn-spk-primary">Simpan Alternatif</button></div>
    </form></div>
</div>
<div class="modal fade modal-spk" id="modalBulk" tabindex="-1">
    <div class="modal-dialog"><form class="modal-content" method="POST" action="{{ route('alternatif.bulk') }}">
        @csrf
        <div class="modal-header"><h5 class="modal-title">Tambah Semua Alternatif</h5><button class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
        <div class="modal-body">
            <p class="text-muted small">Fitur ini akan menyalin seluruh data mahasiswa menjadi alternatif untuk tahun yang dipilih. Jika alternatif sudah ada untuk tahun tersebut, data akan diperbarui.</p>
            <label class="form-label">Tahun Seleksi</label>
            <input class="form-control" type="number" name="tahun" value="{{ now()->year }}" required>
        </div>
        <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal" type="button">Batal</button><button class="btn-spk-primary">Proses Tambah Semua</button></div>
    </form></div>
</div>
@endsection

@push('scripts')
<script>
$('#select-mahasiswa').on('change', function () {
    const nim = $(this).val();
    if (!nim) return;
    fetch(`{{ url('/admin/alternatif/mahasiswa') }}/${nim}`)
        .then(response => response.json())
        .then(data => {
            $('#detail-kriteria').removeClass('d-none');
            $('#input-c1').val(`${data.scores.c1} - ${data.kip}`);
            $('#input-c2').val(`${data.scores.c2} - ${data.dtks}`);
            $('#input-c3').val(`${data.scores.c3} - ${data.desil}`);
            $('#input-c4').val(`${data.scores.c4} - ${data.penghasilan}`);
            $('#input-c5').val(`${data.scores.c5} - ${data.status_ortu}`);
            $('#input-c6').val(`${data.scores.c6} - ${data.prestasi}`);
        });
});
</script>
@endpush

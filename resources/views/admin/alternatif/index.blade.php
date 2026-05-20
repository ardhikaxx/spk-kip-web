@extends('layouts.app')

@section('title', 'Kelola Alternatif')

@section('content')
<div class="card-spk">
    <div class="card-header-spk">
        <form class="search-spk" method="GET"><i class="bi bi-search search-icon"></i><input name="search" value="{{ $search }}" placeholder="Cari nama mahasiswa..."></form>
        <div class="d-flex gap-2">
            <button class="btn-spk-outline" data-bs-toggle="modal" data-bs-target="#modalBulk"><i class="bi bi-layers-fill"></i> Tambah Semua</button>
            <button class="btn-spk-primary" data-bs-toggle="modal" data-bs-target="#modalCreate"><i class="bi bi-plus-lg"></i> Tambah Alternatif</button>
            <button type="button" class="btn-spk-danger" id="btnDeleteSelected"><i class="bi bi-trash"></i> Hapus Terpilih</button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table-spk">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>Tahun</th>
                    @foreach($kriteria as $k)
                    <th>{{ $k->kode_kriteria }}</th>
                    @endforeach
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alternatif as $index => $row)
                    <tr>
                        <td><input type="checkbox" class="row-select" value="{{ $row->id_alternatif }}"></td>
                        <td>{{ $alternatif->firstItem() + $index }}</td>
                        <td><strong>{{ $row->mahasiswa->nama_mhs }}</strong><div class="text-muted small">{{ $row->nim }}</div></td>
                        <td>{{ $row->tahun }}</td>
                        @foreach(range(1, 6) as $i)
                            <td><span class="fw-bold">{{ $row->{"c{$i}"} }}</span><div class="text-muted small">{{ $row->{"label_c{$i}"} }}</div></td>
                        @endforeach
                        <td><form method="POST" action="{{ route('alternatif.destroy', $row) }}" data-confirm-delete>@csrf @method('DELETE')<button class="btn-spk-danger"><i class="bi bi-trash"></i></button></form></td>
                    </tr>
                @empty
                    <tr><td colspan="{{ 5 + $kriteria->count() }}" class="text-center text-muted">Belum ada alternatif.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $alternatif->links('partials.pagination') }}</div>
</div>

<form id="bulkDeleteForm" action="{{ route('alternatif.destroyAll') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="bulkDeleteIds">
</form>

@endsection

<!-- Modals -->
<div class="modal fade modal-spk" id="modalBulk" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Semua Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('alternatif.bulk') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Fitur ini akan menambahkan <strong>seluruh data mahasiswa</strong> yang ada ke dalam daftar alternatif untuk tahun terpilih.</p>
                    <div class="mb-3">
                        <label class="form-label">Tahun Angkatan/Seleksi</label>
                        <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-spk-outline" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-spk-primary">Tambah Semua</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-spk" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Alternatif Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('alternatif.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Pilih Mahasiswa</label>
                            <select name="nim" id="select-mahasiswa" class="form-select" required>
                                <option value="">-- Cari Nama atau NIM --</option>
                                @foreach($mahasiswa as $m)
                                    <option value="{{ $m->nim }}">{{ $m->nim }} - {{ $m->nama_mhs }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                    </div>

                    <div id="detail-kriteria" class="mt-4 d-none">
                        <h6 class="fw-bold mb-3 border-bottom pb-2">Preview Skor Kriteria</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="small text-muted mb-1">C1 - KIP</label>
                                <input type="text" id="input-c1" class="form-control bg-light" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted mb-1">C2 - DTKS</label>
                                <input type="text" id="input-c2" class="form-control bg-light" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted mb-1">C3 - Desil</label>
                                <input type="text" id="input-c3" class="form-control bg-light" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted mb-1">C4 - Penghasilan</label>
                                <input type="text" id="input-c4" class="form-control bg-light" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted mb-1">C5 - Status Ortu</label>
                                <input type="text" id="input-c5" class="form-control bg-light" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted mb-1">C6 - Prestasi</label>
                                <input type="text" id="input-c6" class="form-control bg-light" readonly>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3 py-2 small">
                            <i class="bi bi-info-circle-fill me-1"></i> Skor di atas dihitung secara otomatis berdasarkan data mahasiswa.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-spk-outline" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-spk-primary">Simpan Alternatif</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAll');
        const rowCheckboxes = document.querySelectorAll('.row-select');
        const deleteSelectedBtn = document.getElementById('btnDeleteSelected');
        const bulkDeleteForm = document.getElementById('bulkDeleteForm');
        const bulkDeleteIdsInput = document.getElementById('bulkDeleteIds');

        // Select all/deselect all
        selectAllCheckbox.addEventListener('change', function (e) {
            rowCheckboxes.forEach(cb => {
                cb.checked = e.target.checked;
            });
        });

        // If any row checkbox is unchecked, uncheck select all
        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                if (this.checked) {
                    // check if all are checked
                    selectAllCheckbox.checked = [...rowCheckboxes].every(cbx => cbx.checked);
                } else {
                    selectAllCheckbox.checked = false;
                }
            });
        });

        // Handle bulk delete
        deleteSelectedBtn.addEventListener('click', function () {
            const selectedIds = [];
            rowCheckboxes.forEach(cb => {
                if (cb.checked) {
                    selectedIds.push(cb.value);
                }
            });

            if (selectedIds.length === 0) {
                alert('Pilih minimal satu data untuk dihapus.');
                return;
            }

            if (confirm('Apakah Anda yakin ingin menghapus ' + selectedIds.length + ' data yang dipilih?')) {
                bulkDeleteIdsInput.value = JSON.stringify(selectedIds);
                bulkDeleteForm.submit();
            }
        });
    });
</script>
@endpush

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

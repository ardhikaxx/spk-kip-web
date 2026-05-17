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

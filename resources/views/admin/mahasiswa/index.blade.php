@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@php
    $fields = [
        'nim' => 'NIM', 'nama_mhs' => 'Nama Mahasiswa', 'prodi' => 'Program Studi', 'jurusan' => 'Jurusan',
        'kip' => 'KIP / Jalur Seleksi', 'dtk' => 'DTKS', 'desil' => 'Desil', 'kerja_ayah' => 'Pekerjaan Ayah',
        'penghasilan_ayah' => 'Penghasilan Ayah', 'keterangan_ayah' => 'Keterangan Ayah', 'kerja_ibu' => 'Pekerjaan Ibu',
        'penghasilan_ibu' => 'Penghasilan Ibu', 'keterangan_ibu' => 'Keterangan Ibu', 'prestasi' => 'Prestasi',
    ];
@endphp

@section('content')
<div class="card-spk">
    <div class="card-header-spk">
        <form class="search-spk" method="GET">
            <i class="bi bi-search search-icon"></i>
            <input name="search" value="{{ $search }}" placeholder="Cari NIM atau Nama...">
        </form>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('mahasiswa.template') }}" class="btn-spk-outline"><i class="bi bi-download"></i> Template</a>
            <button class="btn-spk-outline" data-bs-toggle="modal" data-bs-target="#modalImport"><i class="bi bi-file-earmark-arrow-up"></i> Import Excel/CSV</button>
            <button class="btn-spk-primary" data-bs-toggle="modal" data-bs-target="#modalCreate"><i class="bi bi-plus-lg"></i> Tambah Data</button>
            <button type="button" class="btn-spk-danger" id="btnDeleteSelected"><i class="bi bi-trash"></i> Hapus Terpilih</button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table-spk">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Program Studi</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mahasiswa as $index => $row)
                    <tr>
                        <td><input type="checkbox" class="row-select" value="{{ $row->nim }}"></td>
                        <td>{{ $mahasiswa->firstItem() + $index }}</td>
                        <td>{{ $row->nim ?? '-' }}</td>
                        <td>{{ $row->nama_mhs ?? '-' }}</td>
                        <td>{{ $row->prodi ?? '-' }}</td>
                        <td>{{ $row->jurusan ?? '-' }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn-dots" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $row->nim }}"><i class="bi bi-eye"></i> Detail</button>
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $row->nim }}"><i class="bi bi-pencil"></i> Edit</button>
                                    <form method="POST" action="{{ route('mahasiswa.destroy', $row) }}" data-confirm-delete>
                                        @csrf @method('DELETE')
                                        <button class="dropdown-item text-danger" type="submit"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">Belum ada data mahasiswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $mahasiswa->links('partials.pagination') }}</div>
</div>

<form id="bulkDeleteForm" action="{{ route('mahasiswa.destroyAll') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="nims" id="bulkDeleteNims">
</form>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAll');
        const rowCheckboxes = document.querySelectorAll('.row-select');
        const deleteSelectedBtn = document.getElementById('btnDeleteSelected');
        const bulkDeleteForm = document.getElementById('bulkDeleteForm');
        const bulkDeleteNimsInput = document.getElementById('bulkDeleteNims');

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
            const selectedNims = [];
            rowCheckboxes.forEach(cb => {
                if (cb.checked) {
                    selectedNims.push(cb.value);
                }
            });

            if (selectedNims.length === 0) {
                alert('Pilih minimal satu data untuk dihapus.');
                return;
            }

            if (confirm('Apakah Anda yakin ingin menghapus ' + selectedNims.length + ' data yang dipilih?')) {
                bulkDeleteNimsInput.value = JSON.stringify(selectedNims);
                bulkDeleteForm.submit();
            }
        });
    });
</script>
@endpush

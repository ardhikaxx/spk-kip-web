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

<!-- Modals -->
<div class="modal fade modal-spk" id="modalImport" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">File Excel/CSV</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx, .xls, .csv" required>
                        <small class="text-muted">Gunakan template yang tersedia untuk memastikan format data sesuai.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-spk-outline" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-spk-primary">Mulai Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-spk" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('mahasiswa.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        @foreach($fields as $name => $label)
                            <div class="col-md-6">
                                <label class="form-label">{{ $label }}</label>
                                @if($name === 'desil')
                                    <input type="number" name="{{ $name }}" class="form-control" placeholder="Masukkan {{ $label }}">
                                @else
                                    <input type="text" name="{{ $name }}" class="form-control" placeholder="Masukkan {{ $label }}" {{ in_array($name, ['nim', 'nama_mhs']) ? 'required' : '' }}>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-spk-outline" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-spk-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($mahasiswa as $row)
    <!-- Detail Modal -->
    <div class="modal fade modal-spk" id="modalDetail{{ $row->nim }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Mahasiswa: {{ $row->nama_mhs }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        @foreach($fields as $name => $label)
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ $label }}</label>
                                <div class="p-2 bg-light rounded border">{{ $row->$name ?? '-' }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-spk-outline" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade modal-spk" id="modalEdit{{ $row->nim }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Mahasiswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('mahasiswa.update', $row) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row g-3">
                            @foreach($fields as $name => $label)
                                <div class="col-md-6">
                                    <label class="form-label">{{ $label }}</label>
                                    @if($name === 'desil')
                                        <input type="number" name="{{ $name }}" class="form-control" value="{{ $row->$name }}">
                                    @else
                                        <input type="text" name="{{ $name }}" class="form-control" value="{{ $row->$name }}" {{ in_array($name, ['nim', 'nama_mhs']) ? 'required' : '' }}>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-spk-outline" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-spk-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

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

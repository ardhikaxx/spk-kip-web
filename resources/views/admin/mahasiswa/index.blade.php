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
            <form action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
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
                    <button type="submit" class="btn-spk-primary" id="btnImportSubmit">Mulai Import</button>
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
                        <div class="col-md-6">
                            <label class="form-label">NIM</label>
                            <input type="text" name="nim" class="form-control" placeholder="Masukkan NIM" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Mahasiswa</label>
                            <input type="text" name="nama_mhs" class="form-control" placeholder="Masukkan Nama" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jurusan</label>
                            <select name="jurusan" class="form-select jurusan-select" required>
                                <option value="">-- Pilih Jurusan --</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Program Studi</label>
                            <select name="prodi" class="form-select prodi-select" required>
                                <option value="">-- Pilih Program Studi --</option>
                            </select>
                        </div>
                        @foreach($fields as $name => $label)
                            @if(!in_array($name, ['nim', 'nama_mhs', 'prodi', 'jurusan']))
                            <div class="col-md-6">
                                <label class="form-label">{{ $label }}</label>
                                @if($name === 'desil')
                                    <input type="number" name="{{ $name }}" class="form-control" placeholder="Masukkan {{ $label }}">
                                @else
                                    <input type="text" name="{{ $name }}" class="form-control" placeholder="Masukkan {{ $label }}">
                                @endif
                            </div>
                            @endif
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
                            <div class="col-md-6">
                                <label class="form-label">NIM</label>
                                <input type="text" name="nim" class="form-control" value="{{ $row->nim }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Mahasiswa</label>
                                <input type="text" name="nama_mhs" class="form-control" value="{{ $row->nama_mhs }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jurusan</label>
                                <select name="jurusan" class="form-select jurusan-select" data-selected="{{ $row->jurusan }}" required>
                                    <option value="">-- Pilih Jurusan --</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Program Studi</label>
                                <select name="prodi" class="form-select prodi-select" data-selected="{{ $row->prodi }}" required>
                                    <option value="">-- Pilih Program Studi --</option>
                                </select>
                            </div>
                            @foreach($fields as $name => $label)
                                @if(!in_array($name, ['nim', 'nama_mhs', 'prodi', 'jurusan']))
                                <div class="col-md-6">
                                    <label class="form-label">{{ $label }}</label>
                                    @if($name === 'desil')
                                        <input type="number" name="{{ $name }}" class="form-control" value="{{ $row->$name }}">
                                    @else
                                        <input type="text" name="{{ $name }}" class="form-control" value="{{ $row->$name }}">
                                    @endif
                                </div>
                                @endif
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
    const prodiData = {
        "Jurusan Produksi Pertanian": ["D3 Produksi Tanaman Hortikultura", "D3 Produksi Tanaman Perkebunan", "D4 Budidaya Tanaman Perkebunan", "D4 Teknik Produksi Benih", "D4 Teknologi Produksi Tanaman Pangan", "D4 Pengelolaan Perkebunan Kopi"],
        "Jurusan Teknologi Pertanian": ["D3 Teknologi Industri Pangan", "D3 Keteknikan Pertanian", "D4 Teknologi Rekayasa Pangan"],
        "Jurusan Peternakan": ["D3 Produksi Ternak", "D4 Manajemen Bisnis Unggas", "D4 Teknologi Pakan Ternak"],
        "Jurusan Manajemen Agribisnis": ["D3 Manajemen Agribisnis", "D4 Manajemen Agroindustri"],
        "Jurusan Teknologi Informasi": ["D3 Manajemen Informatika", "D3 Teknik Komputer", "D4 Teknik Informatika", "D4 Teknologi Rekayasa Komputer"],
        "Jurusan Bahasa, Komunikasi, dan Pariwisata": ["D3 Bahasa Inggris", "D4 Destinasi Pariwisata"],
        "Jurusan Kesehatan": ["D4 Manajemen Informasi Kesehatan", "D4 Gizi Klinik", "D4 Promosi Kesehatan"],
        "Jurusan Teknik": ["D4 Teknik Energi Terbarukan", "D4 Mesin Otomotif", "D4 Teknologi Rekayasa Mekatronika"],
        "Jurusan Bisnis": ["D4 Akuntansi Sektor Publik", "D4 Manajemen Pemasaran Internasional"],
        "Kelas Internasional": ["Manajemen Informatika (INT)", "Teknik Informatika (INT)", "Manajemen Agroindustri (INT)"],
        "PSDKU Bondowoso (Kampus 2)": ["D4 Manajemen Agribisnis", "D4 Produksi Media", "D4 Bisnis Digital"],
        "PSDKU Nganjuk (Kampus 3)": ["D3 Manajemen Agribisnis", "D4 Teknik Informatika"],
        "PSDKU Sidoarjo (Kampus 4)": ["D4 Manajemen Agroindustri", "D4 Teknik Informatika"],
        "PSDKU Ngawi (Kampus 5)": ["D4 Manajemen Agribisnis", "D4 Manajemen Informasi Kesehatan"],
        "PSDKU Sabu Raijua (Kampus 6)": ["D4 Teknologi Rekayasa Perangkat Lunak"]
    };

    function initProdiDropdowns(container) {
        const jurusanSelect = container.querySelector('.jurusan-select');
        const prodiSelect = container.querySelector('.prodi-select');

        if (!jurusanSelect || !prodiSelect) return;

        // Populate Jurusan
        jurusanSelect.innerHTML = '<option value="">-- Pilih Jurusan --</option>';
        Object.keys(prodiData).forEach(jurusan => {
            const option = document.createElement('option');
            option.value = jurusan;
            option.textContent = jurusan;
            jurusanSelect.appendChild(option);
        });

        jurusanSelect.addEventListener('change', function() {
            const selectedJurusan = this.value;
            prodiSelect.innerHTML = '<option value="">-- Pilih Program Studi --</option>';
            
            if (selectedJurusan && prodiData[selectedJurusan]) {
                prodiData[selectedJurusan].forEach(prodi => {
                    const option = document.createElement('option');
                    option.value = prodi;
                    option.textContent = prodi;
                    prodiSelect.appendChild(option);
                });
            }
        });

        // Handle initial values for edit
        const initialJurusan = jurusanSelect.getAttribute('data-selected');
        const initialProdi = prodiSelect.getAttribute('data-selected');

        if (initialJurusan) {
            jurusanSelect.value = initialJurusan;
            jurusanSelect.dispatchEvent(new Event('change'));
            if (initialProdi) {
                prodiSelect.value = initialProdi;
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('importForm').addEventListener('submit', function() {
            Swal.fire({ 
                title: 'Memproses...', 
                html: 'Sistem sedang mengimpor data.<br>Mohon tunggu sebentar.', 
                allowOutsideClick: false, 
                showConfirmButton: false, 
                didOpen: () => Swal.showLoading() 
            });
        });

        // Initialize all modals
        document.querySelectorAll('.modal').forEach(modal => {
            initProdiDropdowns(modal);
        });
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
                SwalSpk.fire({ icon: 'info', title: 'Pilih Data', text: 'Pilih minimal satu data untuk dihapus.' });
                return;
            }

            SwalSpk.fire({
                title: 'Hapus ' + selectedNims.length + ' Data?',
                text: 'Data yang dipilih akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus Semua',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkDeleteNimsInput.value = JSON.stringify(selectedNims);
                    bulkDeleteForm.submit();
                }
            });
        });
    });
</script>
@endpush

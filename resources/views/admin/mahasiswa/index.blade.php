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
        </div>
    </div>
    <div class="table-responsive">
        <table class="table-spk">
            <thead><tr><th>No</th><th>NIM</th><th>Nama Mahasiswa</th><th>Program Studi</th><th>Jurusan</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($mahasiswa as $index => $row)
                    <tr>
                        <td>{{ $mahasiswa->firstItem() + $index }}</td>
                        <td>{{ $row->nim ?? '-' }}</td>
                        <td>{{ $row->nama_mhs ?? '-' }}</td>
                        <td>{{ $row->prodi ?? '-' }}</td>
                        <td>{{ $row->jurusan ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn-spk-outline py-1 px-2" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEdit{{ $row->nim }}"
                                    title="Edit Data">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form method="POST" action="{{ route('mahasiswa.destroy', $row) }}" data-confirm-delete>
                                    @csrf @method('DELETE')
                                    <button class="btn-spk-danger py-1 px-2" type="submit" title="Hapus Data">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">Belum ada data mahasiswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $mahasiswa->links('partials.pagination') }}</div>
</div>

@foreach($mahasiswa as $row)
    <div class="modal fade modal-spk" id="modalEdit{{ $row->nim }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
            <form class="modal-content" method="POST" action="{{ route('mahasiswa.update', $row) }}">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Mahasiswa</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        @foreach($fields as $name => $label)
                            <div class="col-md-6">
                                <label class="form-label">{{ $label }}</label>
                                <input class="form-control" name="{{ $name }}" value="{{ old($name, $row->{$name}) }}" {{ in_array($name, ['nim','nama_mhs']) ? 'required' : '' }}>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal" type="button">Batal</button>
                    <button class="btn-spk-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

<div class="modal fade modal-spk" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-lg modal-fullscreen-sm-down"><form class="modal-content" method="POST" action="{{ route('mahasiswa.store') }}">
        @csrf
        <div class="modal-header"><h5 class="modal-title">Tambah Mahasiswa</h5><button class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
        <div class="modal-body"><div class="row g-3">
            @foreach($fields as $name => $label)
                <div class="col-md-6"><label class="form-label">{{ $label }}</label><input class="form-control" name="{{ $name }}" value="{{ old($name) }}" {{ in_array($name, ['nim','nama_mhs']) ? 'required' : '' }}></div>
            @endforeach
        </div></div>
        <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal" type="button">Batal</button><button class="btn-spk-primary">Simpan</button></div>
    </form></div>
</div>

<div class="modal fade modal-spk" id="modalImport" tabindex="-1">
    <div class="modal-dialog"><form class="modal-content" method="POST" action="{{ route('mahasiswa.import') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-header"><h5 class="modal-title">Import Data Mahasiswa</h5><button class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
        <div class="modal-body">
            <label class="form-label">File Excel/CSV</label>
            <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv,.txt" required>
            <div class="text-muted small mt-2">Format kolom mengikuti template: nim, nama_mhs, prodi, jurusan, kip, dtk, desil, dan data orang tua.</div>
        </div>
        <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal" type="button">Batal</button><button class="btn-spk-primary">Import</button></div>
    </form></div>
</div>
@endsection

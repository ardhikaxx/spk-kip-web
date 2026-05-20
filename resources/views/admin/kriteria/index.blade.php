@extends('layouts.app')

@section('title', 'Data Kriteria')

@section('content')
<div class="card-spk">
    <div class="card-header-spk">
        <span>Tabel Data Kriteria</span>
        <button class="btn-spk-primary" data-bs-toggle="modal" data-bs-target="#modalCreate"><i class="bi bi-plus-lg"></i> Tambah Kriteria</button>
    </div>
    <div class="table-responsive">
        <table class="table-spk">
            <thead><tr><th>No</th><th>Kode</th><th>Nama Kriteria</th><th>Jenis</th><th>Bobot</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($kriteria as $index => $row)
                    <tr>
                        <td>{{ $kriteria->firstItem() + $index }}</td>
                        <td>{{ $row->kode_kriteria }}</td>
                        <td>{{ $row->nama_kriteria }}</td>
                        <td><span class="badge-{{ $row->jenis_kriteria }}">{{ ucfirst($row->jenis_kriteria) }}</span></td>
                        <td>{{ number_format((float) $row->nilai_bobot, 4) }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn-dots" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $row->id_kriteria }}"><i class="bi bi-pencil"></i> Edit</button>
                                    <form method="POST" action="{{ route('kriteria.destroy', $row) }}" data-confirm-delete>@csrf @method('DELETE')<button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash"></i> Hapus</button></form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade modal-spk" id="modalEdit{{ $row->id_kriteria }}" tabindex="-1">
                        <div class="modal-dialog"><form class="modal-content" method="POST" action="{{ route('kriteria.update', $row) }}">
                            @csrf @method('PUT')
                            <div class="modal-header"><h5 class="modal-title">Edit Kriteria</h5><button class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
                            @include('admin.kriteria.form', ['row' => $row])
                            <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal" type="button">Batal</button><button class="btn-spk-primary">Simpan</button></div>
                        </form></div>
                    </div>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">Belum ada kriteria.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $kriteria->links('partials.pagination') }}</div>
</div>

<div class="modal fade modal-spk" id="modalCreate" tabindex="-1">
    <div class="modal-dialog"><form class="modal-content" method="POST" action="{{ route('kriteria.store') }}">
        @csrf
        <div class="modal-header"><h5 class="modal-title">Tambah Kriteria</h5><button class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
        @include('admin.kriteria.form', ['row' => null])
        <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal" type="button">Batal</button><button class="btn-spk-primary">Simpan</button></div>
    </form></div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Data Kriteria')

@section('content')
<div class="card-spk">
    <div class="card-header-spk">
        <span>Tabel Data Kriteria</span>
        @if($totalWeight >= 1)
            <button class="btn-spk-primary" disabled title="Total bobot sudah mencapai 1.00"><i class="bi bi-plus-lg"></i> Tambah Kriteria</button>
        @else
            <button class="btn-spk-primary" data-bs-toggle="modal" data-bs-target="#modalCreate"><i class="bi bi-plus-lg"></i> Tambah Kriteria</button>
        @endif
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
                        <td>{{ number_format((float) $row->nilai_bobot, 2) }}</td>
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

@foreach($kriteria as $row)
    <div class="modal fade modal-spk" id="modalEdit{{ $row->id_kriteria }}" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('kriteria.update', $row) }}">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kriteria</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                @include('admin.kriteria.form', ['row' => $row])
                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal" type="button">Batal</button>
                    <button class="btn-spk-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endforeach
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalWeight = {{ $totalWeight }};
        
        // Handle all modals (Create and Edit)
        document.querySelectorAll('.modal-spk').forEach(modal => {
            const inputBobot = modal.querySelector('input[name="nilai_bobot"]');
            const form = modal.querySelector('form');
            if (!inputBobot || !form) return;

            // Get current weight if editing, 0 if creating
            const isEdit = modal.id !== 'modalCreate';
            const currentWeight = isEdit ? parseFloat(inputBobot.value) || 0 : 0;
            const otherWeightsTotal = totalWeight - currentWeight;

            inputBobot.addEventListener('input', function() {
                const newValue = parseFloat(this.value) || 0;
                const newTotal = otherWeightsTotal + newValue;

                if (newTotal > 1.0001) {
                    const maxAllowed = (1.0 - otherWeightsTotal).toFixed(2);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Batas Bobot Terlampaui',
                        text: `Total bobot tidak boleh melebihi 1. Sisa bobot yang tersedia adalah ${maxAllowed}.`,
                        confirmButtonColor: '#1a3c5e'
                    });
                    this.value = maxAllowed;
                }
            });

            form.addEventListener('submit', function(e) {
                const newValue = parseFloat(inputBobot.value) || 0;
                if ((otherWeightsTotal + newValue) > 1.0001) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan',
                        text: 'Total bobot melebihi batas 1.00.',
                        confirmButtonColor: '#1a3c5e'
                    });
                }
            });
        });
    });
</script>
@endpush

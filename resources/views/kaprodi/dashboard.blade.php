@extends('layouts.app')

@section('title', 'Dashboard Kaprodi')

@section('content')
<div class="card-spk">
    <div class="card-header-spk">
        <form class="search-spk" method="GET"><i class="bi bi-search search-icon"></i><input name="search" value="{{ $search }}" placeholder="Cari NIM atau Nama..."></form>
    </div>
    <div class="table-responsive">
        <table class="table-spk">
            <thead><tr><th>No</th><th>NIM</th><th>Nama Mahasiswa</th><th>Program Studi</th><th>Jurusan</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($mahasiswa as $index => $row)
                    <tr>
                        <td>{{ $mahasiswa->firstItem() + $index }}</td>
                        <td>{{ $row->nim }}</td>
                        <td>{{ $row->nama_mhs }}</td>
                        <td>{{ $row->prodi }}</td>
                        <td>{{ $row->jurusan }}</td>
                        <td><button class="btn-spk-primary" data-bs-toggle="modal" data-bs-target="#modalSurat{{ $row->nim }}">Pilih</button></td>
                    </tr>
                    <div class="modal fade modal-spk" id="modalSurat{{ $row->nim }}" tabindex="-1">
                        <div class="modal-dialog modal-xl"><div class="modal-content">
                            <div class="modal-header"><h5 class="modal-title">Surat Rekomendasi</h5><button class="btn-close" data-bs-dismiss="modal" type="button"></button></div>
                            <div class="modal-body"><iframe src="{{ route('kaprodi.surat', $row->nim) }}" style="width:100%;height:620px;border:1px solid #CBD5E1;border-radius:8px"></iframe></div>
                            <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal" type="button">Batal</button><a class="btn-spk-primary" href="{{ route('kaprodi.surat.download', $row->nim) }}" target="_blank">Download PDF</a></div>
                        </div></div>
                    </div>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">Belum ada data mahasiswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $mahasiswa->links() }}</div>
</div>
@endsection

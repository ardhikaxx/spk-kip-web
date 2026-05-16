<div class="modal-body">
    <div class="mb-3"><label class="form-label">Kode Kriteria</label><input class="form-control" name="kode_kriteria" value="{{ old('kode_kriteria', $row->kode_kriteria ?? '') }}" placeholder="C1" required></div>
    <div class="mb-3"><label class="form-label">Nama Kriteria</label><input class="form-control" name="nama_kriteria" value="{{ old('nama_kriteria', $row->nama_kriteria ?? '') }}" required></div>
    <div class="mb-3"><label class="form-label">Jenis Kriteria</label><select class="form-select" name="jenis_kriteria" required><option value="benefit" @selected(old('jenis_kriteria', $row->jenis_kriteria ?? 'benefit') === 'benefit')>Benefit</option><option value="cost" @selected(old('jenis_kriteria', $row->jenis_kriteria ?? '') === 'cost')>Cost</option></select></div>
    <div><label class="form-label">Nilai Bobot</label><input class="form-control" type="number" step="0.0001" min="0" max="1" name="nilai_bobot" value="{{ old('nilai_bobot', $row->nilai_bobot ?? '') }}" required></div>
</div>

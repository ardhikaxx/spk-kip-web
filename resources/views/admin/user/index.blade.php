@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="card-spk">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <button class="btn-spk-primary" data-bs-toggle="modal" data-bs-target="#modalUser">
                <i class="bi bi-person-plus-fill"></i> Tambah Akun
            </button>
        </div>
        <div class="table-responsive">
            <table class="table-spk">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Role / Prodi</th>
                        <th>Nomor Telepon</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td class="fw-bold">{{ $user->nama_lengkap }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="badge {{ $user->role === 'admin' ? 'bg-primary' : 'bg-info' }} text-white align-self-start mb-1 px-2 py-1">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    @if($user->role === 'kaprodi' && $user->prodi)
                                        <span class="text-muted small fw-medium" style="font-size: 0.85rem;">
                                            <i class="bi bi-mortarboard-fill me-1"></i>{{ $user->prodi }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $user->nomor_telepon ?? '-' }}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn-dots" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <button class="dropdown-item" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalUser"
                                            data-user='@json($user)'>
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        @if($user->id_user !== auth()->id())
                                        <form action="{{ route('users.destroy', $user->id_user) }}" method="POST" data-confirm-delete>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $users->links('partials.pagination') }}</div>
    </div>

    <!-- Modal User -->
    <div class="modal fade modal-spk" id="modalUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Akun Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formUser" method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div id="methodField"></div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control"
                                placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan alamat email"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="nomor_telepon" class="form-control"
                                placeholder="Masukkan nomor telepon" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role Pengguna</label>
                            <select name="role" id="roleSelect" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="kaprodi">Kaprodi</option>
                            </select>
                        </div>
                        <div id="kaprodiFields" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Jurusan</label>
                                <select name="jurusan" id="jurusanSelect" class="form-select">
                                    <option value="">-- Pilih Jurusan --</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Program Studi</label>
                                <select name="prodi" id="prodiSelect" class="form-select">
                                    <option value="">-- Pilih Program Studi --</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="password-group">
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required id="passwordInput">
                                <button type="button" class="btn-toggle-password" data-target="passwordInput">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted" id="passwordHelp" style="display: none;">Biarkan kosong jika tidak ingin mengubah password.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-spk-outline" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-spk-primary">Simpan Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const prodiData = {
            "Jurusan Produksi Pertanian": [
                "D3 Produksi Tanaman Hortikultura",
                "D3 Produksi Tanaman Perkebunan",
                "D4 Budidaya Tanaman Perkebunan",
                "D4 Teknik Produksi Benih",
                "D4 Teknologi Produksi Tanaman Pangan",
                "D4 Pengelolaan Perkebunan Kopi"
            ],
            "Jurusan Teknologi Pertanian": [
                "D3 Teknologi Industri Pangan",
                "D3 Keteknikan Pertanian",
                "D4 Teknologi Rekayasa Pangan"
            ],
            "Jurusan Peternakan": [
                "D3 Produksi Ternak",
                "D4 Manajemen Bisnis Unggas",
                "D4 Teknologi Pakan Ternak"
            ],
            "Jurusan Manajemen Agribisnis": [
                "D3 Manajemen Agribisnis",
                "D4 Manajemen Agroindustri"
            ],
            "Jurusan Teknologi Informasi": [
                "D3 Manajemen Informatika",
                "D3 Teknik Komputer",
                "D4 Teknik Informatika",
                "D4 Teknologi Rekayasa Komputer"
            ],
            "Jurusan Bahasa, Komunikasi, dan Pariwisata": [
                "D3 Bahasa Inggris",
                "D4 Destinasi Pariwisata"
            ],
            "Jurusan Kesehatan": [
                "D4 Manajemen Informasi Kesehatan",
                "D4 Gizi Klinik",
                "D4 Promosi Kesehatan"
            ],
            "Jurusan Teknik": [
                "D4 Teknik Energi Terbarukan",
                "D4 Mesin Otomotif",
                "D4 Teknologi Rekayasa Mekatronika"
            ],
            "Jurusan Bisnis": [
                "D4 Akuntansi Sektor Publik",
                "D4 Manajemen Pemasaran Internasional"
            ],
            "Kelas Internasional": [
                "Manajemen Informatika (INT)",
                "Teknik Informatika (INT)",
                "Manajemen Agroindustri (INT)"
            ],
            "PSDKU Bondowoso (Kampus 2)": [
                "D4 Manajemen Agribisnis",
                "D4 Produksi Media",
                "D4 Bisnis Digital"
            ],
            "PSDKU Nganjuk (Kampus 3)": [
                "D3 Manajemen Agribisnis",
                "D4 Teknik Informatika"
            ],
            "PSDKU Sidoarjo (Kampus 4)": [
                "D4 Manajemen Agroindustri",
                "D4 Teknik Informatika"
            ],
            "PSDKU Ngawi (Kampus 5)": [
                "D4 Manajemen Agribisnis",
                "D4 Manajemen Informasi Kesehatan"
            ],
            "PSDKU Sabu Raijua (Kampus 6)": [
                "D4 Teknologi Rekayasa Perangkat Lunak"
            ]
        };

        const modalUser = document.getElementById('modalUser');
        const roleSelect = document.getElementById('roleSelect');
        const kaprodiFields = document.getElementById('kaprodiFields');
        const jurusanSelect = document.getElementById('jurusanSelect');
        const prodiSelect = document.getElementById('prodiSelect');

        function updateKaprodiVisibility() {
            if (roleSelect.value === 'kaprodi') {
                kaprodiFields.style.display = 'block';
                jurusanSelect.required = true;
                prodiSelect.required = true;
            } else {
                kaprodiFields.style.display = 'none';
                jurusanSelect.required = false;
                prodiSelect.required = false;
            }
        }

        function populateJurusan() {
            jurusanSelect.innerHTML = '<option value="">-- Pilih Jurusan --</option>';
            Object.keys(prodiData).forEach(jurusan => {
                const option = document.createElement('option');
                option.value = jurusan;
                option.textContent = jurusan;
                jurusanSelect.appendChild(option);
            });
        }

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

        roleSelect.addEventListener('change', updateKaprodiVisibility);

        populateJurusan();

        modalUser.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const user = button.getAttribute('data-user') ? JSON.parse(button.getAttribute('data-user')) : null;

            const form = document.getElementById('formUser');
            const modalTitle = document.getElementById('modalTitle');
            const methodField = document.getElementById('methodField');
            const passwordInput = document.getElementById('passwordInput');
            const passwordHelp = document.getElementById('passwordHelp');

            if (user) {
                // Edit Mode
                modalTitle.textContent = 'Edit Akun Pengguna';
                form.action = `/admin/users/${user.id_user}`;
                methodField.innerHTML = '@method('PUT')';

                form.querySelector('[name="nama_lengkap"]').value = user.nama_lengkap;
                form.querySelector('[name="email"]').value = user.email;
                form.querySelector('[name="nomor_telepon"]').value = user.nomor_telepon || '';
                form.querySelector('[name="role"]').value = user.role;
                
                updateKaprodiVisibility();
                
                if (user.role === 'kaprodi') {
                    jurusanSelect.value = user.jurusan || '';
                    jurusanSelect.dispatchEvent(new Event('change'));
                    prodiSelect.value = user.prodi || '';
                }

                passwordInput.required = false;
                passwordHelp.style.display = 'block';
            } else {
                // Add Mode
                modalTitle.textContent = 'Tambah Akun Pengguna';
                form.action = "{{ route('users.store') }}";
                methodField.innerHTML = '';
                form.reset();
                updateKaprodiVisibility();

                passwordInput.required = true;
                passwordHelp.style.display = 'none';
            }
        });
    </script>
@endpush

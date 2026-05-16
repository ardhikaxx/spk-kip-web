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
                        <th>Nomor Telepon</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $user->nama_lengkap }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->nomor_telepon ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $user->role === 'admin' ? 'badge-benefit' : 'badge-tersedia' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn-spk-outline py-1 px-2" data-bs-toggle="modal"
                                        data-bs-target="#modalUser" data-user='@json($user)'>
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    @if ($user->id_user !== auth()->id())
                                        <form action="{{ route('users.destroy', $user->id_user) }}" method="POST"
                                            data-confirm-delete>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-spk-danger py-1 px-2">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
                                placeholder="Masukkan nomor telepon (Opsional)">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role Pengguna</label>
                            <select name="role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="kaprodi">Kaprodi</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password"
                                required id="passwordInput">
                            <small class="text-muted" id="passwordHelp" style="display: none;">Biarkan kosong jika tidak
                                ingin mengubah password.</small>
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
        const modalUser = document.getElementById('modalUser');
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

                passwordInput.required = false;
                passwordHelp.style.display = 'block';
            } else {
                // Add Mode
                modalTitle.textContent = 'Tambah Akun Pengguna';
                form.action = "{{ route('users.store') }}";
                methodField.innerHTML = '';
                form.reset();

                passwordInput.required = true;
                passwordHelp.style.display = 'none';
            }
        });
    </script>
@endpush

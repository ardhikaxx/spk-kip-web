@extends('layouts.auth')

@section('title', 'Ubah Password')

@section('content')
<div class="form-header">
    <h2>Ubah Password</h2>
    <p>Silahkan masukkan password baru untuk akun <strong>{{ $email }}</strong></p>
</div>

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">

    <div class="form-group">
        <label class="form-label">Password Baru</label>
        <div class="input-wrapper">
            <i class="bi bi-lock input-icon"></i>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required id="new-password">
            <button type="button" class="btn-toggle-password" data-target="new-password">
                <i class="bi bi-eye"></i>
            </button>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Konfirmasi Password Baru</label>
        <div class="input-wrapper">
            <i class="bi bi-lock-check input-icon"></i>
            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required id="confirm-password">
            <button type="button" class="btn-toggle-password" data-target="confirm-password">
                <i class="bi bi-eye"></i>
            </button>
        </div>
    </div>

    <button type="submit" class="btn-auth">
        Simpan Password Baru <i class="bi bi-check-circle"></i>
    </button>
</form>
@endsection

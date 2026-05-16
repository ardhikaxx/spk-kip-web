@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
<div class="form-header">
    <h2>Lupa Password</h2>
    <p>Masukkan email Anda untuk memverifikasi akun.</p>
</div>

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="form-group">
        <label class="form-label">Email Address</label>
        <div class="input-wrapper">
            <i class="bi bi-envelope input-icon"></i>
            <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
        </div>
    </div>

    <button type="submit" class="btn-auth">
        Verifikasi Email <i class="bi bi-shield-check"></i>
    </button>

    <div class="text-center mt-4">
        <a href="{{ route('login') }}" class="small text-decoration-none fw-bold" style="color: var(--color-primary)">Kembali ke Login</a>
    </div>
</form>
@endsection

@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="form-header">
    <h2>Selamat Datang</h2>
    <p>Silahkan masuk ke akun Anda untuk melanjutkan.</p>
</div>

<form method="POST" action="{{ url('/login') }}">
    @csrf

    <div class="form-group">
        <label class="form-label">Email Address</label>
        <div class="input-wrapper">
            <i class="bi bi-envelope input-icon"></i>
            <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Password</label>
        <div class="input-wrapper">
            <i class="bi bi-lock input-icon"></i>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required id="login-password">
            <button type="button" class="btn-toggle-password" data-target="login-password">
                <i class="bi bi-eye"></i>
            </button>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label small text-secondary" for="remember">Ingat saya</label>
        </div>
        <a href="{{ route('password.request') }}" class="small text-decoration-none fw-bold" style="color: var(--color-primary)">Lupa Password?</a>
    </div>

    <button type="submit" class="btn-auth">
        Masuk Sekarang <i class="bi bi-arrow-right"></i>
    </button>
</form>

<div class="footer-text">
    Gunakan kredensial default untuk demo:<br>
    <code>admin@gmail.com</code> / <code>password</code>
</div>
@endsection

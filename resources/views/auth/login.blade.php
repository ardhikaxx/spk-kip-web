<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SPK KIP-K</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { 
            --color-primary: #4F46E5; 
            --color-primary-dark: #4338CA;
            --color-primary-light: #EEF2FF;
            --neutral-50: #F8FAFC;
            --neutral-100: #F1F5F9;
            --neutral-200: #E2E8F0;
            --neutral-300: #CBD5E1;
            --neutral-400: #94A3B8;
            --neutral-600: #475569;
            --neutral-700: #334155;
            --neutral-800: #1E293B;
            --neutral-900: #0F172A;
        }

        body { 
            margin: 0; 
            min-height: 100vh; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--neutral-50); 
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
        }

        /* Left Side: Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px;
            color: white;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -10%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(80px);
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -5%;
            left: -5%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            filter: blur(60px);
        }

        .hero-content {
            position: relative;
            z-index: 10;
        }

        .badge-spk {
            display: inline-block;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 100px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-section h1 {
            font-size: 48px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 24px;
            letter-spacing: -1px;
        }

        .hero-section p {
            font-size: 18px;
            opacity: 0.9;
            max-width: 500px;
            line-height: 1.6;
        }

        .feature-list {
            margin-top: 48px;
            display: grid;
            gap: 20px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* Right Side: Login Form */
        .form-section {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: white;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
        }

        .brand-logo {
            margin-bottom: 40px;
            text-align: left;
        }

        .brand-logo img {
            height: 60px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.05));
        }

        .form-header {
            margin-bottom: 32px;
        }

        .form-header h2 {
            font-size: 28px;
            font-weight: 800;
            color: var(--neutral-900);
            margin-bottom: 8px;
        }

        .form-header p {
            color: var(--neutral-400);
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--neutral-700);
            margin-bottom: 8px;
            display: block;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--neutral-400);
            font-size: 18px;
        }

        .form-control {
            height: 52px;
            padding: 12px 14px 12px 44px;
            border: 1.5px solid var(--neutral-200);
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.2s;
            color: var(--neutral-800);
        }

        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        .btn-login {
            width: 100%;
            height: 52px;
            background: var(--color-primary);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 700;
            margin-top: 12px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            background: var(--color-primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .footer-text {
            text-align: center;
            margin-top: 32px;
            font-size: 14px;
            color: var(--neutral-400);
        }

        .footer-text code {
            background: var(--neutral-100);
            padding: 2px 6px;
            border-radius: 4px;
            color: var(--color-primary);
            font-family: inherit;
            font-weight: 600;
        }

        @media (max-width: 1024px) {
            .hero-section { padding: 40px; }
            .hero-section h1 { font-size: 36px; }
        }

        @media (max-width: 768px) {
            .login-wrapper { grid-template-columns: 1fr; }
            .hero-section { display: none; }
            .form-section { min-height: 100vh; }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Left: Hero -->
        <section class="hero-section">
            <div class="hero-content">
                <span class="badge-spk">Sistem Pendukung Keputusan</span>
                <h1>Beasiswa KIP-K<br>Lebih Akurat & Transparan.</h1>
                <p>Platform seleksi penerima beasiswa menggunakan metode PROMETHEE untuk hasil perhitungan yang lebih objektif dan tepat sasaran.</p>
                
                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                        <div>
                            <div class="fw-bold">Metode PROMETHEE</div>
                            <small class="opacity-75">Algoritma perangkingan multikriteria yang handal.</small>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <div>
                            <div class="fw-bold">Analisis Real-time</div>
                            <small class="opacity-75">Dapatkan hasil perhitungan secara instan dan akurat.</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Right: Login -->
        <section class="form-section">
            <div class="login-card">
                <div class="brand-logo">
                    <img src="{{ asset('assets/logo-spk-kip-color.png') }}" alt="Logo">
                </div>
                
                <div class="form-header">
                    <h2>Selamat Datang</h2>
                    <p>Silahkan masuk ke akun Anda untuk melanjutkan.</p>
                </div>

                <form method="POST" action="{{ url('/login') }}">
                    @csrf
                    
                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm small rounded-3 mb-4">
                            <i class="bi bi-exclamation-circle-fill me-2"></i> {{ $errors->first() }}
                        </div>
                    @endif

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
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember">
                            <label class="form-check-label small text-secondary" for="remember">Ingat saya</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">
                        Masuk Sekarang <i class="bi bi-arrow-right"></i>
                    </button>
                </form>

                <div class="footer-text">
                    Gunakan kredensial default untuk demo:<br>
                    <code>admin@spkkip.test</code> / <code>password</code>
                </div>
            </div>
        </section>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth') | SPK KIP-K</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="{{ asset('assets/logo-polije.png') }}" type="image/x-icon">
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

        .auth-wrapper {
            width: 100%;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
        }

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

        .form-section {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: white;
        }

        .auth-card {
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

        .btn-auth {
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
            text-decoration: none;
        }

        .btn-auth:hover {
            background: var(--color-primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
            color: white;
        }

        .btn-toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--neutral-400);
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            z-index: 10;
        }

        .btn-toggle-password:hover {
            color: var(--color-primary);
        }

        .footer-text {
            text-align: center;
            margin-top: 32px;
            font-size: 14px;
            color: var(--neutral-400);
        }

        @media (max-width: 1024px) {
            .hero-section { padding: 40px; }
            .hero-section h1 { font-size: 36px; }
        }

        @media (max-width: 768px) {
            .auth-wrapper { grid-template-columns: 1fr; }
            .hero-section { display: none; }
            .form-section { min-height: 100vh; }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
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

        <section class="form-section">
            <div class="auth-card">
                <div class="brand-logo">
                    <img src="{{ asset('assets/logo-spk-kip-color.png') }}" alt="Logo">
                </div>
                
                @yield('content')
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const SwalSpk = Swal.mixin({ confirmButtonColor: '#4F46E5', cancelButtonColor: '#94A3B8' });
        
        @if(session('success'))
            SwalSpk.fire({ icon: 'success', title: 'Berhasil', text: @json(session('success')), timer: 2500, showConfirmButton: false });
        @endif
        
        @if(session('error'))
            SwalSpk.fire({ icon: 'error', title: 'Gagal', text: @json(session('error')) });
        @endif

        @if($errors->any())
            SwalSpk.fire({ icon: 'error', title: 'Periksa Input', text: @json($errors->first()) });
        @endif

        document.querySelectorAll('.btn-toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.replace('bi-eye', 'bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.replace('bi-eye-slash', 'bi-eye');
                }
            });
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK KIP-K | @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="shortcut icon" href="{{ asset('assets/logo-polije.png') }}" type="image/x-icon">
    <style>
        :root {
            --color-primary: #4669D6;
            --color-primary-hover: #3b59b8;
            --color-primary-active: #2e4694;
            --color-primary-tint: #e9edfa;
            --color-primary-glow: #f0f4ff;
            --color-pink: #FF63A5;
            --color-pink-light: #FFD3E6;
            --color-pink-glow: #FFF0F6;
            --color-purple: #924FEF;
            --color-purple-glow: #F7F3FE;
            --color-cyan: #409CFF;
            --color-cyan-glow: #F0F6FF;
            --neutral-50: #EEF2F6;
            --neutral-100: #FFFFFF;
            --neutral-200: #E6ECF4;
            --neutral-300: #CBD5E1;
            --neutral-400: #A0AEC0;
            --neutral-500: #718096;
            --neutral-600: #4A5568;
            --neutral-700: #2D3748;
            --neutral-800: #1A202C;
            --neutral-900: #111827;
            --sidebar-width: 260px;
            --header-height: 64px;
            --border-radius-sm: 8px;
            --border-radius-md: 12px;
            --border-radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.02);
            --shadow-md: 0 8px 24px rgba(149, 157, 165, 0.08);
            --shadow-card: 0 2px 12px rgba(90, 129, 250, 0.08);
        }
        html, body { 
            margin: 0; 
            padding: 0; 
            height: 100%; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--neutral-50); 
            color: var(--neutral-700); 
        }
        body { overflow-x: hidden; }
        body.sidebar-open { overflow: hidden; }
        .sidebar { 
            width: var(--sidebar-width); height: 100vh !important; position: fixed; inset: 0 auto 0 0; 
            background: #4669D6; z-index: 1001; padding: 28px 0; 
            display: flex; flex-direction: column; overflow-y: auto;
            transition: transform .25s ease, box-shadow .25s ease;
            will-change: transform;
        }
        @supports (-webkit-touch-callout: none) {
            .sidebar { height: -webkit-fill-available !important; }
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 2px; }
        .sidebar-brand { display: flex; align-items: center; gap: 12px; color: #fff; padding: 0 24px 30px; margin-bottom: 10px; border-bottom: 0; }
        .sidebar-brand img { height: 45px; width: auto; object-fit: contain; }
        .sidebar-menu { display: grid; align-content: start; gap: 8px; padding-left: 18px; }
        .sidebar-menu-item { color: #fff; display: flex; align-items: center; gap: 14px; padding: 14px 22px; border-radius: 30px 0 0 30px; font-size: 15px; font-weight: 600; text-decoration: none; transition: all .2s ease; }
        .sidebar-menu-item:hover { background: rgba(255,255,255, 0.1); color: #fff; }
        .sidebar-menu-item.active { background: #FFFFFF; color: #4669D6; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .sidebar-menu-item i { font-size: 18px; }
        .sidebar-footer { margin-top: auto; padding: 0 18px; border-top: 0; }
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(17, 24, 39, 0.58);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity .2s ease, visibility .2s ease;
        }
        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }
        .content-area { margin-left: var(--sidebar-width); min-height: 100vh; }
        .topbar { height: var(--header-height); background: #fff; border-bottom: 1px solid var(--neutral-200); display: flex; align-items: center; justify-content: space-between; padding: 0 32px; position: sticky; top: 0; z-index: 999; }
        .page-content { padding: 28px 32px; }
        .page-title { font-size: 22px; font-weight: 800; color: var(--neutral-900); margin-bottom: 20px; }
        .breadcrumb { margin: 0; font-size: 13px; }
        .breadcrumb a { color: var(--color-primary); text-decoration: none; }
        .card-spk, .stats-card { background: #fff; border: 1px solid var(--neutral-200); border-radius: var(--border-radius-md); box-shadow: var(--shadow-md); }
        .card-spk { padding: 24px; }
        .card-header-spk { 
            font-size: 15px; font-weight: 800; color: var(--neutral-800); margin-bottom: 20px; padding-bottom: 14px; 
            border-bottom: 1px solid var(--neutral-200); display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; 
        }
        @media (max-width: 576px) {
            .card-header-spk { flex-direction: column; align-items: stretch; gap: 16px; }
            .card-header-spk .d-flex { flex-direction: column; width: 100%; }
        }
        .stats-card { padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; }
        .stats-value { font-size: 28px; font-weight: 800; color: var(--neutral-900); line-height: 1; }
        .stats-label { font-size: 13px; color: var(--neutral-500); margin-top: 5px; }
        .stats-icon { width: 52px; height: 52px; border-radius: 14px; display: grid; place-items: center; font-size: 22px; background: var(--color-primary-glow); color: var(--color-primary); }
        .table-spk { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 14px; }
        .table-spk thead th { background: var(--color-primary-glow); color: var(--color-primary-active); font-weight: 700; font-size: 13px; padding: 12px 16px; white-space: nowrap; }
        .table-spk tbody td { padding: 13px 16px; vertical-align: middle; border-bottom: 1px solid var(--neutral-200); }
        .table-spk tbody tr:nth-child(even) { background: var(--neutral-50); }
        .table-spk tbody tr:hover { background: var(--color-primary-glow); }
        .btn-spk-primary { background: var(--color-primary); color: white; border: 0; border-radius: 8px; padding: 9px 16px; font-size: 14px; font-weight: 700; display: inline-flex; align-items: center; gap: 7px; text-decoration: none; }
        .btn-spk-primary:hover { background: var(--color-primary-hover); color: white; }
        .btn-spk-outline { background: transparent; color: var(--color-primary); border: 1.5px solid var(--color-primary); border-radius: 8px; padding: 8px 16px; font-size: 14px; font-weight: 700; display: inline-flex; align-items: center; gap: 7px; text-decoration: none; }
        .btn-spk-danger { background: var(--color-pink-glow); color: var(--color-pink); border: 1px solid var(--color-pink-light); border-radius: 8px; padding: 7px 12px; font-weight: 700; }
        .btn-dots { width: 34px; height: 34px; border: 1px solid var(--neutral-200); border-radius: 8px; background: var(--neutral-50); color: var(--neutral-600); }
        .search-spk { position: relative; width: min(320px, 100%); }
        .search-spk input { padding-left: 38px; height: 40px; border: 1.5px solid var(--neutral-300); border-radius: 8px; width: 100%; }
        .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--neutral-400); }
        .form-control, .form-select { border: 1.5px solid var(--neutral-300); border-radius: 8px; padding: 10px 13px; font-size: 14px; }
        .form-control:focus, .form-select:focus { border-color: var(--color-primary); box-shadow: 0 0 0 3px rgba(90,129,250,.1); }
        .badge-benefit, .badge-penerima, .badge-tersedia { background: var(--color-cyan-glow); color: #1E40AF; border-radius: 20px; padding: 4px 10px; font-size: 12px; font-weight: 700; }
        .badge-cost, .badge-tidak-penerima, .badge-tidak-tersedia { background: var(--color-pink-glow); color: #9D174D; border-radius: 20px; padding: 4px 10px; font-size: 12px; font-weight: 700; }
        .rank-badge-1 { background: linear-gradient(135deg,#FFD700,#FFA500); color: #fff; width: 30px; height: 30px; border-radius: 50%; display: inline-grid; place-items: center; font-weight: 800; }
.rank-badge-2 { background: linear-gradient(135deg,#C0C0C0,#A8A8A8); color: #fff; width: 30px; height: 30px; border-radius: 50%; display: inline-grid; place-items: center; font-weight: 800; }
.rank-badge-3 { background: linear-gradient(135deg,#CD7F32,#B86B2D); color: #fff; width: 30px; height: 30px; border-radius: 50%; display: inline-grid; place-items: center; font-weight: 800; }
        .modal-spk .modal-content { border: 0; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,.15); background-color: #ffffff; }
        .modal-spk .modal-header { background: var(--color-primary-glow); border-bottom: 1px solid var(--color-primary-tint); }
        .step-list { list-style: none; padding: 0; margin: 0; }
        .step-item { display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid var(--neutral-200); }
        .step-number { width: 26px; height: 26px; background: var(--color-primary-glow); color: var(--color-primary); border-radius: 50%; display: grid; place-items: center; font-weight: 800; font-size: 12px; }
        
        /* Password Toggle */
        .password-group { position: relative; }
        .btn-toggle-password {
            position: absolute;
            right: 12px;
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
        .btn-toggle-password:hover { color: var(--color-primary); }

        /* Pagination SPK */
        .pagination-spk { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; list-style: none; padding: 0; margin: 0; }
        .pagination-spk li a, .pagination-spk li span { 
            display: grid; place-items: center; width: 38px; height: 38px; 
            border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 14px;
            transition: all 0.2s ease; background: #fff; color: var(--neutral-600);
            border: 1.5px solid var(--neutral-200);
        }
        .pagination-spk li a:hover { background: var(--color-primary-glow); color: var(--color-primary); border-color: var(--color-primary); }
        .pagination-spk li.active span { background: var(--color-primary); color: #fff; border-color: var(--color-primary); box-shadow: 0 4px 10px rgba(70, 105, 214, 0.25); }
        .pagination-spk li.disabled span { opacity: 0.5; cursor: not-allowed; }

        /* Global Responsiveness */
        /* Select2 Modal Fix */
        .select2-container--open { z-index: 9999 !important; }

        @media (max-width: 992px) { 
            .sidebar { 
                width: clamp(248px, 64vw, 272px);
                max-width: calc(100vw - 72px);
                height: 100vh !important;
                height: 100dvh !important;
                min-height: 100svh;
                padding: 18px 0 0;
                overflow: hidden;
                transform: translateX(-105%);
                box-shadow: none;
            }
            .sidebar.show {
                transform: translateX(0);
                box-shadow: 14px 0 36px rgba(17, 24, 39, 0.22);
            }
            .sidebar-brand { flex: 0 0 auto; padding: 0 18px 18px; margin-bottom: 4px; }
            .sidebar-brand img { max-width: 100%; height: 41px; }
            .sidebar-menu {
                flex: 1 1 auto;
                gap: 3px;
                min-height: 0;
                overflow-y: auto;
                overscroll-behavior: contain;
                padding-left: 10px;
                padding-right: 0;
            }
            .sidebar-menu-item {
                gap: 10px;
                min-height: 42px;
                margin-right: 10px;
                padding: 10px 16px;
                border-radius: 22px;
                font-size: 14.25px;
                line-height: 1.25;
            }
            .sidebar-menu-item i {
                flex: 0 0 20px;
                text-align: center;
                font-size: 17px;
            }
            .sidebar-footer {
                flex: 0 0 auto;
                margin-top: 0;
                padding: 8px 10px max(10px, env(safe-area-inset-bottom));
                background: #4669D6;
            }
            .sidebar-footer .sidebar-menu-item { margin-right: 0; }
            .content-area { margin-left: 0; }
            .topbar { padding: 0 18px; }
            .page-content { padding: 18px; }
            .card-spk { padding: 18px; }
            .table-responsive {
                margin-inline: -2px;
                max-width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .table-spk { min-width: 720px; }
        }

        @media (min-width: 993px) { 
            .sidebar { transform: translateX(0); }
            .sidebar-overlay { display: none; }
        }

        @media (max-width: 576px) { 
            .sidebar {
                width: clamp(236px, 68vw, 260px);
                max-width: calc(100vw - 72px);
                padding-top: 14px;
            }
            .sidebar-brand { padding: 0 16px 16px; }
            .sidebar-brand img { height: 39px; }
            .sidebar-menu { gap: 2px; padding-left: 8px; }
            .sidebar-menu-item {
                min-height: 40px;
                padding: 9px 14px;
                font-size: 13.75px;
            }
            .topbar {
                height: auto;
                min-height: var(--header-height);
                padding: 10px 14px;
                gap: 12px;
            }
            .topbar > .d-flex:first-child { min-width: 0; }
            .topbar .fw-bold { overflow-wrap: anywhere; }
            .page-content { padding: 14px; }
            .page-title { font-size: 19px; margin-bottom: 14px; }
            .card-spk { padding: 14px; border-radius: var(--border-radius-sm); }
            .stats-card { padding: 16px; }
            .stats-value { font-size: 24px; }
            .modal-content { border-radius: 0 !important; }
            .btn-spk-primary, .btn-spk-outline { width: 100%; justify-content: center; margin-bottom: 8px; }
            .table-spk { font-size: 12px; min-width: 680px; }
            .table-spk thead th, .table-spk tbody td { padding: 8px; }
            .pagination-spk li a, .pagination-spk li span {
                width: 34px;
                height: 34px;
                border-radius: 8px;
                font-size: 12px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebar-overlay"></div>
    @include('partials.sidebar')
    <div class="content-area">
        @include('partials.header')
        <main class="page-content">
            @include('partials.breadcrumb')
            <h1 class="page-title">@yield('title')</h1>
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        const SwalSpk = Swal.mixin({ confirmButtonColor: '#4669D6', cancelButtonColor: '#A0AEC0' });
        $('.select2').select2({ width: '100%', dropdownParent: $('.modal.show').length ? $('.modal.show') : $(document.body) });
        
        // Logout Confirmation
        const logoutForm = document.getElementById('logout-form');
        if (logoutForm) {
            logoutForm.addEventListener('submit', (event) => {
                event.preventDefault();
                SwalSpk.fire({
                    title: 'Keluar Akun?',
                    text: 'Anda akan mengakhiri sesi pengerjaan ini.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) logoutForm.submit();
                });
            });
        }

        document.querySelectorAll('[data-confirm-delete]').forEach((form) => {
            form.addEventListener('submit', (event) => {
                event.preventDefault();
                SwalSpk.fire({ title: 'Hapus Data?', text: 'Data yang dihapus tidak dapat dikembalikan.', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal' }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
        @if(session('success'))
            SwalSpk.fire({ icon: 'success', title: 'Berhasil', text: @json(session('success')), timer: 2200, showConfirmButton: false });
        @endif
        @if($errors->any())
            SwalSpk.fire({ icon: 'error', title: 'Periksa Data', html: @json($errors->first()) });
        @endif

        // Global Password Toggle Logic
        $(document).on('click', '.btn-toggle-password', function() {
            const targetId = $(this).data('target');
            const passwordInput = document.getElementById(targetId);
            const icon = $(this).find('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

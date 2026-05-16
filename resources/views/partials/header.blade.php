<header class="topbar">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-primary d-lg-none" id="sidebar-toggle" type="button" aria-controls="app-sidebar" aria-expanded="false" aria-label="Buka menu navigasi">
            <i class="bi bi-list"></i>
        </button>
        <div>
            <div class="fw-bold text-dark">@yield('title', 'Dashboard')</div>
            <div class="text-muted small">Sistem Pendukung Keputusan KIP-K</div>
        </div>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle d-grid place-items-center fw-bold" style="width:36px;height:36px;background:var(--color-primary-tint);color:var(--color-primary);place-items:center">{{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'U', 0, 1)) }}</div>
            <div class="d-none d-md-block">
                <div class="fw-bold small">{{ auth()->user()->nama_lengkap ?? '-' }}</div>
                <div class="text-muted small text-capitalize">{{ auth()->user()->role ?? '-' }}</div>
            </div>
        </div>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if (sidebarToggle && sidebar && overlay) {
            const openSidebar = () => {
                sidebar.classList.add('show');
                overlay.classList.add('show');
                document.body.classList.add('sidebar-open');
                sidebarToggle.setAttribute('aria-expanded', 'true');
                sidebarToggle.setAttribute('aria-label', 'Tutup menu navigasi');
            };

            const closeSidebar = () => {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.classList.remove('sidebar-open');
                sidebarToggle.setAttribute('aria-expanded', 'false');
                sidebarToggle.setAttribute('aria-label', 'Buka menu navigasi');
            };

            sidebarToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                if (sidebar.classList.contains('show')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            overlay.addEventListener('click', closeSidebar);

            sidebar.querySelectorAll('a.sidebar-menu-item').forEach((link) => {
                link.addEventListener('click', closeSidebar);
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeSidebar();
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 993) closeSidebar();
            });
        }
    });
</script>

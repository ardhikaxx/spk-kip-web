<header class="topbar">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-primary d-lg-none" id="sidebar-toggle"><i class="bi bi-list"></i></button>
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
            sidebarToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar.classList.add('show');
                overlay.classList.add('show');
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }
    });
</script>

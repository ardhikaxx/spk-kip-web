<header class="topbar">
    <div>
        <div class="fw-bold text-dark">@yield('title', 'Dashboard')</div>
        <div class="text-muted small">Sistem Pendukung Keputusan KIP-K</div>
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

@php($role = auth()->user()->role ?? null)
<aside class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('assets/logo-spk-kip.png') }}" alt="SPK KIP-K">
    </div>
    <nav class="sidebar-menu">
        @if($role === 'admin')
            <a class="sidebar-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-graph-up"></i> Dashboard</a>
            <a class="sidebar-menu-item {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}" href="{{ route('mahasiswa.index') }}"><i class="bi bi-person-vcard"></i> Data Mahasiswa</a>
            <a class="sidebar-menu-item {{ request()->routeIs('kriteria.*') ? 'active' : '' }}" href="{{ route('kriteria.index') }}"><i class="bi bi-file-earmark-text"></i> Data Kriteria</a>
            <a class="sidebar-menu-item {{ request()->routeIs('sub-kriteria.*') ? 'active' : '' }}" href="{{ route('sub-kriteria.index') }}"><i class="bi bi-folder2-open"></i> Data Subkriteria</a>
            <a class="sidebar-menu-item {{ request()->routeIs('bobot.*') ? 'active' : '' }}" href="{{ route('bobot.index') }}"><i class="bi bi-gear"></i> Pengaturan Bobot</a>
            <a class="sidebar-menu-item {{ request()->routeIs('alternatif.*') ? 'active' : '' }}" href="{{ route('alternatif.index') }}"><i class="bi bi-file-earmark-spreadsheet"></i> Kelola Alternatif</a>
            <a class="sidebar-menu-item {{ request()->routeIs('promethee.*') ? 'active' : '' }}" href="{{ route('promethee.index') }}"><i class="bi bi-calculator"></i> Hitung Promethee</a>
            <a class="sidebar-menu-item {{ request()->routeIs('hasil.*') ? 'active' : '' }}" href="{{ route('hasil.index') }}"><i class="bi bi-list-stars"></i> Hasil Seleksi</a>
            <a class="sidebar-menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}"><i class="bi bi-person-gear"></i> Manajemen Pengguna</a>
        @else
            <a class="sidebar-menu-item {{ request()->routeIs('kaprodi.dashboard') ? 'active' : '' }}" href="{{ route('kaprodi.dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a>
        @endif
    </nav>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button class="sidebar-menu-item w-100 border-0" style="background:transparent" type="submit">
                <i class="bi bi-box-arrow-right"></i> Keluar dari akun
            </button>
        </form>
    </div>
</aside>

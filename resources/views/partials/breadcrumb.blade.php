<nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ auth()->user()?->role === 'admin' ? route('admin.dashboard') : route('kaprodi.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">@yield('title')</li>
    </ol>
</nav>

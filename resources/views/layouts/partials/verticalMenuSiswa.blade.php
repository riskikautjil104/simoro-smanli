@php
    $active = fn($route) => request()->is($route) ? 'active' : '';
@endphp
<aside class="d-flex flex-column h-100 p-3 bg-white sidebar shadow-sm">
    <div class="mb-4 d-flex align-items-center">
        <span class="fs-3 fw-bold text-primary me-2">S</span>
        <span class="fs-5 fw-bold">IMORO</span>
    </div>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-2"><a class="nav-link {{ $active('siswa/dashboard') }}" href="/siswa/dashboard"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
        <li class="nav-item mb-2"><a class="nav-link {{ $active('siswa/ujian/aktif') }}" href="/siswa/ujian/aktif"><i class="bi bi-clipboard-check me-2"></i> Ujian Aktif</a></li>
        <li class="nav-item mb-2"><a class="nav-link {{ $active('siswa/ujian/riwayat') }}" href="/siswa/ujian/riwayat"><i class="bi bi-clock-history me-2"></i> Riwayat Ujian</a></li>
        <li class="nav-item mb-2"><a class="nav-link {{ $active('profile') }}" href="/profile"><i class="bi bi-person-circle me-2"></i> Profil</a></li>
    </ul>
</aside>

@php
    $active = fn($route) => request()->is($route) ? 'active' : '';
@endphp
<aside class="d-flex flex-column h-100 p-3 bg-white sidebar shadow-sm">
    <div class="mb-4 d-flex align-items-center">
        <span class="fs-3 fw-bold text-primary me-2">S</span>
        <span class="fs-5 fw-bold">IMORO</span>
    </div>
    <ul class="nav nav-pills flex-column mb-auto">

        <li class="nav-item mb-2"><a class="nav-link {{ $active('dashboard') }}" href="/dashboard"><i
                    class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
        <li class="nav-item mb-2"><a class="nav-link {{ $active('admin/siswa*') }}" href="/admin/siswa"><i
                    class="bi bi-people me-2"></i> Data Siswa</a></li>
        <li class="nav-item mb-2"><a class="nav-link {{ $active('admin/guru*') }}" href="/admin/guru"><i
                    class="bi bi-person-badge me-2"></i> Data Guru</a></li>
        <li class="nav-item mb-2"><a class="nav-link {{ $active('admin/kelas*') }}" href="/admin/kelas"><i
                    class="bi bi-building me-2"></i> Data Kelas</a></li>
        <li class="nav-item mb-2"><a class="nav-link {{ $active('admin/mapel*') }}" href="/admin/mapel"><i
                    class="bi bi-journal-bookmark me-2"></i> Data Mapel</a></li>
        <li class="nav-item mb-2"><a class="nav-link {{ $active('admin/ujian*') }}" href="/admin/ujian"><i
                    class="bi bi-file-earmark-text me-2"></i> Data Ujian</a></li>
        <li class="nav-item mb-2"><a class="nav-link {{ $active('admin/soal*') }}" href="/admin/soal"><i
                    class="bi bi-question-circle me-2"></i> Data Soal</a></li>
        <li class="nav-item mb-2"><a class="nav-link {{ $active('admin/monitoring*') }}" href="/admin/monitoring"><i
                    class="bi bi-tv me-2"></i> Monitoring Ujian</a></li>
        <li class="nav-item mb-2"><a class="nav-link {{ $active('admin/laporan*') }}" href="/admin/laporan"><i
                    class="bi bi-bar-chart me-2"></i> Laporan Hasil</a></li>
        <li class="nav-item mb-2"><a class="nav-link {{ $active('profile') }}" href="/profile"><i
                    class="bi bi-person-circle me-2"></i> Edit Profile</a></li>
        <li class="nav-item mb-2"><a class="nav-link {{ $active('admin/ttd*') }}" href="/admin/ttd"><i
                    class="bi bi-pencil me-2"></i> TTD Admin</a></li>
    </ul>
</aside>

{{-- @php
    $route = request()->route();
@endphp
<aside class="sidebar bg-white shadow-sm">
    <div class="sidebar-header text-center py-4">
        <h5 class="mb-0">Guru Panel</h5>
        <div class="small text-muted">SMA5 CBT</div>
    </div>
    <ul class="nav flex-column sidebar-menu">
        <li class="nav-item mb-1">
            <a href="{{ route('guru.dashboard') }}" class="nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('guru.mapel') }}" class="nav-link {{ request()->routeIs('guru.mapel') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark me-2"></i> Mata Pelajaran Saya
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('guru.soal') }}" class="nav-link {{ request()->routeIs('guru.soal') ? 'active' : '' }}">
                <i class="bi bi-archive me-2"></i> Bank Soal
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('guru.soal.batch') }}" class="nav-link {{ request()->routeIs('guru.soal.batch') ? 'active' : '' }}">
                <i class="bi bi-list-ol me-2"></i> Tambah Soal Batch
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('guru.soal.create') }}" class="nav-link {{ request()->routeIs('guru.soal.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle me-2"></i> Tambah Soal
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('guru.ujian') }}" class="nav-link {{ request()->routeIs('guru.ujian') ? 'active' : '' }}">
                <i class="bi bi-clipboard-plus me-2"></i> Buat Ujian
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('guru.ujian.create') }}" class="nav-link {{ request()->routeIs('guru.ujian.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle me-2"></i> Tambah Ujian
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('guru.periksa') }}" class="nav-link {{ request()->routeIs('guru.periksa') ? 'active' : '' }}">
                <i class="bi bi-check2-square me-2"></i> Periksa Jawaban
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('guru.monitoring') }}" class="nav-link {{ request()->routeIs('guru.monitoring') ? 'active' : '' }}">
                <i class="bi bi-activity me-2"></i> Monitoring
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('guru.hasil') }}" class="nav-link {{ request()->routeIs('guru.hasil') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line me-2"></i> Hasil Ujian
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('guru.ttd.edit') }}" class="nav-link {{ request()->routeIs('guru.ttd.edit') ? 'active' : '' }}">
                <i class="bi bi-pencil me-2"></i> Tanda Tangan Digital
            </a>
        </li>
    </ul>
</aside> --}}
@php
    $route = request()->route();
@endphp
<div class="sidebar-wrapper h-100">
    <div class="sidebar-header text-center py-3 border-bottom">
        <div class="sidebar-logo mb-2">
            <img src="{{ asset('assets/img/icon.png') }}" alt="Logo" height="40">
        </div>
        <h5 class="mb-0 fw-bold">Guru Panel</h5>
        <div class="small text-muted">SMA5 CBT</div>
    </div>
    
    <div class="sidebar-body">
        <ul class="nav flex-column sidebar-menu">
            <li class="nav-item">
                <a href="{{ route('guru.dashboard') }}" class="nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('guru.mapel') }}" class="nav-link {{ request()->routeIs('guru.mapel') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark"></i>
                    <span>Mata Pelajaran</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('guru.soal') }}" class="nav-link {{ request()->routeIs('guru.soal') ? 'active' : '' }}">
                    <i class="bi bi-archive"></i>
                    <span>Bank Soal</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('guru.soal.batch') }}" class="nav-link {{ request()->routeIs('guru.soal.batch') ? 'active' : '' }}">
                    <i class="bi bi-list-ol"></i>
                    <span>Tambah Soal Batch</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('guru.soal.create') }}" class="nav-link {{ request()->routeIs('guru.soal.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i>
                    <span>Tambah Soal</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('guru.ujian') }}" class="nav-link {{ request()->routeIs('guru.ujian') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-plus"></i>
                    <span>Buat Ujian</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('guru.ujian.create') }}" class="nav-link {{ request()->routeIs('guru.ujian.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i>
                    <span>Tambah Ujian</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('guru.periksa') }}" class="nav-link {{ request()->routeIs('guru.periksa') ? 'active' : '' }}">
                    <i class="bi bi-check2-square"></i>
                    <span>Periksa Jawaban</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('guru.monitoring') }}" class="nav-link {{ request()->routeIs('guru.monitoring') ? 'active' : '' }}">
                    <i class="bi bi-activity"></i>
                    <span>Monitoring</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('guru.hasil') }}" class="nav-link {{ request()->routeIs('guru.hasil') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Hasil Ujian</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('guru.ttd.edit') }}" class="nav-link {{ request()->routeIs('guru.ttd.edit') ? 'active' : '' }}">
                    <i class="bi bi-pencil"></i>
                    <span>Tanda Tangan Digital</span>
                </a>
            </li>
        </ul>
    </div>
</div>
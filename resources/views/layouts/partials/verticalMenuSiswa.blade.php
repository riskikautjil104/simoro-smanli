@php
    $active = fn($route) => request()->is($route) ? 'active' : '';
@endphp

<aside class="sidebar d-flex flex-column h-100">

    {{-- SVG Swirl Background --}}
    <div class="sidebar-swirl" aria-hidden="true">
        <svg width="100%" height="100%" viewBox="0 0 260 800" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="200" cy="120" rx="180" ry="180" fill="rgba(255,255,255,0.045)"/>
            <ellipse cx="30"  cy="400" rx="140" ry="140" fill="rgba(255,255,255,0.03)"/>
            <ellipse cx="220" cy="650" rx="120" ry="120" fill="rgba(255,255,255,0.04)"/>
            <ellipse cx="80"  cy="760" rx="90"  ry="90"  fill="rgba(13,202,240,0.07)"/>
            <ellipse cx="180" cy="300" rx="60"  ry="60"  fill="rgba(13,202,240,0.05)"/>
        </svg>
    </div>

    {{-- Header --}}
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <img src="{{ asset('assets/frondend/img/logo.png') }}"
                 alt="Logo"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
            <div class="sidebar-logo-fallback" style="display:none;">S</div>
        </div>
        <div class="sidebar-brand">
            <div class="sidebar-brand-name">SIMORO</div>
            <div class="sidebar-brand-sub">Panel Siswa</div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="sidebar-nav flex-grow-1">

        <div class="sidebar-section-title">Menu Utama</div>

        <a href="/siswa/dashboard"
           class="sidebar-link {{ $active('siswa/dashboard') }}">
            <span class="sidebar-link-icon"><i class="bi bi-speedometer2"></i></span>
            <span class="sidebar-link-label">Dashboard</span>
        </a>

        <div class="sidebar-section-title">Ujian</div>

        <a href="/siswa/ujian/aktif"
           class="sidebar-link {{ $active('siswa/ujian/aktif') }}">
            <span class="sidebar-link-icon"><i class="bi bi-clipboard-check"></i></span>
            <span class="sidebar-link-label">Ujian Aktif</span>
        </a>

        <a href="/siswa/ujian/riwayat"
           class="sidebar-link {{ $active('siswa/ujian/riwayat') }}">
            <span class="sidebar-link-icon"><i class="bi bi-clock-history"></i></span>
            <span class="sidebar-link-label">Riwayat Ujian</span>
        </a>

        <div class="sidebar-section-title">Akun</div>

        <a href="/profile"
           class="sidebar-link {{ $active('profile') }}">
            <span class="sidebar-link-icon"><i class="bi bi-person-circle"></i></span>
            <span class="sidebar-link-label">Profil Saya</span>
        </a>

    </nav>

    {{-- Footer user card --}}
    <div class="sidebar-footer">
        <div class="sidebar-user-card">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ auth()->user()->name ?? 'Siswa' }}</div>
                <div class="sidebar-user-role">Siswa</div>
            </div>
        </div>
        <form id="siswa-sidebar-logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="sidebar-logout-btn">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>

</aside>

<style>
/* ── Sidebar core ── */
.sidebar {
    width: 260px;
    background: linear-gradient(160deg, #0d6efd 0%, #0a58ca 55%, #0dcaf0 100%);
    position: relative;
    overflow: hidden;
    border-right: none !important;
    flex-shrink: 0;
}

.sidebar-swirl {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 0;
}

/* ── Header ── */
.sidebar-header {
    position: relative; z-index: 2;
    display: flex; align-items: center; gap: 12px;
    padding: 22px 20px 18px;
    border-bottom: 1px solid rgba(255,255,255,0.12);
    background: linear-gradient(135deg, rgba(255,255,255,0.12), rgba(255,255,255,0.04));
}

.sidebar-logo {
    width: 40px; height: 40px; border-radius: 10px;
    background: rgba(255,255,255,0.2);
    border: 1.5px solid rgba(255,255,255,0.35);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; flex-shrink: 0;
}
.sidebar-logo img { width: 100%; height: 100%; object-fit: cover; }
.sidebar-logo-fallback {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 800; font-size: 1.1rem;
}

.sidebar-brand-name { font-size: 1rem; font-weight: 800; color: #fff; line-height: 1.2; letter-spacing: 0.5px; }
.sidebar-brand-sub  { font-size: 0.7rem; font-weight: 500; color: rgba(255,255,255,0.65); margin-top: 1px; }

/* ── Nav ── */
.sidebar-nav {
    position: relative; z-index: 2;
    padding: 14px 12px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,0.15) transparent;
}
.sidebar-nav::-webkit-scrollbar { width: 4px; }
.sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 4px; }

.sidebar-section-title {
    font-size: 0.62rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 1px;
    color: rgba(255,255,255,0.5);
    padding: 10px 10px 4px;
    margin-top: 4px;
}

.sidebar-link {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border-radius: 10px;
    text-decoration: none;
    color: rgba(255,255,255,0.78);
    font-size: 0.85rem; font-weight: 500;
    margin-bottom: 3px;
    transition: all 0.18s ease;
    position: relative;
}
.sidebar-link:hover {
    background: rgba(255,255,255,0.12);
    color: #fff;
    transform: translateX(3px);
}
.sidebar-link.active {
    background: linear-gradient(135deg, rgba(255,255,255,0.22), rgba(255,255,255,0.12));
    color: #fff;
    font-weight: 700;
    box-shadow: 0 2px 10px rgba(0,0,0,0.12);
}
.sidebar-link.active::after {
    content: '';
    position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
    width: 6px; height: 6px; border-radius: 50%;
    background: #fff;
    box-shadow: 0 0 6px rgba(255,255,255,0.6);
}

.sidebar-link-icon {
    width: 28px; height: 28px; border-radius: 7px;
    background: rgba(255,255,255,0.1);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem; flex-shrink: 0;
    transition: background 0.18s;
}
.sidebar-link:hover .sidebar-link-icon,
.sidebar-link.active .sidebar-link-icon {
    background: rgba(255,255,255,0.22);
}

/* ── Footer ── */
.sidebar-footer {
    position: relative; z-index: 2;
    padding: 12px 14px 16px;
    border-top: 1px solid rgba(255,255,255,0.12);
    background: rgba(0,0,0,0.08);
}

.sidebar-user-card {
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 10px;
}

.sidebar-user-avatar {
    width: 34px; height: 34px; border-radius: 9px;
    background: rgba(255,255,255,0.22);
    border: 1.5px solid rgba(255,255,255,0.35);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 800; font-size: 0.85rem;
    flex-shrink: 0;
}

.sidebar-user-name { font-size: 0.82rem; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px; }
.sidebar-user-role { font-size: 0.68rem; color: rgba(255,255,255,0.55); font-weight: 500; }

.sidebar-logout-btn {
    width: 100%; padding: 8px 14px; border-radius: 9px;
    border: 1.5px solid rgba(255,255,255,0.25);
    background: rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.8);
    font-size: 0.78rem; font-weight: 600;
    cursor: pointer; transition: all 0.18s;
    font-family: 'Poppins', sans-serif;
    display: flex; align-items: center; justify-content: center; gap: 5px;
}
.sidebar-logout-btn:hover {
    background: rgba(220,53,69,0.35);
    border-color: rgba(220,53,69,0.5);
    color: #fff;
    transform: translateY(-1px);
}
</style>
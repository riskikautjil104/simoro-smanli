{{-- @php
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
</aside> --}}
@php
    $active = fn($route) => request()->is($route) ? 'active' : '';
@endphp

<aside class="sidebar-swirl">

  {{-- SVG Swirl Background — disederhanakan, warna diselaraskan --}}
  <svg class="swirl-bg" viewBox="0 0 268 900" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
    <rect width="268" height="900" fill="#f0f4ff"/>

    {{-- Large waves --}}
    <g fill="none" stroke="#0d6efd" stroke-width="14" stroke-linecap="round" opacity="0.07">
      <path d="M-30 80  C60 30,  140 110, 220 70  C270 45,  300 85,  340 70"/>
      <path d="M-20 220 C65 175, 148 248, 228 210 C278 185, 308 222, 345 210"/>
      <path d="M-30 360 C62 315, 145 388, 225 350 C275 325, 305 362, 342 350"/>
      <path d="M-20 500 C65 455, 148 528, 228 490 C278 465, 308 502, 345 490"/>
      <path d="M-30 640 C62 595, 145 668, 225 630 C275 605, 305 642, 342 630"/>
      <path d="M-20 780 C65 735, 148 808, 228 770 C278 745, 308 782, 345 770"/>
    </g>

    {{-- Medium waves --}}
    <g fill="none" stroke="#0dcaf0" stroke-width="7" stroke-linecap="round" opacity="0.12">
      <path d="M10 35  C65 12,  118 48,  175 28  C222 12,  258 35,  290 20"/>
      <path d="M5  150 C62 128, 115 163, 172 143 C220 127, 256 150, 288 135"/>
      <path d="M10 265 C65 243, 118 278, 175 258 C222 242, 258 265, 290 250"/>
      <path d="M5  380 C62 358, 115 393, 172 373 C220 357, 256 380, 288 365"/>
      <path d="M10 495 C65 473, 118 508, 175 488 C222 472, 258 495, 290 480"/>
      <path d="M5  610 C62 588, 115 623, 172 603 C220 587, 256 610, 288 595"/>
      <path d="M10 725 C65 703, 118 738, 175 718 C222 702, 258 725, 290 710"/>
      <path d="M5  840 C62 818, 115 853, 172 833 C220 817, 256 840, 288 825"/>
    </g>

    {{-- Accent blobs --}}
    <g opacity="0.06">
      <ellipse cx="50"  cy="140" rx="55" ry="38" fill="#0d6efd" transform="rotate(-15 50 140)"/>
      <ellipse cx="205" cy="310" rx="50" ry="34" fill="#0dcaf0" transform="rotate(12 205 310)"/>
      <ellipse cx="60"  cy="500" rx="48" ry="32" fill="#0d6efd" transform="rotate(-10 60 500)"/>
      <ellipse cx="195" cy="670" rx="52" ry="36" fill="#0dcaf0" transform="rotate(14 195 670)"/>
      <ellipse cx="55"  cy="830" rx="46" ry="30" fill="#0d6efd" transform="rotate(-8 55 830)"/>
    </g>
  </svg>

  {{-- Header --}}
  <div class="swirl-header">
    <div class="swirl-logo">
      <img src="{{ asset('assets/frondend/assets/img/logo.png') }}" alt="Logo"
           onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
      <span style="display:none;color:white;font-weight:800;font-size:1.2rem;">S</span>
    </div>
    <div class="swirl-logo-text">
      <h5>SIMORO SMANLI</h5>
      <small>SMA Negeri 5 Morotai</small>
    </div>
  </div>

  {{-- Nav Body --}}
  <div class="swirl-body">

    <span class="swirl-section-label">Main Menu</span>
    <ul class="swirl-nav">
      <li>
        <a class="swirl-link {{ $active('dashboard') }}" href="/dashboard">
          <i class="bi bi-speedometer2"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li>
        <a class="swirl-link {{ $active('admin/siswa*') }}" href="/admin/siswa">
          <i class="bi bi-people"></i>
          <span>Data Siswa</span>
        </a>
      </li>
      <li>
        <a class="swirl-link {{ $active('admin/guru*') }}" href="/admin/guru">
          <i class="bi bi-person-badge"></i>
          <span>Data Guru</span>
        </a>
      </li>
      <li>
        <a class="swirl-link {{ $active('admin/kelas*') }}" href="/admin/kelas">
          <i class="bi bi-building"></i>
          <span>Data Kelas</span>
        </a>
      </li>
      <li>
        <a class="swirl-link {{ $active('admin/mapel*') }}" href="/admin/mapel">
          <i class="bi bi-journal-bookmark"></i>
          <span>Data Mapel</span>
        </a>
      </li>
    </ul>

    <div class="swirl-divider"></div>
    <span class="swirl-section-label">Ujian</span>
    <ul class="swirl-nav">
      <li>
        <a class="swirl-link {{ $active('admin/ujian*') }}" href="/admin/ujian">
          <i class="bi bi-file-earmark-text"></i>
          <span>Data Ujian</span>
        </a>
      </li>
      <li>
        <a class="swirl-link {{ $active('admin/soal*') }}" href="/admin/soal">
          <i class="bi bi-question-circle"></i>
          <span>Data Soal</span>
        </a>
      </li>
      <li>
        <a class="swirl-link {{ $active('admin/monitoring*') }}" href="/admin/monitoring">
          <i class="bi bi-tv"></i>
          <span>Monitoring Ujian</span>
        </a>
      </li>
      <li>
        <a class="swirl-link {{ $active('admin/laporan*') }}" href="/admin/laporan">
          <i class="bi bi-bar-chart"></i>
          <span>Laporan Hasil</span>
        </a>
      </li>
    </ul>

    <div class="swirl-divider"></div>
    <span class="swirl-section-label">Akun</span>
    <ul class="swirl-nav">
      <li>
        <a class="swirl-link {{ $active('profile') }}" href="/profile">
          <i class="bi bi-person-circle"></i>
          <span>Edit Profile</span>
        </a>
      </li>
      <li>
        <a class="swirl-link {{ $active('admin/ttd*') }}" href="/admin/ttd">
          <i class="bi bi-vector-pen"></i>
          <span>TTD Admin</span>
        </a>
      </li>
    </ul>

  </div>

  {{-- Footer user card --}}
  <div class="swirl-footer">
    <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form">
      @csrf
    </form>
    <a href="/profile" class="swirl-user-card">
      <div class="swirl-avatar">
        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
      </div>
      <div class="swirl-user-info">
        <div class="swirl-user-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
        <div class="swirl-user-role">{{ auth()->user()->role ?? 'admin' }}</div>
      </div>
      <i class="bi bi-chevron-right" style="color:#94a3b8;font-size:0.7rem;flex-shrink:0;"></i>
    </a>
    <button class="swirl-logout-btn"
            onclick="document.getElementById('sidebar-logout-form').submit()">
      <i class="bi bi-box-arrow-left"></i>
      <span>Keluar</span>
    </button>
  </div>

</aside>

<style>
/* =============================================
   SIDEBAR — diselaraskan dengan welcome & login
   Primary: #0d6efd  Accent: #0dcaf0
============================================= */

.swirl-bg {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
}

.sidebar-swirl > *:not(.swirl-bg) {
  position: relative;
  z-index: 1;
}

/* ── Header ── */
.swirl-header {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 18px 16px;
  background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
  box-shadow: 0 4px 20px rgba(13,110,253,0.35);
  flex-shrink: 0;
}

.swirl-logo {
  width: 44px;
  height: 44px;
  background: rgba(255,255,255,0.2);
  border: 1.5px solid rgba(255,255,255,0.35);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  overflow: hidden;
  box-shadow: 0 3px 10px rgba(0,0,0,0.15);
}

.swirl-logo img {
  width: 28px;
  height: 28px;
  object-fit: contain;
  filter: brightness(0) invert(1);
}

.swirl-logo-text h5 {
  font-size: 0.82rem;
  font-weight: 700;
  color: #fff;
  letter-spacing: 0.03em;
  line-height: 1.2;
  margin: 0;
}

.swirl-logo-text small {
  font-size: 0.65rem;
  color: rgba(255,255,255,0.7);
  font-weight: 500;
}

/* ── Body ── */
.swirl-body {
  flex: 1;
  padding: 12px 10px;
  overflow-y: auto;
  scrollbar-width: thin;
  scrollbar-color: rgba(13,110,253,0.2) transparent;
}

.swirl-body::-webkit-scrollbar       { width: 3px; }
.swirl-body::-webkit-scrollbar-thumb { background: rgba(13,110,253,0.2); border-radius: 10px; }

/* Section labels */
.swirl-section-label {
  display: block;
  font-size: 0.6rem;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: #94a3b8;
  padding: 10px 10px 4px;
}

/* Nav list */
.swirl-nav {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 2px;
}

/* Nav link */
.swirl-link {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 12px;
  border-radius: 10px;
  text-decoration: none;
  color: #374151;
  font-size: 0.84rem;
  font-weight: 500;
  border: 1px solid transparent;
  transition: all 0.2s ease;
  position: relative;
}

.swirl-link i {
  font-size: 1.05rem;
  width: 20px;
  text-align: center;
  color: #9ca3af;
  flex-shrink: 0;
  transition: all 0.2s ease;
}

/* Hover */
.swirl-link:hover {
  background: rgba(13,110,253,0.08);
  color: #0d6efd;
  transform: translateX(3px);
  border-color: rgba(13,110,253,0.15);
}

.swirl-link:hover i { color: #0d6efd; }

/* Active */
.swirl-link.active {
  background: linear-gradient(135deg, #0d6efd, #0dcaf0);
  color: #fff !important;
  border-color: transparent;
  box-shadow: 0 4px 16px rgba(13,110,253,0.3);
}

.swirl-link.active i { color: #fff !important; }

/* Active dot indicator */
.swirl-link.active::after {
  content: '';
  position: absolute;
  right: 10px;
  width: 6px; height: 6px;
  background: rgba(255,255,255,0.7);
  border-radius: 50%;
}

/* Divider */
.swirl-divider {
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(13,110,253,0.15), transparent);
  margin: 8px 6px;
}

/* ── Footer ── */
.swirl-footer {
  padding: 12px 14px;
  border-top: 1px solid rgba(13,110,253,0.1);
  background: rgba(240,244,255,0.8);
  backdrop-filter: blur(6px);
  display: flex;
  flex-direction: column;
  gap: 8px;
  flex-shrink: 0;
}

/* User card */
.swirl-user-card {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 12px;
  background: rgba(255,255,255,0.85);
  border-radius: 12px;
  border: 1px solid rgba(13,110,253,0.12);
  text-decoration: none;
  transition: all 0.2s ease;
}

.swirl-user-card:hover {
  background: rgba(13,110,253,0.06);
  border-color: rgba(13,110,253,0.25);
}

/* Avatar */
.swirl-avatar {
  width: 34px;
  height: 34px;
  background: linear-gradient(135deg, #0d6efd, #0dcaf0);
  border-radius: 9px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-weight: 700;
  font-size: 0.78rem;
  flex-shrink: 0;
  box-shadow: 0 3px 10px rgba(13,110,253,0.3);
}

.swirl-user-info  { flex: 1; min-width: 0; }

.swirl-user-name {
  font-size: 0.78rem;
  font-weight: 600;
  color: #1e293b;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.swirl-user-role {
  font-size: 0.65rem;
  color: #64748b;
  font-weight: 500;
  text-transform: capitalize;
}

/* Logout button */
.swirl-logout-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  width: 100%;
  padding: 9px 14px;
  background: transparent;
  border: 1.5px solid rgba(220,53,69,0.25);
  border-radius: 10px;
  color: #dc3545;
  font-size: 0.8rem;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  cursor: pointer;
  transition: all 0.2s ease;
}

.swirl-logout-btn i { font-size: 0.9rem; }

.swirl-logout-btn:hover {
  background: rgba(220,53,69,0.07);
  border-color: rgba(220,53,69,0.45);
  transform: translateY(-1px);
}
</style>
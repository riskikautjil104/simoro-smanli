@php
    $active = fn($route) => request()->routeIs($route) ? 'active' : '';
@endphp

<aside class="sidebar-swirl">

  {{-- SVG Swirl Background --}}
  <svg class="swirl-bg" viewBox="0 0 268 900" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
    <rect width="268" height="900" fill="#f0f4ff"/>
    <g fill="none" stroke="#0d6efd" stroke-width="14" stroke-linecap="round" opacity="0.07">
      <path d="M-30 80  C60 30,  140 110, 220 70  C270 45,  300 85,  340 70"/>
      <path d="M-20 220 C65 175, 148 248, 228 210 C278 185, 308 222, 345 210"/>
      <path d="M-30 360 C62 315, 145 388, 225 350 C275 325, 305 362, 342 350"/>
      <path d="M-20 500 C65 455, 148 528, 228 490 C278 465, 308 502, 345 490"/>
      <path d="M-30 640 C62 595, 145 668, 225 630 C275 605, 305 642, 342 630"/>
    </g>
    <g fill="none" stroke="#0dcaf0" stroke-width="7" stroke-linecap="round" opacity="0.12">
      <path d="M10 35  C65 12,  118 48,  175 28  C222 12,  258 35,  290 20"/>
      <path d="M5  150 C62 128, 115 163, 172 143 C220 127, 256 150, 288 135"/>
      <path d="M10 265 C65 243, 118 278, 175 258 C222 242, 258 265, 290 250"/>
      <path d="M5  380 C62 358, 115 393, 172 373 C220 357, 256 380, 288 365"/>
    </g>
  </svg>

  {{-- Header --}}
  <div class="swirl-header">
    <div class="swirl-logo">
      <img src="{{ asset('assets/img/icon.png') }}" alt="Logo" height="70px" width="70px" 
           onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
      <span style="display:none;color:white;font-weight:800;font-size:1.2rem;">S</span>
    </div>
    <div class="swirl-logo-text">
      <h5>SIMORO SMANLI</h5>
      <small>Panel Kepala Sekolah</small>
    </div>
  </div>

  {{-- Nav Body --}}
  <div class="swirl-body">

    <span class="swirl-section-label">Menu Utama</span>
    <ul class="swirl-nav">
      <li>
        <a class="swirl-link {{ $active('kepala-sekolah.dashboard') }}" href="{{ route('kepala-sekolah.dashboard') }}">
          <i class="bi bi-pie-chart-fill"></i>
          <span>Dashboard Analitik</span>
        </a>
      </li>
    </ul>

    <div class="swirl-divider"></div>
    <span class="swirl-section-label">Pemantauan & Laporan</span>
    <ul class="swirl-nav">
      <li>
        <a class="swirl-link {{ $active('kepala-sekolah.monitoring*') }}" href="{{ route('kepala-sekolah.monitoring') }}">
          <i class="bi bi-tv"></i>
          <span>Monitoring Ujian</span>
        </a>
      </li>
      <li>
        <a class="swirl-link {{ $active('kepala-sekolah.laporan*') }}" href="{{ route('kepala-sekolah.laporan') }}">
          <i class="bi bi-bar-chart-line"></i>
          <span>Rekap Hasil Ujian</span>
        </a>
      </li>
      <li>
        <a class="swirl-link {{ $active('kepala-sekolah.berita-acara*') }}" href="{{ route('kepala-sekolah.berita-acara') }}">
          <i class="bi bi-file-earmark-ruled"></i>
          <span>Berita Acara</span>
        </a>
      </li>
    </ul>

    <div class="swirl-divider"></div>
    <span class="swirl-section-label">Pengaturan Akun</span>
    <ul class="swirl-nav">
      <li>
        <a class="swirl-link {{ $active('kepala-sekolah.ttd*') }}" href="{{ route('kepala-sekolah.ttd.edit') }}">
          <i class="bi bi-vector-pen"></i>
          <span>Tanda Tangan Digital</span>
        </a>
      </li>
      <li>
        <a class="swirl-link {{ $active('profile.edit') }}" href="{{ route('profile.edit') }}">
          <i class="bi bi-person-circle"></i>
          <span>Profil & NIP/NIK</span>
        </a>
      </li>
    </ul>

  </div>

  {{-- Footer --}}
  <div class="swirl-footer">
    <form method="POST" action="{{ route('logout') }}" id="kepsek-sidebar-logout-form">
      @csrf
    </form>
    <a href="{{ route('profile.edit') }}" class="swirl-user-card">
      <div class="swirl-avatar">
        {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 2)) }}
      </div>
      <div class="swirl-user-info">
        <div class="swirl-user-name">{{ auth()->user()->name ?? 'Kepala Sekolah' }}</div>
        <div class="swirl-user-role">Kepala Sekolah</div>
      </div>
      <i class="bi bi-chevron-right" style="color:#94a3b8;font-size:0.7rem;flex-shrink:0;"></i>
    </a>
    <button class="swirl-logout-btn"
            onclick="document.getElementById('kepsek-sidebar-logout-form').submit()">
      <i class="bi bi-box-arrow-left"></i>
      <span>Keluar</span>
    </button>
  </div>

</aside>

<style>
.swirl-bg { position: absolute; inset: 0; width: 100%; height: 100%; z-index: 0; }
.sidebar-swirl > *:not(.swirl-bg) { position: relative; z-index: 1; }
.sidebar-swirl { border-right: none !important; box-shadow: 4px 0 20px rgba(13,110,253,0.08) !important; }
.swirl-header { display: flex; align-items: center; gap: 12px; padding: 18px 16px; background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%); box-shadow: 0 4px 20px rgba(13,110,253,0.35); flex-shrink: 0; }
.swirl-logo { width: 44px; height: 44px; background: rgba(255,255,255,0.2); border: 1.5px solid rgba(255,255,255,0.35); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.15); }
.swirl-logo img { width: 70px; height: 70px; object-fit: contain; filter: brightness(0) invert(1); }
.swirl-logo-text h5 { font-size: 0.82rem; font-weight: 700; color: #fff; letter-spacing: 0.03em; line-height: 1.2; margin: 0; }
.swirl-logo-text small { font-size: 0.65rem; color: rgba(255,255,255,0.7); font-weight: 500; }
.swirl-body { flex: 1; padding: 12px 10px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: rgba(13,110,253,0.2) transparent; }
.swirl-section-label { display: block; font-size: 0.6rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: #94a3b8; padding: 10px 10px 4px; }
.swirl-nav { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 2px; }
.swirl-link { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; text-decoration: none; color: #374151; font-size: 0.84rem; font-weight: 500; border: 1px solid transparent; transition: all 0.2s ease; position: relative; }
.swirl-link i { font-size: 1.05rem; width: 20px; text-align: center; color: #9ca3af; flex-shrink: 0; transition: all 0.2s ease; }
.swirl-link:hover { background: rgba(13,110,253,0.08); color: #0d6efd; transform: translateX(3px); border-color: rgba(13,110,253,0.15); }
.swirl-link:hover i { color: #0d6efd; }
.swirl-link.active { background: linear-gradient(135deg, #0d6efd, #0dcaf0); color: #fff !important; border-color: transparent; box-shadow: 0 4px 16px rgba(13,110,253,0.3); }
.swirl-link.active i { color: #fff !important; }
.swirl-link.active::after { content: ''; position: absolute; right: 10px; width: 6px; height: 6px; background: rgba(255,255,255,0.7); border-radius: 50%; }
.swirl-divider { height: 1px; background: linear-gradient(90deg, transparent, rgba(13,110,253,0.15), transparent); margin: 8px 6px; }
.swirl-footer { padding: 12px 14px; border-top: 1px solid rgba(13,110,253,0.1); background: rgba(240,244,255,0.8); backdrop-filter: blur(6px); display: flex; flex-direction: column; gap: 8px; flex-shrink: 0; }
.swirl-user-card { display: flex; align-items: center; gap: 10px; padding: 10px 12px; background: rgba(255,255,255,0.85); border-radius: 12px; border: 1px solid rgba(13,110,253,0.12); text-decoration: none; transition: all 0.2s ease; }
.swirl-avatar { width: 34px; height: 34px; background: linear-gradient(135deg, #0d6efd, #0dcaf0); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 0.78rem; flex-shrink: 0; box-shadow: 0 3px 10px rgba(13,110,253,0.3); }
.swirl-user-info { flex: 1; min-width: 0; }
.swirl-user-name { font-size: 0.78rem; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.swirl-user-role { font-size: 0.65rem; color: #64748b; font-weight: 500; text-transform: capitalize; }
.swirl-logout-btn { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 9px 14px; background: transparent; border: 1.5px solid rgba(220,53,69,0.25); border-radius: 10px; color: #dc3545; font-size: 0.8rem; font-weight: 600; font-family: 'Poppins', sans-serif; cursor: pointer; transition: all 0.2s ease; }
.swirl-logout-btn:hover { background: rgba(220,53,69,0.07); border-color: rgba(220,53,69,0.45); transform: translateY(-1px); }
</style>

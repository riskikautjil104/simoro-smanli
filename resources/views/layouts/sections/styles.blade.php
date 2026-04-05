<!-- External CSS Libraries -->
<link rel="stylesheet" href="{{asset ('assets/dist/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset ('assets/font/bootstrap-icons.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap">

<style>

:root {
    --primary:        #0d6efd;
    --primary-dark:   #0a58ca;
    --accent:         #0dcaf0;
    --secondary:      #20c997;
    --danger:         #dc3545;
    --bg-page:        #f0f4ff;
    --bg-card:        #ffffff;
    --text-main:      #1a1a2e;
    --text-muted:     #6c757d;
    --border-color:   rgba(13,110,253,0.1);
    --shadow-sm:      0 2px 12px rgba(13,110,253,0.07);
    --shadow-md:      0 6px 24px rgba(13,110,253,0.12);
    --shadow-lg:      0 12px 40px rgba(13,110,253,0.18);
    --radius:         12px;
    --transition:     all 0.3s ease;
}


*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: 'Poppins', sans-serif !important;
    background: var(--bg-page) !important;
    color: var(--text-main);
    overflow-x: hidden;
}

.navbar, .sidebar, .card, .btn, .form-control,
.nav, .offcanvas, .dropdown-menu {
    font-family: 'Poppins', sans-serif !important;
}

.layout-wrapper {
    display: flex;
    min-height: 100vh;
    overflow-x: hidden;
    background: var(--bg-page);
}

.layout-sidebar {
    position: fixed;
    top: 0; left: 0;
    width: 260px;
    height: 100vh;
    background: var(--bg-card);
    border-right: 1px solid var(--border-color);
    z-index: 1000;
    overflow-y: auto;
    transition: var(--transition);
    box-shadow: 2px 0 16px rgba(13,110,253,0.06);
}

.layout-content-wrapper {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    margin-left: 0;
    transition: margin-left 0.3s ease;
    background: var(--bg-page);
}

.layout-navbar {
    position: sticky;
    top: 0;
    z-index: 999;
    background: var(--bg-card);
    box-shadow: var(--shadow-sm);
}

.layout-main {
    flex: 1;
    padding: 2rem;
    overflow-x: hidden;
    background: var(--bg-page);
}

.sidebar-wrapper {
    display: flex;
    flex-direction: column;
    height: 100%;
    background: var(--bg-card);
}

.sidebar-header {
    flex-shrink: 0;
    padding: 1.25rem 1rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    text-align: center;
    box-shadow: 0 4px 20px rgba(13,110,253,0.3);
}

.sidebar-header h5 {
    color: #fff;
    font-weight: 700;
    margin-bottom: 0.2rem;
    font-size: 1rem;
}

.sidebar-header .small {
    color: rgba(255,255,255,0.8);
    font-weight: 500;
    font-size: 0.75rem;
}

.sidebar-logo img {
    filter: brightness(0) invert(1);
    margin-bottom: 0.4rem;
}

.sidebar-body {
    flex: 1;
    overflow-y: auto;
    padding: 1.25rem 0;
    background: var(--bg-card);
    scrollbar-width: thin;
    scrollbar-color: rgba(13,110,253,0.2) transparent;
}

.sidebar-body::-webkit-scrollbar       { width: 3px; }
.sidebar-body::-webkit-scrollbar-thumb { background: rgba(13,110,253,0.2); border-radius: 10px; }

.sidebar-menu {
    padding: 0 0.875rem;
    list-style: none;
}

.sidebar-menu .nav-item { margin-bottom: 3px; }

.sidebar-menu .nav-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    border-radius: var(--radius);
    color: #374151;
    text-decoration: none;
    transition: var(--transition);
    position: relative;
    font-size: 0.875rem;
    font-weight: 500;
    overflow: hidden;
    background: transparent;
    border: 1px solid transparent;
}

.sidebar-menu .nav-link::before {
    content: '';
    position: absolute;
    left: 0; top: 0;
    height: 100%; width: 3px;
    background: linear-gradient(180deg, var(--primary), var(--accent));
    transform: scaleY(0);
    transition: transform 0.25s ease;
    border-radius: 0 3px 3px 0;
}

.sidebar-menu .nav-link:hover::before { transform: scaleY(1); }

.sidebar-menu .nav-link i {
    font-size: 1.1rem;
    margin-right: 0.8rem;
    width: 20px;
    text-align: center;
    color: #9ca3af;
    flex-shrink: 0;
    transition: var(--transition);
}

.sidebar-menu .nav-link:hover {
    background: rgba(13,110,253,0.07);
    color: var(--primary);
    transform: translateX(4px);
    border-color: rgba(13,110,253,0.12);
}

.sidebar-menu .nav-link:hover i {
    color: var(--primary);
    transform: scale(1.1);
}

.sidebar-menu .nav-link.active {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    color: #fff;
    border-color: transparent;
    box-shadow: 0 4px 16px rgba(13,110,253,0.3);
    transform: translateX(4px);
}

.sidebar-menu .nav-link.active i { color: #fff; }

.sidebar-menu .nav-link.active::after {
    content: '';
    position: absolute;
    right: 10px;
    width: 6px; height: 6px;
    background: rgba(255,255,255,0.7);
    border-radius: 50%;
}

.navbar {
    backdrop-filter: blur(12px);
    background: rgba(255,255,255,0.97) !important;
    box-shadow: var(--shadow-sm);
    border-bottom: 1px solid var(--border-color);
    transition: var(--transition);
}

.navbar.scrolled { box-shadow: var(--shadow-md); }

.navbar-brand {
    font-size: 1.2rem;
    font-weight: 700;
    text-decoration: none;
    transition: var(--transition);
}

.navbar-brand img { transition: var(--transition); }
.navbar-brand:hover img { transform: scale(1.06) rotate(4deg); }

.brand-text {
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.navbar-toggler {
    padding: 0.45rem 0.7rem;
    border: 2px solid var(--primary) !important;
    border-radius: 8px;
}

.navbar-toggler:focus { box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.2); }

.mobile-menu-toggle {
    padding: 1rem;
    background: var(--bg-card);
    border-bottom: 1px solid var(--border-color);
}

.mobile-menu-toggle .btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.8rem;
    font-weight: 600;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border: none;
    box-shadow: 0 4px 16px rgba(13,110,253,0.3);
    border-radius: 10px;
}

.mobile-menu-toggle .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(13,110,253,0.4);
}


.offcanvas { width: 280px !important; background: var(--bg-card); }

.offcanvas-header {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    color: #fff;
    padding: 1.25rem 1.5rem;
}

.offcanvas-header .offcanvas-title { font-weight: 700; }

.offcanvas-header .btn-close {
    filter: brightness(0) invert(1);
    opacity: 1;
    transition: transform 0.25s ease;
}

.offcanvas-header .btn-close:hover { transform: rotate(90deg); }
.offcanvas-body { padding: 0; background: var(--bg-card); }


.card {
    transition: var(--transition);
    border: 1px solid var(--border-color);
    background: var(--bg-card);
    box-shadow: var(--shadow-sm);
    border-radius: var(--radius);
    overflow: hidden;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: rgba(13,110,253,0.2);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa, #f0f4ff);
    border-bottom: 1px solid var(--border-color);
    font-weight: 600;
    color: var(--text-main);
}

.card-body { background: var(--bg-card); color: var(--text-main); }


.btn {
    transition: var(--transition);
    position: relative;
    overflow: hidden;
    font-weight: 600;
    border-radius: 8px;
}

.btn::before {
    content: '';
    position: absolute;
    top: 50%; left: 50%;
    width: 0; height: 0;
    border-radius: 50%;
    background: rgba(255,255,255,0.35);
    transform: translate(-50%, -50%);
    transition: width 0.5s, height 0.5s;
}

.btn:active::before { width: 280px; height: 280px; }

.btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border: none;
    box-shadow: 0 4px 14px rgba(13,110,253,0.28);
    color: #fff;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-dark), var(--primary));
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(13,110,253,0.38);
    color: #fff;
}

.btn-primary:active { transform: translateY(0); }

.btn-success {
    background: linear-gradient(135deg, #20c997, #198754);
    border: none;
    box-shadow: 0 4px 14px rgba(32,201,151,0.28);
}

.btn-success:hover {
    background: linear-gradient(135deg, #1aab82, #157347);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(32,201,151,0.38);
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545, #b02a37);
    border: none;
    box-shadow: 0 4px 14px rgba(220,53,69,0.25);
}

.btn-danger:hover {
    background: linear-gradient(135deg, #b02a37, #842029);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220,53,69,0.35);
}

/* =============================================
   FORM CONTROLS
============================================= */
.form-control, .form-select {
    transition: var(--transition);
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.65rem 1rem;
    background: #fff;
    color: var(--text-main);
    font-family: 'Poppins', sans-serif;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(13,110,253,0.12);
    background: #fff;
}

.form-label {
    font-weight: 600;
    color: var(--text-main);
    margin-bottom: 0.4rem;
    font-size: 0.875rem;
}


.page-loader {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 16px;
    z-index: 9999;
    opacity: 1;
    transition: opacity 0.5s ease;
}

.page-loader.fade-out { opacity: 0; pointer-events: none; }

.loader-spinner {
    width: 52px; height: 52px;
    border: 4px solid rgba(255,255,255,0.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: loaderSpin 0.8s linear infinite;
}

.loader-text {
    color: rgba(255,255,255,0.9);
    font-size: 0.85rem;
    font-weight: 500;
    letter-spacing: 0.5px;
}

@keyframes loaderSpin { to { transform: rotate(360deg); } }


.dropdown-menu {
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-md);
    border-radius: var(--radius);
    padding: 0.6rem;
    min-width: 210px;
    animation: dropFade 0.2s ease;
    background: var(--bg-card);
}

@keyframes dropFade {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}

.dropdown-item {
    padding: 0.7rem 1rem;
    border-radius: 8px;
    transition: var(--transition);
    font-weight: 500;
    font-size: 0.875rem;
    color: var(--text-main);
}

.dropdown-item:hover {
    background: rgba(13,110,253,0.07);
    color: var(--primary);
    transform: translateX(4px);
}

.dropdown-item i { font-size: 1rem; margin-right: 0.5rem; }


::-webkit-scrollbar       { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: #f0f4ff; }
::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, var(--primary), var(--accent));
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover { background: var(--primary-dark); }


@media (min-width: 992px) {
    .layout-content-wrapper { margin-left: 260px; }
    .mobile-menu-toggle     { display: none; }
}

@media (min-width: 768px) and (max-width: 991px) {
    .layout-sidebar { width: 220px; }
    .sidebar-menu .nav-link { padding: 0.65rem 0.9rem; font-size: 0.85rem; }
    .layout-main { padding: 1.5rem; }
    .navbar-brand { font-size: 1.05rem; }
}

@media (max-width: 767px) {
    .layout-main  { padding: 1rem; }
    .navbar-brand { font-size: 0.95rem; }
    .card         { margin-bottom: 1rem; }
}

@media (hover: none) and (pointer: coarse) {
    .sidebar-menu .nav-link:active { background: rgba(13,110,253,0.1); transform: scale(0.98); }
    .btn:active { transform: scale(0.97); }
}

body.resizing * { transition: none !important; }

@media print {
    .layout-sidebar, .mobile-menu-toggle, .layout-navbar { display: none !important; }
    .layout-content-wrapper { margin-left: 0 !important; }
    body { background: #fff !important; }
}
</style>

<style>

.layout-footer {
    background: linear-gradient(135deg, #1a1a2e 0%, #111827 100%);
    color: rgba(255,255,255,0.75);
    padding: 3rem 2rem 1.5rem;
    margin-top: auto;
    position: relative;
    overflow: hidden;
}

.layout-footer::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary), var(--accent), var(--primary));
    background-size: 200% 100%;
    animation: footerBorderShift 4s linear infinite;
}

@keyframes footerBorderShift {
    0%   { background-position: 0% 0%; }
    100% { background-position: 200% 0%; }
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto 2rem;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 2rem;
}

/* Brand */
.footer-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.footer-logo {
    filter: brightness(0) invert(1);
    transition: transform 0.4s ease;
}

.footer-brand:hover .footer-logo { transform: rotate(360deg) scale(1.1); }

.footer-brand-text {
    font-size: 1.15rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.footer-tagline {
    color: rgba(255,255,255,0.5);
    font-size: 0.85rem;
    font-weight: 500;
    margin: 0;
}

/* Links */
.footer-links { display: flex; flex-direction: column; gap: 8px; }

.footer-link {
    color: rgba(255,255,255,0.65);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    padding: 6px 8px;
    border-radius: 8px;
    transition: var(--transition);
}

.footer-link i { font-size: 1rem; transition: transform 0.2s ease; }

.footer-link:hover {
    color: var(--accent);
    background: rgba(13,202,240,0.08);
    transform: translateX(4px);
}

.footer-link:hover i { transform: scale(1.15); }

/* Social icons */
.footer-social { display: flex; gap: 10px; margin-bottom: 12px; }

.social-link {
    width: 38px; height: 38px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255,255,255,0.7);
    font-size: 1.1rem;
    text-decoration: none;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.social-link::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    transform: scale(0);
    transition: transform 0.25s ease;
    border-radius: 50%;
}

.social-link i { position: relative; z-index: 1; }

.social-link:hover {
    color: #fff;
    transform: translateY(-4px) scale(1.08);
    box-shadow: 0 8px 20px rgba(13,110,253,0.35);
}

.social-link:hover::before { transform: scale(1); }

.footer-school {
    color: rgba(255,255,255,0.5);
    font-size: 0.875rem;
    font-weight: 600;
    margin: 0;
}

/* Footer bottom bar */
.footer-bottom {
    max-width: 1200px;
    margin: 0 auto;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(255,255,255,0.08);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.footer-copyright,
.footer-tech {
    display: flex;
    align-items: center;
    gap: 6px;
    color: rgba(255,255,255,0.4);
    font-size: 0.82rem;
    font-weight: 500;
}

/* Heartbeat pulse */
.pulse { animation: heartbeat 1.6s ease-in-out infinite; }

@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    15%, 35% { transform: scale(1.3); }
    25%       { transform: scale(1.1); }
}

/* ── Footer responsive ── */
@media (max-width: 991px) {
    .footer-content { grid-template-columns: repeat(2, 1fr); }
    .footer-right   { grid-column: 1 / -1; text-align: center; }
    .footer-social  { justify-content: center; }
}

@media (max-width: 767px) {
    .layout-footer  { padding: 2rem 1rem 1rem; }
    .footer-content { grid-template-columns: 1fr; gap: 1.5rem; }
    .footer-left, .footer-center, .footer-right { text-align: center; }
    .footer-brand   { justify-content: center; }
    .footer-links   { align-items: center; }
    .footer-social  { justify-content: center; }
    .footer-bottom  { flex-direction: column; text-align: center; }
}

@media print { .layout-footer { display: none !important; } }
</style>

@stack('styles')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SIMORO - SMA Negeri 5 Morotai | Portal Pendidikan Pulau Morotai</title>
    <meta name="description" content="SIMORO SMANLI (Sistem Ujian Online) resmi SMA Negeri 5 Morotai. Inovasi pendidikan digital terbaik di Kabupaten Pulau Morotai, Maluku Utara.">
    <meta name="keywords" content="SIMORO, SMANLI, SMA Negeri 5 Morotai, SMA Morotai, SMA di Morotai, Sekolah Morotai, Ujian Online Morotai, Pendidikan Maluku Utara, SMAN 5 Morotai, SMA N 1 Morotai, SMA N 2 Morotai, Portal Sekolah Morotai, ujian online, pendidikan">
    <meta name="author" content="SMA Negeri 5 Morotai">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="SIMORO SMANLI - SMA Negeri 5 Morotai">
    <meta property="og:description" content="Portal resmi Sistem Ujian Online dan Informasi Akademik SMA Negeri 5 Morotai, Maluku Utara.">
    <meta property="og:image" content="{{ asset('assets/frondend/assets/img/og-image.jpg') }}">

    <link href="{{ asset('assets/frondend/assets/img/favicon.svg') }}" rel="icon" type="image/svg+xml">
    <link rel="shortcut icon" href="{{ asset('assets/frondend/assets/img/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/frondend/assets/img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/frondend/assets/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/frondend/assets/img/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/frondend/assets/img/favicon-96x96.png') }}">
    <link rel="manifest" href="{{ asset('assets/frondend/assets/img/site.webmanifest') }}">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/frondend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frondend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frondend/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frondend/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frondend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frondend/assets/css/main.css') }}" rel="stylesheet">

    {{-- =====================================================
         DESAIN V3 — SIMORO SMANLI
         Rombak total: navbar melayang, hero terang, bento
         services, list-card ujian, panel split My Project.
         Palet: biru-indigo + putih. Font: Manrope + Inter.
         Logic Blade/PHP dan JS TIDAK diubah — hanya tampilan.
         ===================================================== --}}
    <style>
        :root {
            --primary: #1d4ed8;
            --primary-dark: #142e91;
            --primary-soft: #e8effe;
            --indigo: #4f46e5;
            --secondary: #059669;
            --accent: #0ea5e9;
            --ink: #0a0f2c;
            --bg-light: #f6f8fd;
            --text-muted: #64748b;
            --radius-card: 22px;
            --radius-btn: 12px;
            --shadow-card: 0 8px 24px rgba(10, 15, 44, 0.06);
            --shadow-card-hover: 0 26px 54px rgba(29, 78, 216, 0.16);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --svc-blue:   #e8effe;
            --svc-orange: #fef1e6;
            --svc-teal:   #e6f9f3;
            --svc-red:    #fdecec;
            --svc-indigo: #eeecfd;
            --svc-pink:   #fdeaf3;
            --svc-blue-icon:   #1d4ed8;
            --svc-orange-icon: #e2760f;
            --svc-teal-icon:   #059669;
            --svc-red-icon:    #dc2626;
            --svc-indigo-icon: #4f46e5;
            --svc-pink-icon:   #db2777;
        }

        * { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, .brand-font { font-family: 'Manrope', sans-serif; }

        body { color: var(--ink); background: #fff; }

        section, header, footer, main { position: relative; z-index: 1; }
        html { scroll-behavior: smooth; }
        ::selection { background: rgba(29,78,216,0.18); color: var(--primary-dark); }
        h1, h2, h3 { letter-spacing: -0.025em; }

        *, *::before, *::after {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* ============ FLOATING NAVBAR ============ */
        #sm-header {
            position: fixed;
            top: 18px; left: 0; right: 0;
            z-index: 9999;
            display: flex;
            justify-content: center;
            padding: 0 20px;
            pointer-events: none;
        }
        @media (max-width: 767px) { #sm-header { top: 0; padding: 0; } }

        .sm-header-inner {
            max-width: 1180px;
            width: 100%;
            margin: 0 auto;
            padding: 0 10px 0 20px;
            height: 68px;
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(18px) saturate(180%);
            -webkit-backdrop-filter: blur(18px) saturate(180%);
            border: 1px solid rgba(10,15,44,0.06);
            border-radius: 20px;
            box-shadow: 0 12px 40px rgba(10,15,44,0.09);
            pointer-events: auto;
        }
        @media (max-width: 767px) {
            .sm-header-inner { border-radius: 0; border: none; border-bottom: 1px solid rgba(10,15,44,0.07); box-shadow: 0 4px 20px rgba(10,15,44,0.06); padding: 0 14px; }
        }

        .sm-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            flex-shrink: 0;
            margin-right: 6px;
        }
        .sm-logo img  { height: 38px; width: auto; }
        .sm-logo span { font-family: 'Manrope', sans-serif; font-size: 1rem; font-weight: 800; color: var(--ink); white-space: nowrap; }

        #sm-nav { display: flex; align-items: center; flex: 1; }

        #sm-nav-list {
            display: flex;
            list-style: none;
            margin: 0; padding: 4px;
            gap: 2px;
            background: var(--bg-light);
            border-radius: 14px;
        }

        #sm-nav-list li a {
            display: block;
            padding: 9px 15px;
            font-size: 0.83rem;
            font-weight: 600;
            color: #475569;
            text-decoration: none;
            border-radius: 11px;
            transition: var(--transition);
            white-space: nowrap;
        }

        #sm-nav-list li a:hover { color: var(--primary); background: #fff; }
        #sm-nav-list li a.active {
            color: #fff;
            background: linear-gradient(135deg, var(--primary), var(--indigo));
            box-shadow: 0 6px 14px rgba(29,78,216,0.32);
        }

        .sm-header-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; margin-left: auto; }

        #sm-burger {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            width: 40px;
            height: 40px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 6px;
            border-radius: 10px;
            transition: background 0.2s;
            flex-shrink: 0;
        }
        #sm-burger:hover { background: var(--primary-soft); }
        #sm-burger span {
            display: block; width: 20px; height: 2px;
            background: var(--primary); border-radius: 2px;
            transition: all 0.3s ease; transform-origin: center;
        }
        #sm-burger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        #sm-burger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        #sm-burger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        #sm-mobile-menu {
            display: none;
            background: #fff;
            border-top: 1px solid rgba(29,78,216,0.08);
            box-shadow: 0 16px 36px rgba(10,15,44,0.12);
            position: fixed;
            top: 68px; left: 0; right: 0;
            z-index: 9998;
        }
        #sm-mobile-menu.open { display: block; animation: smSlideDown 0.22s ease; }
        @keyframes smSlideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
        #sm-mobile-menu ul { list-style: none; margin: 0; padding: 12px 20px 16px; }
        #sm-mobile-menu ul li a {
            display: block; padding: 13px 16px; font-size: 0.95rem; font-weight: 600;
            color: #334155; text-decoration: none; border-radius: 12px; transition: var(--transition);
        }
        #sm-mobile-menu ul li a:hover { background: var(--primary-soft); color: var(--primary); }

        @media (max-width: 1199px) { #sm-nav { display: none; } #sm-burger { display: flex; } }
        @media (max-width: 480px) { .sm-logo span { display: none; } }

        /* ============ BUTTONS ============ */
        .btn-school {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, var(--primary), var(--indigo));
            color: #fff !important; border: none; padding: 11px 24px;
            font-size: 0.87rem; font-weight: 700; border-radius: var(--radius-btn);
            text-decoration: none !important; transition: var(--transition); cursor: pointer;
            white-space: nowrap; box-shadow: 0 8px 18px rgba(29,78,216,0.26);
        }
        .btn-school:hover { transform: translateY(-2px); box-shadow: 0 14px 28px rgba(29,78,216,0.34); color: #fff !important; }
        .btn-school:active { transform: translateY(0); }

        .btn-outline-school {
            display: inline-flex; align-items: center; gap: 7px;
            background: transparent; color: var(--ink) !important;
            border: 1.5px solid rgba(10,15,44,0.14); padding: 11px 24px;
            font-size: 0.87rem; font-weight: 700; border-radius: var(--radius-btn);
            text-decoration: none !important; transition: var(--transition); cursor: pointer; white-space: nowrap;
        }
        .btn-outline-school:hover { border-color: var(--primary); color: var(--primary) !important; background: var(--primary-soft); }

        .btn-school-inverted {
            display: inline-flex; align-items: center; gap: 8px;
            background: #fff; color: var(--primary) !important; border: none;
            padding: 14px 32px; font-size: 0.98rem; font-weight: 700;
            border-radius: var(--radius-btn); text-decoration: none !important; transition: var(--transition);
        }
        .btn-school-inverted:hover { transform: translateY(-2px); box-shadow: 0 16px 34px rgba(0,0,0,0.2); }

        .btn-read-more {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--ink); color: #fff !important; padding: 13px 28px;
            border-radius: var(--radius-btn); font-weight: 700; text-decoration: none !important;
            transition: var(--transition);
        }
        .btn-read-more:hover { background: var(--primary); transform: translateY(-2px); box-shadow: 0 14px 28px rgba(29,78,216,0.28); }

        /* ============ SHARED ============ */
        .section-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 0.72rem; font-weight: 800; letter-spacing: 1.4px; text-transform: uppercase;
            color: var(--primary); background: var(--primary-soft); padding: 7px 16px; border-radius: 100px;
            margin-bottom: 16px;
        }

        .section-title { margin-bottom: 3rem; }
        .section-title.text-center { text-align: center; }
        .section-title h2 { font-size: 2.2rem; font-weight: 800; margin-bottom: 0.6rem; letter-spacing: -0.03em; }
        .section-title p  { color: var(--text-muted); font-size: 1.02rem; margin: 0; }

        .feature-card {
            background: #fff; border-radius: var(--radius-card); box-shadow: var(--shadow-card);
            border: 1px solid rgba(10,15,44,0.05); transition: var(--transition);
        }
        .feature-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-card-hover); border-color: rgba(29,78,216,0.14); }

        .feature-icon {
            width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;
            border-radius: 16px; background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white; font-size: 1.5rem; flex-shrink: 0;
        }

        .svc-icon {
            width: 56px; height: 56px; display: flex; align-items: center; justify-content: center;
            border-radius: 15px; font-size: 1.5rem;
        }
        .svc-blue   { background: var(--svc-blue);   color: var(--svc-blue-icon); }
        .svc-orange { background: var(--svc-orange); color: var(--svc-orange-icon); }
        .svc-teal   { background: var(--svc-teal);   color: var(--svc-teal-icon); }
        .svc-red    { background: var(--svc-red);     color: var(--svc-red-icon); }
        .svc-indigo { background: var(--svc-indigo); color: var(--svc-indigo-icon); }
        .svc-pink   { background: var(--svc-pink);   color: var(--svc-pink-icon); }

        /* ============ HERO — light, split, badge chips ============ */
        #hero {
            padding-top: 150px;
            padding-bottom: 60px;
            background:
                radial-gradient(circle at 100% 0%, rgba(29,78,216,0.07) 0%, transparent 45%),
                radial-gradient(circle at 0% 100%, rgba(14,165,233,0.06) 0%, transparent 45%),
                #fff;
            overflow: hidden;
        }
        @media (max-width: 767px) { #hero { padding-top: 96px; padding-bottom: 40px; } }

        .hero-text-wrap { opacity: 0; animation: heroFadeUp 0.8s ease 0.15s forwards; }
        .hero-text-wrap .section-eyebrow { background: var(--primary-soft); }
        .hero-text-wrap h1 {
            font-family: 'Manrope', sans-serif; font-size: 3.1rem; font-weight: 800;
            line-height: 1.12; letter-spacing: -0.035em; color: var(--ink);
        }
        .hero-text-wrap h1 strong { color: var(--primary); }
        .hero-text-wrap p { font-size: 1.08rem; color: var(--text-muted); max-width: 480px; }

        .hero-sub  { opacity: 0; animation: heroFadeUp 0.8s ease 0.35s forwards; }
        .hero-btns { opacity: 0; animation: heroFadeUp 0.8s ease 0.5s forwards; }
        .hero-chips { opacity: 0; animation: heroFadeUp 0.8s ease 0.65s forwards; }

        @keyframes heroFadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }

        .hero-chip {
            display: inline-flex; align-items: center; gap: 8px;
            background: #fff; border: 1px solid rgba(10,15,44,0.07); border-radius: 100px;
            padding: 8px 16px 8px 8px; font-size: 0.82rem; font-weight: 600; color: var(--ink);
            box-shadow: 0 6px 18px rgba(10,15,44,0.05);
        }
        .hero-chip .chip-dot {
            width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            background: var(--primary-soft); color: var(--primary); font-size: 0.85rem; flex-shrink: 0;
        }

        .hero-img-wrap {
            opacity: 0; animation: heroImgIn 1s ease 0.25s forwards;
            position: relative;
            background: linear-gradient(160deg, var(--primary), var(--indigo));
            border-radius: 32px;
            padding: 26px;
            box-shadow: 0 40px 80px rgba(29,78,216,0.28);
        }
        .hero-img-wrap::before {
            content: '';
            position: absolute; inset: -40px -60px auto auto; top: -40px; right: -60px;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(14,165,233,0.35) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }
        .hero-img-wrap img { animation: heroFloat 5s ease-in-out 1.2s infinite; border-radius: 20px; }
        @keyframes heroImgIn { from { opacity: 0; transform: scale(0.92) translateY(16px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        @keyframes heroFloat { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }

        @media (max-width: 768px) { .hero-text-wrap h1 { font-size: 2.15rem; } }

        /* ============ STATS — integrated strip ============ */
        #stats { padding: 30px 0 70px; background: #fff; }
        .stats-strip {
            background: var(--ink);
            border-radius: var(--radius-card);
            padding: 6px;
            box-shadow: 0 30px 60px rgba(10,15,44,0.18);
        }
        .stats-card {
            border-radius: 18px; padding: 26px 22px; color: #fff;
            display: flex; align-items: center; gap: 16px; height: 100%; transition: var(--transition);
        }
        .stats-card:hover { background: rgba(255,255,255,0.06); }
        .stats-card .stats-icon-wrap {
            width: 50px; height: 50px; border-radius: 13px; display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.1); flex-shrink: 0;
        }
        .stats-card i      { font-size: 1.35rem; color: var(--accent); }
        .stats-card .num   { font-family: 'Manrope', sans-serif; font-size: 1.85rem; font-weight: 800; line-height: 1; display: block; }
        .stats-card .label { font-size: 0.82rem; opacity: 0.65; margin: 0; }

        /* ============ ABOUT — image with floating badge ============ */
        #about { padding: 70px 0 90px; }
        .about-img-wrap { position: relative; }
        .about-img-wrap img {
            border-radius: var(--radius-card);
            box-shadow: 0 30px 60px rgba(10,15,44,0.1);
            border: 1px solid rgba(10,15,44,0.06);
        }
        .about-badge {
            position: absolute; bottom: -22px; left: -22px;
            background: #fff; border-radius: 18px; padding: 16px 20px;
            box-shadow: 0 20px 40px rgba(10,15,44,0.14);
            display: flex; align-items: center; gap: 12px;
            border: 1px solid rgba(10,15,44,0.05);
        }
        @media (max-width: 767px) { .about-badge { left: 12px; bottom: -18px; padding: 12px 16px; } }
        .about-badge .badge-ic {
            width: 44px; height: 44px; border-radius: 12px;
            background: linear-gradient(135deg, var(--secondary), #34d399);
            display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.2rem; flex-shrink: 0;
        }
        .about-badge strong { display: block; font-size: 0.95rem; font-weight: 800; }
        .about-badge span { font-size: 0.76rem; color: var(--text-muted); }

        /* ============ FEATURES — chip grid ============ */
        #features { padding: 90px 0; background: var(--bg-light); }
        .feature-box {
            display: flex; align-items: center; gap: 14px; padding: 16px 18px;
            border-radius: 16px; background: #fff; border: 1px solid rgba(10,15,44,0.05); transition: var(--transition);
        }
        .feature-box:hover { transform: translateY(-3px); box-shadow: var(--shadow-card); border-color: rgba(29,78,216,0.14); }
        .feature-box .fb-ic {
            width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .feature-box h3 { margin: 0; font-size: 0.9rem; font-weight: 700; }

        /* ============ SERVICES — bento grid ============ */
        #services { background: #fff; padding: 90px 0; }
        .svc-bento {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .svc-bento > div:first-child { grid-column: span 2; }
        @media (max-width: 991px) { .svc-bento { grid-template-columns: repeat(2, 1fr); } .svc-bento > div:first-child { grid-column: span 2; } }
        @media (max-width: 576px) { .svc-bento { grid-template-columns: 1fr; } .svc-bento > div:first-child { grid-column: span 1; } }

        .service-card { padding: 32px 30px; height: 100%; }
        .service-card h3 { font-size: 1.05rem; font-weight: 700; margin: 16px 0 8px; }
        .service-card p  { font-size: 0.9rem; color: var(--text-muted); margin: 0; line-height: 1.65; }
        .svc-bento > div:first-child .service-card { display: flex; flex-direction: column; justify-content: center; background: linear-gradient(150deg, var(--ink), var(--primary-dark)); color: #fff; }
        .svc-bento > div:first-child .service-card h3 { color: #fff; }
        .svc-bento > div:first-child .service-card p { color: rgba(255,255,255,0.68); }
        .svc-bento > div:first-child .svc-icon { background: rgba(255,255,255,0.12); color: #fff; }

        /* ============ CTA — split panel ============ */
        #call-to-action { padding: 0 0 90px; background: #fff; }
        .cta-panel {
            background: linear-gradient(120deg, var(--primary) 0%, var(--indigo) 100%);
            border-radius: 28px; padding: 60px 56px; color: #fff;
            display: flex; align-items: center; justify-content: space-between; gap: 30px; flex-wrap: wrap;
            position: relative; overflow: hidden;
        }
        .cta-panel::before {
            content: ''; position: absolute; width: 380px; height: 380px;
            background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 65%);
            border-radius: 50%; top: -140px; right: -80px; pointer-events: none;
        }
        .cta-panel h2 { font-family: 'Manrope', sans-serif; font-size: 2rem; font-weight: 800; margin-bottom: 10px; }
        .cta-panel p  { opacity: 0.88; margin: 0; max-width: 440px; }
        @media (max-width: 767px) { .cta-panel { padding: 40px 28px; border-radius: 22px; } }

        /* ============ RECENT / ACTIVE EXAMS — list rows ============ */
        #recent-exams  { padding: 90px 0; background: var(--bg-light); }
        #active-exams  { padding: 90px 0; background: #fff; }

        .exam-row {
            display: flex; align-items: center; gap: 20px; padding: 22px 26px;
        }
        .exam-row .feature-icon { margin: 0; }
        .exam-row .exam-body { flex: 1; min-width: 0; }
        .exam-row h3 { font-size: 1.02rem; font-weight: 700; margin-bottom: 6px; }
        .exam-row .meta { font-size: 0.85rem; color: var(--text-muted); margin: 0 16px 4px 0; display: inline-flex; align-items: center; }
        .exam-row .badge-active {
            display: inline-block; background: var(--secondary); color: #fff; font-size: 0.7rem; font-weight: 700;
            padding: 4px 13px; border-radius: 20px; margin-bottom: 8px; letter-spacing: 0.5px;
        }
        .exam-row-active { border-left: 4px solid var(--secondary) !important; }
        @media (max-width: 640px) {
            .exam-row { flex-direction: column; align-items: flex-start; gap: 14px; padding: 20px; }
            .exam-row .btn-exam { width: 100%; justify-content: center; }
        }

        .btn-exam {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--ink); color: #fff !important; border: none; padding: 10px 22px;
            font-size: 0.84rem; font-weight: 700; border-radius: var(--radius-btn);
            text-decoration: none !important; transition: var(--transition); flex-shrink: 0;
        }
        .btn-exam:hover { background: var(--primary); transform: translateY(-2px); }
        .btn-exam-success { background: var(--secondary); }
        .btn-exam-success:hover { background: #047857; }

        /* ============ MY PROJECT — split panel showcase ============ */
        #my-project { padding: 90px 0; background: var(--bg-light); }
        [data-theme="dark"] #my-project { background-color: #0c1120; }

        .mp-card {
            border-radius: 28px; overflow: hidden; box-shadow: 0 24px 60px rgba(10,15,44,0.12);
            display: grid; grid-template-columns: 1fr;
        }
        @media (min-width: 992px) { .mp-card { grid-template-columns: 0.85fr 1.15fr; } }

        .mp-card-header {
            background: linear-gradient(165deg, var(--ink), var(--primary-dark));
            color: #fff; padding: 40px 38px; display: flex; flex-direction: column; gap: 20px;
        }
        @media (max-width: 576px) { .mp-card-header { padding: 30px 22px; } }

        .mp-project-title { font-family: 'Manrope', sans-serif; font-size: 1.4rem; font-weight: 800; color: #fff; margin-bottom: 6px; display: flex; align-items: center; gap: 10px; }
        .mp-project-logo { height: 30px; width: 30px; object-fit: contain; border-radius: 8px; flex-shrink: 0; background: #fff; padding: 3px; }
        .mp-project-desc { font-size: 0.87rem; color: rgba(255,255,255,0.68); line-height: 1.75; margin-bottom: 0; }

        .mp-tags { display: flex; flex-wrap: wrap; gap: 8px; }
        .mp-tag { padding: 5px 14px; border-radius: 100px; font-size: 0.72rem; font-weight: 700; background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.16); }
        .mp-tag-green { background: rgba(16,185,129,0.16); color: #6ee7b7; border-color: rgba(16,185,129,0.3); }
        .mp-tag-orange { background: rgba(234,127,26,0.16); color: #fbbf7a; border-color: rgba(234,127,26,0.3); }

        .mp-status {
            display: inline-flex; align-items: center; gap: 7px; align-self: flex-start;
            background: rgba(16,185,129,0.14); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3);
            padding: 7px 16px; border-radius: 100px; font-size: 0.78rem; font-weight: 700;
        }
        .mp-status-dot { width: 7px; height: 7px; background: #34d399; border-radius: 50%; animation: blink 1.5s ease-in-out infinite; }
        @keyframes blink { 0%,100%{opacity:1;} 50%{opacity:.25;} }

        .mp-features {
            margin-top: auto;
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;
            padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);
        }
        .mp-feat-item { display: flex; flex-direction: column; gap: 4px; }
        .mp-feat-icon { font-size: 1.05rem; color: var(--accent); }
        .mp-feat-title { font-family: 'Manrope', sans-serif; font-size: 0.8rem; font-weight: 700; color: #fff; }
        .mp-feat-desc { font-size: 0.7rem; color: rgba(255,255,255,0.55); line-height: 1.5; }

        /* Slider */
        .mp-slider-wrap { position: relative; background: #fff; display: flex; flex-direction: column; }
        .mp-progress { height: 2px; background: rgba(10,15,44,0.08); overflow: hidden; flex-shrink: 0; }
        .mp-progress-bar { height: 100%; background: linear-gradient(90deg, var(--primary), var(--accent)); width: 0%; transition: none; }
        .mp-progress-bar.running { width: 100%; transition: width 3s linear; }

        .mp-slider-chrome {
            height: 38px; background: #f1f4fb; display: flex; align-items: center; padding: 0 14px; gap: 7px;
            border-bottom: 1px solid rgba(10,15,44,0.06); flex-shrink: 0;
        }
        .mp-dot-r { width: 10px; height: 10px; border-radius: 50%; background: #ff5f57; flex-shrink: 0; }
        .mp-dot-y { width: 10px; height: 10px; border-radius: 50%; background: #febc2e; flex-shrink: 0; }
        .mp-dot-g { width: 10px; height: 10px; border-radius: 50%; background: #28c840; flex-shrink: 0; }
        .mp-url-bar { flex: 1; margin: 0 10px; height: 22px; background: #fff; border-radius: 6px; display: flex; align-items: center; padding: 0 10px; border: 1px solid rgba(10,15,44,0.07); }
        .mp-url-text { font-size: 0.65rem; color: #64748b; }

        .mp-slide-track-wrap {
            position: relative; overflow: hidden; flex: 1;
            background: linear-gradient(135deg, rgba(29,78,216,0.04), rgba(14,165,233,0.04));
        }
        .mp-slide-track { display: flex; height: 100%; transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
        .mp-slide { min-width: 100%; height: 100%; position: relative; display: flex; align-items: center; justify-content: center; }
        .mp-slide img { width: 100%; height: 100%; object-fit: cover; display: block; }

        .mp-slide-label {
            position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%);
            background: rgba(10,15,44,0.65); color: #fff; font-size: 0.72rem; font-weight: 700;
            padding: 5px 16px; border-radius: 100px; white-space: nowrap; backdrop-filter: blur(6px);
        }

        .mp-slide-btn {
            position: absolute; top: 50%; transform: translateY(-50%); z-index: 10;
            width: 38px; height: 38px; border-radius: 12px; background: rgba(255,255,255,0.92);
            border: 1px solid rgba(10,15,44,0.08); color: var(--primary); font-size: 1rem;
            display: flex; align-items: center; justify-content: center; cursor: pointer;
            transition: all 0.2s; box-shadow: 0 4px 12px rgba(10,15,44,0.14);
        }
        .mp-slide-btn:hover { background: var(--primary); color: #fff; transform: translateY(-50%) scale(1.08); }
        .mp-slide-btn-prev { left: 12px; }
        .mp-slide-btn-next { right: 12px; }

        .mp-dots {
            display: flex; justify-content: center; align-items: center; gap: 7px; padding: 14px 0;
            background: #f1f4fb; border-top: 1px solid rgba(10,15,44,0.05); flex-shrink: 0;
        }
        .mp-dot-ind { width: 8px; height: 8px; border-radius: 50%; background: rgba(29,78,216,0.22); border: none; cursor: pointer; padding: 0; transition: all 0.25s; flex-shrink: 0; }
        .mp-dot-ind.active { background: var(--primary); width: 24px; border-radius: 4px; }

        /* Dark mode overrides for slider (light chrome stays consistent) */
        [data-theme="dark"] .mp-slider-wrap { background: #10162a; }
        [data-theme="dark"] .mp-slider-chrome { background: #161d33; border-bottom-color: rgba(255,255,255,0.07); }
        [data-theme="dark"] .mp-url-bar { background: #10162a; border-color: rgba(255,255,255,0.08); }
        [data-theme="dark"] .mp-slide-track-wrap { background: linear-gradient(135deg, rgba(29,78,216,0.14), rgba(14,165,233,0.08)); }
        [data-theme="dark"] .mp-slide-btn { background: rgba(16,22,42,0.92); border-color: rgba(255,255,255,0.1); color: #93b4ff; }
        [data-theme="dark"] .mp-dots { background: #161d33; border-top-color: rgba(255,255,255,0.07); }
        [data-theme="dark"] .mp-dot-ind { background: rgba(147,180,255,0.25); }
        [data-theme="dark"] .mp-dot-ind.active { background: #93b4ff; }

        input#mp-file-bulk { display: none; }

        /* ============ CONTACT ============ */
        #contact { padding: 90px 0; }
        .contact-info-card {
            display: flex; align-items: flex-start; gap: 16px; padding: 22px;
            background: #fff; border-radius: 18px; border: 1px solid rgba(10,15,44,0.05);
            border-left: 3px solid var(--primary); box-shadow: var(--shadow-card); height: 100%;
            transition: var(--transition);
        }
        .contact-info-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-card-hover); }
        .contact-info-card i {
            font-size: 1.2rem; color: #fff; display: flex; align-items: center; justify-content: center;
            width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
            background: linear-gradient(135deg, var(--primary), var(--accent));
        }
        .contact-info-card h3 { font-size: 0.94rem; font-weight: 700; margin-bottom: 4px; }
        .contact-info-card p { font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.6; }

        .contact-form {
            background: var(--ink); padding: 38px 34px; border-radius: var(--radius-card); color: #fff;
        }
        .contact-form .form-control {
            padding: 13px 16px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.14);
            font-size: 0.9rem; transition: border-color 0.2s; background: rgba(255,255,255,0.06); color: #fff;
        }
        .contact-form .form-control::placeholder { color: rgba(255,255,255,0.4); }
        .contact-form .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 4px rgba(14,165,233,0.15); background: rgba(255,255,255,0.1); color: #fff; }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--accent)); color: #fff; border: none;
            padding: 14px 40px; border-radius: var(--radius-btn); font-weight: 700; font-size: 0.95rem;
            cursor: pointer; transition: var(--transition); box-shadow: 0 8px 20px rgba(29,78,216,0.3);
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 14px 30px rgba(29,78,216,0.4); }

        /* ============ FOOTER ============ */
        #footer {
            background:
                radial-gradient(ellipse at 15% 85%, rgba(29,78,216,0.18) 0%, transparent 50%),
                radial-gradient(ellipse at 85% 15%, rgba(14,165,233,0.1) 0%, transparent 50%),
                var(--ink);
            color: rgba(255,255,255,0.68); padding-top: 66px;
        }
        #footer h4 { font-family: 'Manrope', sans-serif; color: #fff; font-weight: 700; margin-bottom: 16px; font-size: 0.98rem; }
        #footer p  { font-size: 0.87rem; line-height: 1.7; }
        .footer-links ul { list-style: none; padding: 0; margin: 0; }
        .footer-links ul li { margin-bottom: 8px; font-size: 0.87rem; }
        .footer-links ul li a { color: rgba(255,255,255,0.6); text-decoration: none; transition: color 0.2s; }
        .footer-links ul li a:hover { color: var(--accent); }
        .footer-links ul li i { color: var(--accent); margin-right: 6px; font-size: 0.72rem; }
        .footer-social a {
            display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px;
            background: rgba(255,255,255,0.08); border-radius: 11px; color: rgba(255,255,255,0.72);
            text-decoration: none; transition: var(--transition); margin-right: 8px;
        }
        .footer-social a:hover { background: var(--accent); color: var(--ink); transform: translateY(-3px); }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08); padding: 20px 0; margin-top: 50px;
            font-size: 0.84rem; color: rgba(255,255,255,0.4); text-align: center;
        }
        .footer-bottom a { color: var(--accent); text-decoration: none; }

        #scroll-top {
            position: fixed; bottom: 24px; right: 24px; width: 46px; height: 46px;
            background: linear-gradient(135deg, var(--primary), var(--indigo)); color: #fff; border-radius: 15px;
            display: flex; align-items: center; justify-content: center; font-size: 1.3rem; text-decoration: none;
            z-index: 9999; transition: var(--transition); box-shadow: 0 8px 20px rgba(29,78,216,0.4);
        }
        #scroll-top:hover { transform: translateY(-3px); box-shadow: 0 14px 28px rgba(29,78,216,0.5); }

        /* ============ BOTTOM NAV (mobile) ============ */
        #sm-bottom-nav { display: none; }
        @media (max-width: 1199px) {
            #sm-bottom-nav {
                display: flex; position: fixed; bottom: 0; left: 0; right: 0; z-index: 9998;
                background: rgba(255,255,255,0.95); backdrop-filter: blur(18px) saturate(180%);
                -webkit-backdrop-filter: blur(18px) saturate(180%);
                border-top: 1px solid rgba(10,15,44,0.07); box-shadow: 0 -4px 24px rgba(10,15,44,0.1);
                padding: 0 8px; padding-bottom: env(safe-area-inset-bottom, 0px);
                height: calc(62px + env(safe-area-inset-bottom, 0px));
                align-items: stretch; justify-content: space-around;
            }
            .sm-bnav-item {
                display: flex; flex-direction: column; align-items: center; justify-content: center; flex: 1;
                gap: 3px; text-decoration: none; color: #9aa5b8; font-size: 0.65rem; font-weight: 600;
                padding: 8px 4px; transition: color 0.2s ease; position: relative;
            }
            .sm-bnav-item i { font-size: 1.25rem; transition: transform 0.2s ease, color 0.2s ease; }
            .sm-bnav-item:hover, .sm-bnav-item.active { color: var(--primary); }
            .sm-bnav-item.active i { transform: translateY(-2px); }
            .sm-bnav-item.active::after { content: ''; position: absolute; bottom: 6px; width: 4px; height: 4px; background: var(--primary); border-radius: 50%; }
            .sm-bnav-center { flex: 1.2; margin-top: -20px; z-index: 1; }
            .sm-bnav-fab {
                width: 52px; height: 52px; background: linear-gradient(135deg, var(--primary), var(--indigo));
                border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white;
                font-size: 1.3rem; box-shadow: 0 10px 24px rgba(29,78,216,0.45);
                transition: transform 0.2s ease, box-shadow 0.2s ease; margin-bottom: 2px;
            }
            .sm-bnav-center:hover .sm-bnav-fab, .sm-bnav-center.active .sm-bnav-fab { transform: translateY(-4px) scale(1.08); box-shadow: 0 14px 30px rgba(29,78,216,0.55); }
            .sm-bnav-center span { color: var(--primary); font-weight: 700; }
            body { padding-bottom: calc(62px + env(safe-area-inset-bottom, 0px)); }
            #scroll-top { display: none !important; }
        }

        /* ============ MOBILE REFINEMENTS ============ */
        html, body { overflow-x: hidden; }

        @media (max-width: 767px) {
            .container { padding-left: 20px; padding-right: 20px; }
            .section-title { margin-bottom: 2.2rem; }
            .section-title h2 { font-size: 1.6rem; }

            .hero-chips { gap: 8px !important; }
            .hero-chip { font-size: 0.76rem; padding: 6px 12px 6px 6px; }

            .stats-card { padding: 18px 16px; gap: 12px; }
            .stats-card .num { font-size: 1.5rem; }

            .cta-panel { flex-direction: column; align-items: flex-start; text-align: left; }
            .cta-panel .btn-school-inverted { width: 100%; justify-content: center; }

            .contact-form { padding: 26px 22px; }

            .mp-card-header { gap: 16px; }
            .mp-features { grid-template-columns: 1fr 1fr; gap: 16px; }
            .mp-project-desc { font-size: 0.84rem; }

            .service-card { padding: 26px 22px; }
            .svc-bento { gap: 14px; }

            .about-badge strong { font-size: 0.85rem; }
        }
    </style>

    {{-- =====================================================
         ★ DARK MODE
         ===================================================== --}}
    <style>
        [data-theme="dark"] { --bg-light: #10162a; --text-muted: #93a0bb; }
        [data-theme="dark"] body { background-color: #070a15; color: #e6ebf7; }

        [data-theme="dark"] .sm-header-inner { background: rgba(10,15,26,0.85) !important; border-color: rgba(255,255,255,0.08) !important; }
        [data-theme="dark"] #sm-nav-list { background: rgba(255,255,255,0.05); }
        [data-theme="dark"] #sm-nav-list li a { color: #cbd5e1; }
        [data-theme="dark"] #sm-nav-list li a:hover { background: rgba(255,255,255,0.06); color: var(--accent); }
        [data-theme="dark"] .sm-logo span { color: #f3f6ff; }
        [data-theme="dark"] #sm-burger span { background: #e5e7eb; }
        [data-theme="dark"] #sm-mobile-menu { background: #0e1424; border-top-color: rgba(255,255,255,0.07); }
        [data-theme="dark"] #sm-mobile-menu ul li a { color: #d1d5db; }

        [data-theme="dark"] #hero { background: radial-gradient(circle at 100% 0%, rgba(29,78,216,0.12) 0%, transparent 45%), radial-gradient(circle at 0% 100%, rgba(14,165,233,0.08) 0%, transparent 45%), #070a15; }
        [data-theme="dark"] .hero-text-wrap h1 { color: #f3f6ff; }
        [data-theme="dark"] .hero-chip { background: #10162a; border-color: rgba(255,255,255,0.08); color: #e6ebf7; }

        [data-theme="dark"] #stats { background: #070a15; }
        [data-theme="dark"] #about { background: #070a15; }
        [data-theme="dark"] .about-badge { background: #10162a; border-color: rgba(255,255,255,0.07); }
        [data-theme="dark"] .about-badge strong { color: #f3f6ff; }

        [data-theme="dark"] .feature-card { background: #10162a !important; border-color: rgba(255,255,255,0.07) !important; }
        [data-theme="dark"] #features { background: #070a15 !important; }
        [data-theme="dark"] .feature-box { background: #10162a; border-color: rgba(255,255,255,0.06); }
        [data-theme="dark"] .feature-box:hover { background: #151c33; }
        [data-theme="dark"] .feature-box h3 { color: #f3f4f6; }

        [data-theme="dark"] #services { background: #070a15 !important; }
        [data-theme="dark"] .service-card p { color: #93a0bb; }

        [data-theme="dark"] #call-to-action { background: #070a15; }

        [data-theme="dark"] #recent-exams { background: #10162a !important; }
        [data-theme="dark"] #active-exams { background: #070a15 !important; }

        [data-theme="dark"] #contact { background: #070a15; }
        [data-theme="dark"] .contact-info-card { background: #10162a; border-color: rgba(255,255,255,0.06); }
        [data-theme="dark"] .contact-info-card h3 { color: #f3f4f6; }

        [data-theme="dark"] .section-eyebrow { background: rgba(14,165,233,0.12); color: var(--accent); }

        [data-theme="dark"] #sm-bottom-nav { background: rgba(10,15,26,0.95) !important; border-top-color: rgba(255,255,255,0.07) !important; }
        [data-theme="dark"] .sm-bnav-item { color: #6b7280; }

        #dm-toggle {
            display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px;
            border-radius: 12px; border: 1.5px solid rgba(29,78,216,0.18); background: var(--primary-soft);
            color: var(--primary); cursor: pointer; font-size: 1.02rem; transition: all 0.25s ease; flex-shrink: 0;
        }
        #dm-toggle:hover { background: rgba(29,78,216,0.15); border-color: var(--primary); transform: rotate(20deg) scale(1.08); }
        #dm-toggle .icon-sun  { display: inline; }
        #dm-toggle .icon-moon { display: none; }
        [data-theme="dark"] #dm-toggle .icon-sun  { display: none; }
        [data-theme="dark"] #dm-toggle .icon-moon { display: inline; }
        [data-theme="dark"] #dm-toggle { border-color: rgba(14,165,233,0.3); background: rgba(14,165,233,0.1); color: var(--accent); }
    </style>
</head>

<body class="index-page">

    <header id="sm-header">
        <div class="sm-header-inner">

            <a href="{{ url('/') }}" class="sm-logo">
                <img src="{{ asset('assets/img/icon.png') }}" alt="Logo">
            </a>

            <nav id="sm-nav">
                <ul id="sm-nav-list">
                    <li><a href="#hero"       class="sm-nav-link active">Beranda</a></li>
                    <li><a href="{{ route('public.docs') }}" target="_blank" class="sm-nav-link"><i class="bi bi-book me-1"></i> Dokumentasi</a></li>
                    <li><a href="{{ route('public.pengumuman') }}" target="_blank" class="sm-nav-link">Pengumuman Kelulusan</a></li>
                    <li><a href="#about"      class="sm-nav-link">Tentang</a></li>
                    <li><a href="#features"   class="sm-nav-link">Fitur</a></li>
                    <li><a href="#services"   class="sm-nav-link">Layanan</a></li>
                    <li><a href="#my-project" class="sm-nav-link">My Project</a></li>
                    <li><a href="{{ route('public.ranking') }}" target="_blank">Ranking Siswa</a></li>
                    <li><a href="#contact"    class="sm-nav-link">Kontak</a></li>
                </ul>
            </nav>

            <div class="sm-header-actions">

                <button id="dm-toggle" title="Toggle dark mode" aria-label="Toggle dark mode">
                    <i class="bi bi-sun-fill icon-sun"></i>
                    <i class="bi bi-moon-stars-fill icon-moon"></i>
                </button>

                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-school">
                        <i class="bi bi-speedometer2"></i>
                        <span class="d-none d-md-inline">Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-school">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Login</span>
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-outline-school d-none d-sm-inline-flex">Daftar</a>
                    @endif
                @endauth

                <button id="sm-burger" aria-label="Menu" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

        </div>

        <div id="sm-mobile-menu">
            <ul>
                <li><a href="#hero"       class="sm-nav-link">Beranda</a></li>
                 <li><a href="{{ route('public.pengumuman') }}" target="_blank" class="sm-nav-link active">Pengumuman Kelulusan</a></li>
                <li><a href="#about"      class="sm-nav-link">Tentang</a></li>
                <li><a href="#features"   class="sm-nav-link">Fitur</a></li>
                <li><a href="#services"   class="sm-nav-link">Layanan</a></li>
                <li><a href="#my-project" class="sm-nav-link">My Project</a></li>
                <li><a href="#contact"    class="sm-nav-link">Kontak</a></li>
                <li> <a href="https://simoro.sma-n5-morotai.id/ranking" target="_blank">Ranking Siswa</a></li>
            </ul>
        </div>
    </header>

    <main class="main">

        <!-- HERO -->
        <section id="hero">
            <div class="container">
                <div class="row gy-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-text-wrap">
                            <span class="section-eyebrow">✦ Sistem Ujian Digital Resmi</span>
                            <h1>Sistem Ujian Online<br><strong>SMA Negeri 5 Morotai</strong></h1>
                        </div>
                        <div class="hero-sub">
                            <p class="mt-3">Mudahkan proses ujian dengan teknologi modern. Mulai ujian dimana saja, kapan saja dengan aman dan terpercaya.</p>
                        </div>
                        <div class="hero-btns d-flex flex-wrap gap-3 mt-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-school">
                                    <i class="bi bi-speedometer2"></i> Masuk Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-school">
                                    <i class="bi bi-box-arrow-in-right"></i> Mulai Ujian
                                </a>
                                <a href="#about" class="btn-outline-school">Pelajari Lebih Lanjut</a>
                            @endauth
                        </div>
                        <div class="hero-chips d-flex flex-wrap gap-2 mt-4">
                            <span class="hero-chip"><span class="chip-dot"><i class="bi bi-shield-check"></i></span>Anti-Cheat</span>
                            <span class="hero-chip"><span class="chip-dot"><i class="bi bi-clock-history"></i></span>Timer Real-time</span>
                            <span class="hero-chip"><span class="chip-dot"><i class="bi bi-graph-up"></i></span>Hasil Instan</span>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <div class="hero-img-wrap">
                            <img src="{{ asset('assets/frondend/assets/img/hero-img.png') }}"
                                 class="img-fluid"
                                 alt="Hero Image"
                                 style="max-height: 400px;">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- STATS -->
        <section id="stats">
            <div class="container" data-aos="fade-up">
                <div class="stats-strip">
                    <div class="row gy-2 g-lg-0">
                    @php
                        $statsItems = [
                            ['icon' => 'bi-people',    'value' => $stats['total_siswa'],   'label' => 'Siswa'],
                            ['icon' => 'bi-book',      'value' => $stats['total_guru'],    'label' => 'Guru'],
                            ['icon' => 'bi-file-text', 'value' => $stats['total_ujian'],   'label' => 'Ujian'],
                            ['icon' => 'bi-award',     'value' => $stats['total_peserta'], 'label' => 'Sesi Ujian'],
                        ];
                    @endphp
                    @foreach($statsItems as $item)
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-card">
                            <span class="stats-icon-wrap"><i class="bi {{ $item['icon'] }}"></i></span>
                            <div>
                                <span class="num purecounter"
                                    data-purecounter-start="0"
                                    data-purecounter-end="{{ $item['value'] }}"
                                    data-purecounter-duration="1">{{ $item['value'] }}</span>
                                <p class="label">{{ $item['label'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- ABOUT -->
        <section id="about">
            <div class="container">
                <div class="row gy-5 align-items-center">
                    <div class="col-lg-6 order-2 order-lg-1" data-aos="fade-right">
                        <span class="section-eyebrow">Tentang SIMORO SMANLI</span>
                        <h2 style="font-size: 2.05rem; font-weight: 800; margin-bottom: 1.25rem; letter-spacing: -0.03em;">Sistem Ujian Online Modern untuk Pendidikan Terbaik</h2>
                        <p style="color: var(--text-muted);">SIMORO SMANLI adalah platform ujian online yang dirancang khusus untuk mendukung kegiatan pembelajaran di SMA Negeri 5 Morotai. Dengan teknologi terkini, kami menghadirkan pengalaman ujian yang aman, praktis, dan transparan.</p>
                        <p style="color: var(--text-muted);">Sistem ini memungkinkan siswa untuk mengikuti ujian secara online dengan mudah, sementara guru dapat mengelola dan memantau ujian dengan lebih efisien.</p>
                        <a href="#features" class="btn-read-more mt-3">
                            Lihat Fitur <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-out" data-aos-delay="100">
                        <div class="about-img-wrap">
                            <img src="{{ asset('assets/frondend/assets/img/about.jpg') }}" class="img-fluid w-100" alt="About">
                            <div class="about-badge">
                                <span class="badge-ic"><i class="bi bi-patch-check-fill"></i></span>
                                <div>
                                    <strong>Terverifikasi</strong>
                                    <span>Platform resmi sekolah</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FEATURES -->
        <section id="features">
            <div class="container section-title text-center" data-aos="fade-up">
                <h2>Fitur Unggulan</h2>
                <p>Kemudahan dan keamanan dalam setiap ujian</p>
            </div>
            <div class="container">
                <div class="row gy-5 align-items-center">
                    <div class="col-xl-6 order-2 order-xl-1">
                        <div class="row gy-3">
                            @php
                                $features = [
                                    ['icon' => 'bi-check-circle-fill', 'color' => 'var(--primary)',  'label' => 'Ujian Online'],
                                    ['icon' => 'bi-shield-check',      'color' => 'var(--secondary)','label' => 'Aman & Terpercaya'],
                                    ['icon' => 'bi-clock-history',     'color' => 'var(--accent)',   'label' => 'Waktu Realtime'],
                                    ['icon' => 'bi-graph-up',          'color' => '#e2760f',         'label' => 'Hasil Instan'],
                                    ['icon' => 'bi-phone',             'color' => '#4f46e5',         'label' => 'Multi Device'],
                                    ['icon' => 'bi-cloud-upload',      'color' => '#db2777',         'label' => 'Backup Data'],
                                ];
                            @endphp
                            @foreach($features as $i => $f)
                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ 150 + ($i * 80) }}">
                                <div class="feature-box">
                                    <span class="fb-ic" style="background: {{ $f['color'] }}22;"><i class="bi {{ $f['icon'] }}" style="color: {{ $f['color'] }}; font-size: 1.25rem;"></i></span>
                                    <h3>{{ $f['label'] }}</h3>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xl-6 order-1 order-xl-2" data-aos="zoom-out" data-aos-delay="100">
                        <img src="{{ asset('assets/frondend/assets/img/features.png') }}" class="img-fluid" alt="Features" style="border-radius: var(--radius-card);">
                    </div>
                </div>
            </div>
        </section>

        <!-- SERVICES -->
        <section id="services">
            <div class="container section-title text-center" data-aos="fade-up">
                <h2>Layanan</h2>
                <p>Layanan terbaik untuk pendidikan</p>
            </div>
            <div class="container">
                <div class="svc-bento">
                    @php
                        $services = [
                            ['icon' => 'bi-laptop',            'cls' => 'svc-blue',   'title' => 'Ujian Online',       'desc' => 'Ikuti ujian dengan mudah melalui perangkat komputer atau smartphone. Tidak perlu datang ke sekolah.'],
                            ['icon' => 'bi-shield-lock',       'cls' => 'svc-orange', 'title' => 'Keamanan Terjamin',  'desc' => 'Sistem anti cheat dan monitoring real-time untuk memastikan kejujuran dalam ujian.'],
                            ['icon' => 'bi-file-earmark-check','cls' => 'svc-teal',   'title' => 'Raport Digital',     'desc' => 'Hasil ujian langsung tercatat dalam sistem dan dapat diakses kapan saja secara digital.'],
                            ['icon' => 'bi-people',            'cls' => 'svc-red',    'title' => 'Manajemen Kelas',    'desc' => 'Kelola data siswa dan pembagian ujian dengan mudah melalui satu platform.'],
                            ['icon' => 'bi-bar-chart',         'cls' => 'svc-indigo', 'title' => 'Analisis Hasil',     'desc' => 'Dapatkan analisis mendalam tentang performa siswa dan kualitas soal ujian.'],
                            ['icon' => 'bi-chat-dots',         'cls' => 'svc-pink',   'title' => 'Support 24/7',       'desc' => 'Tim support siap membantu kapan saja jika ada kendala dalam penggunaan sistem.'],
                        ];
                    @endphp
                    @foreach($services as $i => $svc)
                    <div data-aos="fade-up" data-aos-delay="{{ 100 + ($i * 80) }}">
                        <div class="feature-card service-card">
                            <div class="svc-icon {{ $svc['cls'] }}">
                                <i class="bi {{ $svc['icon'] }}"></i>
                            </div>
                            <h3>{{ $svc['title'] }}</h3>
                            <p>{{ $svc['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- CALL TO ACTION -->
        <section id="call-to-action">
            <div class="container" data-aos="fade-up">
                <div class="cta-panel">
                    <div>
                        <h2>Siap Memulai?</h2>
                        <p>Bergabunglah dengan SMA Negeri 5 Morotai dan rasakan kemudahan ujian online yang modern dan terpercaya.</p>
                    </div>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-school-inverted">
                            <i class="bi bi-speedometer2"></i> Masuk Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-school-inverted">
                            <i class="bi bi-box-arrow-in-right"></i> Login Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- RECENT EXAMS -->
        @if($recentExams->count() > 0)
        <section id="recent-exams">
            <div class="container section-title text-center" data-aos="fade-up">
                <h2>Ujian Terbaru</h2>
                <p>Ujian yang baru dibuat</p>
            </div>
            <div class="container">
                <div class="row gy-3">
                    @foreach($recentExams as $exam)
                    <div class="col-12" data-aos="fade-up" data-aos-delay="60">
                        <div class="feature-card exam-row">
                            <div class="feature-icon">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div class="exam-body">
                                <h3>{{ $exam->title }}</h3>
                                <span class="meta"><i class="bi bi-book me-1"></i>{{ $exam->subject->name ?? 'Tidak ada mata pelajaran' }}</span>
                                <span class="meta"><i class="bi bi-people me-1"></i>{{ $exam->schoolClass->name ?? 'Tidak ada kelas' }}</span>
                                <span class="meta"><i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($exam->start_time)->format('d M Y') }}</span>
                            </div>
                            @auth
                                @if(auth()->user()->role == 'student')
                                <a href="{{ route('siswa.ujian.detail', $exam->id) }}" class="btn-exam">
                                    <i class="bi bi-eye"></i> Lihat Detail
                                </a>
                                @endif
                            @else
                            <a href="{{ route('login') }}" class="btn-exam">
                                <i class="bi bi-box-arrow-in-right"></i> Login untuk Mengikuti
                            </a>
                            @endauth
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- ACTIVE EXAMS -->
        @if($activeExams->count() > 0)
        <section id="active-exams">
            <div class="container section-title text-center" data-aos="fade-up">
                <h2>Ujian Sedang Aktif</h2>
                <p>Segera ikuti ujian sebelum tertutup</p>
            </div>
            <div class="container">
                <div class="row gy-3">
                    @foreach($activeExams as $exam)
                    <div class="col-12" data-aos="fade-up" data-aos-delay="60">
                        <div class="feature-card exam-row exam-row-active">
                            <div class="feature-icon">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div class="exam-body">
                                <span class="badge-active d-block">● AKTIF</span>
                                <h3>{{ $exam->title }}</h3>
                                <span class="meta"><i class="bi bi-book me-1"></i>{{ $exam->subject->name ?? 'Tidak ada mata pelajaran' }}</span>
                                <span class="meta"><i class="bi bi-clock me-1"></i>{{ $exam->duration }} menit</span>
                            </div>
                            @auth
                                @if(auth()->user()->role == 'student')
                                <a href="{{ route('siswa.ujian.detail', $exam->id) }}" class="btn-exam btn-exam-success">
                                    <i class="bi bi-play-fill"></i> Mulai Ujian
                                </a>
                                @endif
                            @else
                            <a href="{{ route('login') }}" class="btn-exam btn-exam-success">
                                <i class="bi bi-box-arrow-in-right"></i> Login Sekarang
                            </a>
                            @endauth
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

       {{-- =====================================================
     ★ MY PROJECT — SIMORO SMANLI (SLIDER)
     ===================================================== --}}
<section id="my-project">
    <div class="container">

        <div class="section-title text-center" data-aos="fade-up">
            <h2>My Project</h2>
            <p>Tampilan SIMORO SMANLI — SMA Negeri 5 Morotai</p>
        </div>

        <div class="mp-card" data-aos="fade-up" data-aos-delay="100">

            {{-- Header --}}
            <div class="mp-card-header">
                <div class="mp-status">
                    <span class="mp-status-dot"></span>
                    Project Aktif
                </div>
                <div>
                    <div class="mp-project-title">
                        <img src="{{ asset('assets/img/icon.png') }}" alt="Logo SIMORO" class="mp-project-logo">SIMORO SMANLI
                    </div>
                    <p class="mp-project-desc">
                        Sistem Ujian Online resmi SMA Negeri 5 Morotai. Dibangun dengan Laravel + Bootstrap 5,
                        mendukung multi-role (Admin, Guru, Siswa) dengan fitur timer real-time, anti-cheat,
                        bank soal, dan analitik nilai.
                    </p>
                </div>
                <div class="mp-tags">
                    <span class="mp-tag">Laravel</span>
                    <span class="mp-tag">PHP</span>
                    <span class="mp-tag mp-tag-green">MySQL</span>
                    <span class="mp-tag mp-tag-orange">Bootstrap 5</span>
                    <span class="mp-tag">Multi-Role</span>
                    <span class="mp-tag mp-tag-green">Live</span>
                </div>

                {{-- Feature grid --}}
                <div class="mp-features">
                    <div class="mp-feat-item">
                        <div class="mp-feat-icon"><i class="bi bi-shield-lock-fill"></i></div>
                        <div class="mp-feat-title">Multi-Role Auth</div>
                        <div class="mp-feat-desc">Admin, Guru & Siswa dengan akses berbeda</div>
                    </div>
                    <div class="mp-feat-item">
                        <div class="mp-feat-icon"><i class="bi bi-stopwatch-fill"></i></div>
                        <div class="mp-feat-title">Timer Real-time</div>
                        <div class="mp-feat-desc">Countdown & auto-submit saat waktu habis</div>
                    </div>
                    <div class="mp-feat-item">
                        <div class="mp-feat-icon"><i class="bi bi-bar-chart-line-fill"></i></div>
                        <div class="mp-feat-title">Analitik Nilai</div>
                        <div class="mp-feat-desc">Grafik & statistik performa siswa</div>
                    </div>
                    <div class="mp-feat-item">
                        <div class="mp-feat-icon"><i class="bi bi-camera-video-fill"></i></div>
                        <div class="mp-feat-title">Anti-Cheat</div>
                        <div class="mp-feat-desc">Monitoring tab & fullscreen enforcement</div>
                    </div>
                </div>
            </div>

            {{-- Slider utama --}}
            <div class="mp-slider-wrap" data-aos="fade-up" data-aos-delay="150">

                {{-- Progress bar --}}
                <div class="mp-progress"><div class="mp-progress-bar" id="mp-prog"></div></div>

                {{-- Browser chrome --}}
                <div class="mp-slider-chrome">
                    <span class="mp-dot-r"></span>
                    <span class="mp-dot-y"></span>
                    <span class="mp-dot-g"></span>
                    <div class="mp-url-bar">
                        <span class="mp-url-text" id="mp-url-text">simoro.sman5morotai.sch.id</span>
                    </div>
                </div>

                {{-- Slide track --}}
                <div class="mp-slide-track-wrap" id="mp-track-wrap">
                    <div class="mp-slide-track" id="mp-track">

                        {{-- 
                            =========================================================
                            SLIDE DEFAULT: gambar dari asset folder
                            Ganti path sesuai nama file lo di /assets/img/simoro/
                            Tambah/hapus <div class="mp-slide"> sesuai kebutuhan
                            =========================================================
                        --}}

                        <div class="mp-slide">
                            <img src="{{ asset('assets/img/simoro/mobile.png') }}" alt="Mobile SIMORO" loading="lazy"
                                 onerror="this.closest('.mp-slide').querySelector('.mp-slide-placeholder').style.display='flex'; this.style.display='none';">
                            <div class="mp-slide-placeholder" style="display:none; flex-direction:column; align-items:center; gap:8px; color:var(--text-muted);">
                                <i class="bi bi-image" style="font-size:2rem; opacity:.4;"></i>
                                <span style="font-size:.75rem;">mobile.png</span>
                            </div>
                            <div class="mp-slide-label">Tampilan Mobile</div>
                        </div>

                        <div class="mp-slide">
                            <img src="{{ asset('assets/img/simoro/mobile1.png') }}" alt="Halaman mobile" loading="lazy"
                                 onerror="this.closest('.mp-slide').querySelector('.mp-slide-placeholder').style.display='flex'; this.style.display='none';">
                            <div class="mp-slide-placeholder" style="display:none; flex-direction:column; align-items:center; gap:8px; color:var(--text-muted);">
                                <i class="bi bi-image" style="font-size:2rem; opacity:.4;"></i>
                                <span style="font-size:.75rem;">mobile1.png</span>
                            </div>
                            <div class="mp-slide-label">Tampilan Mobile</div>
                        </div>

                        <div class="mp-slide">
                            <img src="{{ asset('assets/img/simoro/ujian.png') }}" alt="Halaman Ujian" loading="lazy"
                                 onerror="this.closest('.mp-slide').querySelector('.mp-slide-placeholder').style.display='flex'; this.style.display='none';">
                            <div class="mp-slide-placeholder" style="display:none; flex-direction:column; align-items:center; gap:8px; color:var(--text-muted);">
                                <i class="bi bi-image" style="font-size:2rem; opacity:.4;"></i>
                                <span style="font-size:.75rem;">ujian.png</span>
                            </div>
                            <div class="mp-slide-label">Halaman Ujian</div>
                        </div>

                        <div class="mp-slide">
                            <img src="{{ asset('assets/img/simoro/soal.png') }}" alt="Bank Soal" loading="lazy"
                                 onerror="this.closest('.mp-slide').querySelector('.mp-slide-placeholder').style.display='flex'; this.style.display='none';">
                            <div class="mp-slide-placeholder" style="display:none; flex-direction:column; align-items:center; gap:8px; color:var(--text-muted);">
                                <i class="bi bi-image" style="font-size:2rem; opacity:.4;"></i>
                                <span style="font-size:.75rem;">soal.png</span>
                            </div>
                            <div class="mp-slide-label">Bank Soal</div>
                        </div>

                        <div class="mp-slide">
                            <img src="{{ asset('assets/img/simoro/nilai.png') }}" alt="Rekap Nilai" loading="lazy"
                                 onerror="this.closest('.mp-slide').querySelector('.mp-slide-placeholder').style.display='flex'; this.style.display='none';">
                            <div class="mp-slide-placeholder" style="display:none; flex-direction:column; align-items:center; gap:8px; color:var(--text-muted);">
                                <i class="bi bi-image" style="font-size:2rem; opacity:.4;"></i>
                                <span style="font-size:.75rem;">nilai.png</span>
                            </div>
                            <div class="mp-slide-label">Rekap Nilai</div>
                        </div>

                        <div class="mp-slide">
                            <img src="{{ asset('assets/img/simoro/guru.png') }}" alt="Panel Guru" loading="lazy"
                                 onerror="this.closest('.mp-slide').querySelector('.mp-slide-placeholder').style.display='flex'; this.style.display='none';">
                            <div class="mp-slide-placeholder" style="display:none; flex-direction:column; align-items:center; gap:8px; color:var(--text-muted);">
                                <i class="bi bi-image" style="font-size:2rem; opacity:.4;"></i>
                                <span style="font-size:.75rem;">guru.png</span>
                            </div>
                            <div class="mp-slide-label">Panel Guru</div>
                        </div>

                        <div class="mp-slide">
                            <img src="{{ asset('assets/img/simoro/admin.png') }}" alt="Panel Admin" loading="lazy"
                                 onerror="this.closest('.mp-slide').querySelector('.mp-slide-placeholder').style.display='flex'; this.style.display='none';">
                            <div class="mp-slide-placeholder" style="display:none; flex-direction:column; align-items:center; gap:8px; color:var(--text-muted);">
                                <i class="bi bi-image" style="font-size:2rem; opacity:.4;"></i>
                                <span style="font-size:.75rem;">admin.png</span>
                            </div>
                            <div class="mp-slide-label">Panel Admin</div>
                        </div>

                        <div class="mp-slide">
                            <img src="{{ asset('assets/img/simoro/mobile.png') }}" alt="Tampilan Mobile" loading="lazy"
                                 onerror="this.closest('.mp-slide').querySelector('.mp-slide-placeholder').style.display='flex'; this.style.display='none';">
                            <div class="mp-slide-placeholder" style="display:none; flex-direction:column; align-items:center; gap:8px; color:var(--text-muted);">
                                <i class="bi bi-image" style="font-size:2rem; opacity:.4;"></i>
                                <span style="font-size:.75rem;">mobile.png</span>
                            </div>
                            <div class="mp-slide-label">Tampilan Mobile</div>
                        </div>

                        {{-- Tambahkan slide baru di sini —
                             copy paste blok <div class="mp-slide"> di atas --}}

                    </div>

                    {{-- Prev / Next --}}
                    <button class="mp-slide-btn mp-slide-btn-prev" id="mp-prev" aria-label="Sebelumnya">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="mp-slide-btn mp-slide-btn-next" id="mp-next" aria-label="Selanjutnya">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>

                {{-- Dots --}}
                <div class="mp-dots" id="mp-dots"></div>

            </div>{{-- /mp-slider-wrap --}}

        </div>{{-- /mp-card --}}
    </div>
</section>
{{-- ===== END MY PROJECT ===== --}}

        <!-- CONTACT -->
        <section id="contact">
            <div class="container section-title text-center" data-aos="fade-up">
                <h2>Kontak</h2>
                <p>Hubungi kami</p>
            </div>
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-lg-5">
                        <div class="row gy-3 h-100">
                            @php
                                $contacts = [
                                    ['icon' => 'bi-geo-alt',  'title' => 'Alamat',    'lines' => ['SMA Negeri 5 Morotai', 'Kabupaten Pulau Morotai, Maluku Utara'], 'delay' => 200],
                                    ['icon' => 'bi-telephone','title' => 'Telepon',   'lines' => ['+62 123 4567 890', '+62 987 6543 210'], 'delay' => 300],
                                    ['icon' => 'bi-envelope', 'title' => 'Email',     'lines' => ['info@sman5morotai.sch.id', 'ujian@sman5morotai.sch.id'], 'delay' => 400],
                                    ['icon' => 'bi-clock',    'title' => 'Jam Kerja', 'lines' => ['Senin - Jumat', '07:00 - 16:00 WIT'], 'delay' => 500],
                                ];
                            @endphp
                            @foreach($contacts as $c)
                            <div class="col-md-6 col-lg-12" data-aos="fade" data-aos-delay="{{ $c['delay'] }}">
                                <div class="contact-info-card">
                                    <i class="bi {{ $c['icon'] }}"></i>
                                    <div>
                                        <h3>{{ $c['title'] }}</h3>
                                        @foreach($c['lines'] as $line)
                                            <p>{{ $line }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">
                        <form action="#" method="post" class="contact-form">
                            <div class="row gy-3">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="subject" class="form-control" placeholder="Subjek" required>
                                </div>
                                <div class="col-12">
                                    <textarea name="message" rows="6" class="form-control" placeholder="Pesan" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-submit w-100 w-md-auto">
                                        <i class="bi bi-send me-2"></i>Kirim Pesan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer id="footer">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4 col-md-6">
                    <a href="{{ url('/') }}" class="d-flex align-items-center mb-3">
                        <img src="{{ asset('assets/frondend/assets/img/logo.png') }}" alt="Logo" style="max-height: 36px;">
                        <span style="font-family: 'Manrope', sans-serif; font-size: 1.1rem; font-weight: 800; color: #fff; margin-left: 10px;">SIMORO SMANLI</span>
                    </a>
                    <p>SMA Negeri 5 Morotai<br>Kabupaten Pulau Morotai, Maluku Utara</p>
                    <p class="mt-2"><strong style="color: rgba(255,255,255,0.6);">Phone:</strong> +62 123 4567 890</p>
                    <p><strong style="color: rgba(255,255,255,0.6);">Email:</strong> info@sman5morotai.sch.id</p>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Tautan Cepat</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i><a href="#hero">Beranda</a></li>
                        <li><i class="bi bi-chevron-right"></i><a href="#about">Tentang</a></li>
                        <li><i class="bi bi-chevron-right"></i><a href="#services">Layanan</a></li>
                        <li><i class="bi bi-chevron-right"></i><a href="#my-project">My Project</a></li>
                        <li><i class="bi bi-chevron-right"></i><a href="#contact">Kontak</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Layanan</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i><a href="#">Ujian Online</a></li>
                        <li><i class="bi bi-chevron-right"></i><a href="#">Data Siswa</a></li>
                        <li><i class="bi bi-chevron-right"></i><a href="#">Raport Digital</a></li>
                        <li><i class="bi bi-chevron-right"></i><a href="#">E-Learning</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <h4>Ikuti Kami</h4>
                    <p>Tetap terhubung dengan kami melalui media sosial.</p>
                    <div class="footer-social mt-3">
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                © Copyright <strong>SIMORO SMANLI</strong> All Rights Reserved ·
                <a href="#">SMA Negeri 5 Morotai</a>
            </div>
        </div>
    </footer>

    <a href="#" id="scroll-top"><i class="bi bi-arrow-up-short"></i></a>

    <!-- BOTTOM NAV BAR (mobile only) -->
    <nav id="sm-bottom-nav">
        <a href="#hero" class="sm-bnav-item active" data-section="hero">
            <i class="bi bi-house-fill"></i>
            <span>Beranda</span>
        </a>
        <a href="#about" class="sm-bnav-item" data-section="about">
            <i class="bi bi-info-circle-fill"></i>
            <span>Tentang</span>
        </a>

        @auth
        <a href="{{ url('/dashboard') }}" class="sm-bnav-item sm-bnav-center" id="sm-bnav-cta">
            <div class="sm-bnav-fab">
                <i class="bi bi-speedometer2"></i>
            </div>
            <span>Dashboard</span>
        </a>
        @else
        <a href="{{ route('login') }}" class="sm-bnav-item sm-bnav-center" id="sm-bnav-cta">
            <div class="sm-bnav-fab">
                <i class="bi bi-box-arrow-in-right"></i>
            </div>
            <span>Login</span>
        </a>
        @endauth

        <a href="#services" class="sm-bnav-item" data-section="services">
            <i class="bi bi-grid-fill"></i>
            <span>Layanan</span>
        </a>
        <a href="#contact" class="sm-bnav-item" data-section="contact">
            <i class="bi bi-envelope-fill"></i>
            <span>Kontak</span>
        </a>
    </nav>

    <script src="{{ asset('assets/frondend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frondend/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/frondend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/frondend/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/frondend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frondend/assets/js/main.js') }}"></script>

    {{-- ===================== SCRIPT ASLI (tidak diubah) ===================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // AOS
            if (typeof AOS !== 'undefined') AOS.init({ duration: 900, once: true });

            // HAMBURGER MENU
            var burger     = document.getElementById('sm-burger');
            var mobileMenu = document.getElementById('sm-mobile-menu');

            if (burger && mobileMenu) {
                burger.addEventListener('click', function (e) {
                    e.stopPropagation();
                    var isOpen = mobileMenu.classList.toggle('open');
                    burger.classList.toggle('open', isOpen);
                    burger.setAttribute('aria-expanded', String(isOpen));
                });

                mobileMenu.querySelectorAll('a').forEach(function (link) {
                    link.addEventListener('click', closeMenu);
                });

                document.addEventListener('click', function (e) {
                    if (!mobileMenu.contains(e.target) && !burger.contains(e.target)) {
                        closeMenu();
                    }
                });
            }

            function closeMenu() {
                if (mobileMenu) mobileMenu.classList.remove('open');
                if (burger) {
                    burger.classList.remove('open');
                    burger.setAttribute('aria-expanded', 'false');
                }
            }

            // ACTIVE NAV LINK ON SCROLL
            var allNavLinks = document.querySelectorAll('.sm-nav-link');
            var sections    = document.querySelectorAll('section[id]');

            window.addEventListener('scroll', function () {
                var scrollY = window.scrollY + 90;
                sections.forEach(function (section) {
                    if (scrollY >= section.offsetTop && scrollY < section.offsetTop + section.offsetHeight) {
                        allNavLinks.forEach(function (a) { a.classList.remove('active'); });
                        document.querySelectorAll('.sm-nav-link[href="#' + section.id + '"]')
                                .forEach(function (a) { a.classList.add('active'); });

                        document.querySelectorAll('.sm-bnav-item[data-section]').forEach(function (item) {
                            item.classList.toggle('active', item.getAttribute('data-section') === section.id);
                        });
                    }
                });
            });

        });
    </script>

    {{-- =====================================================
     ★ DARK MODE + SLIDER SCRIPT
     ===================================================== --}}
<script>
    // ── Dark Mode ──────────────────────────────────────────
    (function () {
        var html    = document.documentElement;
        var btn     = document.getElementById('dm-toggle');
        var STORAGE = 'simoro-theme';
        var saved   = localStorage.getItem(STORAGE);
        if (saved) html.setAttribute('data-theme', saved);
        if (btn) {
            btn.addEventListener('click', function () {
                var isDark = html.getAttribute('data-theme') === 'dark';
                var next   = isDark ? 'light' : 'dark';
                html.setAttribute('data-theme', next);
                localStorage.setItem(STORAGE, next);
            });
        }
    })();

    // ── Slider My Project ──────────────────────────────────
    (function () {
        var track    = document.getElementById('mp-track');
        var dotsWrap = document.getElementById('mp-dots');
        var prevBtn  = document.getElementById('mp-prev');
        var nextBtn  = document.getElementById('mp-next');
        var progBar  = document.getElementById('mp-prog');

        if (!track || !dotsWrap) return;

        var slides   = track.querySelectorAll('.mp-slide');
        var total    = slides.length;
        var current  = 0;
        var timer    = null;
        var INTERVAL = 3000; // 3 detik

        // Buat dots
        slides.forEach(function (_, i) {
            var dot = document.createElement('button');
            dot.className = 'mp-dot-ind' + (i === 0 ? ' active' : '');
            dot.setAttribute('aria-label', 'Slide ' + (i + 1));
            dot.addEventListener('click', function () { goTo(i); resetTimer(); });
            dotsWrap.appendChild(dot);
        });

        function updateDots() {
            dotsWrap.querySelectorAll('.mp-dot-ind').forEach(function (d, i) {
                d.classList.toggle('active', i === current);
            });
        }

        function goTo(idx) {
            current = (idx + total) % total;
            track.style.transform = 'translateX(-' + (current * 100) + '%)';
            updateDots();
            // reset progress bar
            if (progBar) {
                progBar.classList.remove('running');
                void progBar.offsetWidth; // reflow
                progBar.classList.add('running');
            }
        }

        function next() { goTo(current + 1); }
        function prev() { goTo(current - 1); }

        function startTimer() {
            timer = setInterval(next, INTERVAL);
        }

        function resetTimer() {
            clearInterval(timer);
            startTimer();
        }

        if (prevBtn) prevBtn.addEventListener('click', function () { prev(); resetTimer(); });
        if (nextBtn) nextBtn.addEventListener('click', function () { next(); resetTimer(); });

        // Touch/swipe support
        var touchStartX = 0;
        var trackWrap   = document.getElementById('mp-track-wrap');
        if (trackWrap) {
            trackWrap.addEventListener('touchstart', function (e) {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });
            trackWrap.addEventListener('touchend', function (e) {
                var diff = touchStartX - e.changedTouches[0].screenX;
                if (Math.abs(diff) > 40) {
                    diff > 0 ? next() : prev();
                    resetTimer();
                }
            }, { passive: true });
        }

        // Pause on hover
        var sliderWrap = document.querySelector('.mp-slider-wrap');
        if (sliderWrap) {
            sliderWrap.addEventListener('mouseenter', function () { clearInterval(timer); if (progBar) { progBar.classList.remove('running'); } });
            sliderWrap.addEventListener('mouseleave', function () { startTimer(); });
        }

        // Mulai
        goTo(0);
        startTimer();
    })();
</script>

</body>
</html>
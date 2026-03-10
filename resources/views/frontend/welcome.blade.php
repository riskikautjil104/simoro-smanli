<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="SIMORO SMANLI - Sistem Ujian Online SMA Negeri 5 Morotai">
    <meta name="keywords" content="ujian online, sekolah, SMA, Morotai, pendidikan">

    <title>{{ config('app.name', 'SIMORO SMANLI') }} - SMA Negeri 5 Morotai</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/frondend/assets/img/favicon.svg') }}" rel="icon"  type="image/svg+xml" >
    <link href="{{ asset('assets/frondend/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/frondend/assets/img/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/frondend/assets/img/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/frondend/assets/img/favicon-16x16.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/frondend/assets/img/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('assets/frondend/assets/img/site.webmanifest') }}">

<link rel="icon" type="image/png" href="{{ asset('assets/frondend/assets/img/favicon-96x96.png') }}" sizes="96x96" />
{{-- <link rel="icon" type="image/svg+xml" href="/favicon.svg" /> --}}
<link rel="shortcut icon" href="{{ asset('assets/frondend/assets/img/favicon.ico') }}" />
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/frondend/assets/img/apple-touch-icon.png') }}" />
<link rel="manifest" href="{{asset('assets/frondend/assets/img/site.webmanifest') }}" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/frondend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frondend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frondend/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frondend/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frondend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/frondend/assets/css/main.css') }}" rel="stylesheet">

    <style>
        /* =============================================
           CSS VARIABLES — single source of truth
        ============================================= */
        :root {
            --primary: #0d6efd;
            --primary-dark: #0a58ca;
            --secondary: #20c997;
            --accent: #0dcaf0;
            --bg-light: #f8f9fa;
            --text-muted: #6c757d;
            --radius-card: 16px;
            --radius-btn: 50px;
            --shadow-card: 0 4px 16px rgba(0, 0, 0, 0.08);
            --shadow-card-hover: 0 12px 32px rgba(13, 110, 253, 0.18);
            --transition: all 0.3s ease;

            /* Soft service card colors */
            --svc-blue:   #e8f1ff;
            --svc-orange: #fff3e8;
            --svc-teal:   #e8f9f4;
            --svc-red:    #fdecea;
            --svc-indigo: #f0ebff;
            --svc-pink:   #fde8f3;

            --svc-blue-icon:   #0d6efd;
            --svc-orange-icon: #fd7e14;
            --svc-teal-icon:   #20c997;
            --svc-red-icon:    #dc3545;
            --svc-indigo-icon: #6610f2;
            --svc-pink-icon:   #e83e8c;
        }

        * { font-family: 'Poppins', sans-serif; }

        /* =============================================
           NAVBAR — fixed, responsive
        ============================================= */
        #header {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(12px);
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            height: 70px;
            z-index: 1000;
        }

        /* =============================================
           NAVBAR CUSTOM (sm-header) — bebas dari main.js
        ============================================= */
        #sm-header {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 9999;
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        }

        .sm-header-inner {
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 24px;
            height: 68px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* Logo */
        .sm-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
            margin-right: auto;
        }

        .sm-logo img  { height: 36px; width: auto; }
        .sm-logo span { font-size: 1.1rem; font-weight: 700; color: var(--primary); white-space: nowrap; }

        /* Desktop nav */
        #sm-nav { display: flex; align-items: center; }

        #sm-nav-list {
            display: flex;
            list-style: none;
            margin: 0; padding: 0;
            gap: 2px;
        }

        #sm-nav-list li a {
            display: block;
            padding: 8px 14px;
            font-size: 0.88rem;
            font-weight: 500;
            color: #444;
            text-decoration: none;
            border-radius: 8px;
            transition: var(--transition);
            white-space: nowrap;
        }

        #sm-nav-list li a:hover,
        #sm-nav-list li a.active {
            color: var(--primary);
            background: rgba(13,110,253,0.08);
        }

        /* Header right actions */
        .sm-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        /* Hamburger button */
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
            border-radius: 8px;
            transition: background 0.2s;
            flex-shrink: 0;
        }

        #sm-burger:hover { background: rgba(13,110,253,0.08); }

        #sm-burger span {
            display: block;
            width: 22px;
            height: 2px;
            background: var(--primary);
            border-radius: 2px;
            transition: all 0.3s ease;
            transform-origin: center;
        }

        /* Burger → X animation */
        #sm-burger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        #sm-burger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        #sm-burger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* Mobile dropdown menu */
        #sm-mobile-menu {
            display: none;
            background: #fff;
            border-top: 1px solid rgba(13,110,253,0.1);
            box-shadow: 0 12px 32px rgba(0,0,0,0.12);
        }

        #sm-mobile-menu.open { display: block; animation: smSlideDown 0.22s ease; }

        @keyframes smSlideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        #sm-mobile-menu ul {
            list-style: none;
            margin: 0;
            padding: 12px 20px 16px;
        }

        #sm-mobile-menu ul li a {
            display: block;
            padding: 13px 16px;
            font-size: 0.95rem;
            font-weight: 500;
            color: #333;
            text-decoration: none;
            border-radius: 10px;
            transition: var(--transition);
        }

        #sm-mobile-menu ul li a:hover {
            background: rgba(13,110,253,0.08);
            color: var(--primary);
        }

        /* Responsive breakpoints */
        @media (max-width: 1199px) {
            #sm-nav      { display: none; }   /* sembunyikan nav desktop */
            #sm-burger   { display: flex; }    /* tampilkan hamburger */
        }

        @media (max-width: 480px) {
            .sm-logo span { font-size: 0.95rem; }
            .sm-header-inner { padding: 0 16px; gap: 10px; }
        }

        /* =============================================
           BUTTONS — consistent across all instances
        ============================================= */
        .btn-school {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff !important;
            border: none;
            padding: 10px 24px;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: var(--radius-btn);
            text-decoration: none !important;
            transition: var(--transition);
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-school:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(13, 110, 253, 0.35);
            color: #fff !important;
        }

        .btn-school:active { transform: translateY(0); }

        .btn-outline-school {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: transparent;
            color: #fff !important;
            border: 2px solid rgba(255,255,255,0.8);
            padding: 10px 24px;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: var(--radius-btn);
            text-decoration: none !important;
            transition: var(--transition);
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-outline-school:hover {
            background: #fff;
            color: var(--primary) !important;
            border-color: #fff;
            transform: translateY(-2px);
        }

        /* Inverted btn-school (white bg, blue text) for dark sections */
        .btn-school-inverted {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            color: var(--primary) !important;
            border: none;
            padding: 12px 32px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: var(--radius-btn);
            text-decoration: none !important;
            transition: var(--transition);
            cursor: pointer;
        }

        .btn-school-inverted:hover {
            background: #e8f1ff;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }

        /* =============================================
           CARDS — one consistent hover for ALL cards
        ============================================= */
        .feature-card {
            background: #fff;
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(0,0,0,0.05);
            transition: var(--transition);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-card-hover);
        }

        /* =============================================
           FEATURE ICON — consistent size & style
        ============================================= */
        .feature-icon {
            width: 72px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            font-size: 1.8rem;
            margin: 0 auto 1.25rem;
            flex-shrink: 0;
        }

        /* =============================================
           SERVICE CARDS — soft harmonious colors
        ============================================= */
        .svc-icon {
            width: 72px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1.8rem;
            margin: 0 auto 1.25rem;
        }

        .svc-blue   { background: var(--svc-blue);   color: var(--svc-blue-icon); }
        .svc-orange { background: var(--svc-orange); color: var(--svc-orange-icon); }
        .svc-teal   { background: var(--svc-teal);   color: var(--svc-teal-icon); }
        .svc-red    { background: var(--svc-red);     color: var(--svc-red-icon); }
        .svc-indigo { background: var(--svc-indigo); color: var(--svc-indigo-icon); }
        .svc-pink   { background: var(--svc-pink);   color: var(--svc-pink-icon); }

        /* =============================================
           SECTION TITLES
        ============================================= */
        .section-title { text-align: center; margin-bottom: 3rem; padding-top: 3rem; }
        .section-title h2 { font-size: 2.2rem; font-weight: 700; margin-bottom: 0.5rem; }
        .section-title p  { color: var(--text-muted); font-size: 1rem; margin: 0; }

        /* =============================================
           HERO — with wave + animations
        ============================================= */
        #hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, rgba(13,110,253,0.95) 0%, rgba(13,202,240,0.88) 100%),
                        url('{{ asset('assets/frondend/assets/img/hero-bg.png') }}') center/cover no-repeat;
            color: #fff;
            padding-top: 68px;
            padding-bottom: 80px;
            position: relative;
            overflow: hidden;
        }

        /* Decorative floating circles */
        #hero::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
            top: -100px; right: -150px;
            pointer-events: none;
            animation: floatCircle 8s ease-in-out infinite;
        }

        #hero::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            bottom: 80px; left: -80px;
            pointer-events: none;
            animation: floatCircle 10s ease-in-out infinite reverse;
        }

        @keyframes floatCircle {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-24px) scale(1.04); }
        }

        #hero .container { position: relative; z-index: 2; }

        /* Hero text animations */
        .hero-text-wrap { opacity: 0; animation: heroFadeUp 0.8s ease 0.2s forwards; }
        .hero-text-wrap h1 { font-size: 2.8rem; font-weight: 700; line-height: 1.2; }
        .hero-text-wrap p  { font-size: 1.1rem; opacity: 0.92; }

        .hero-sub  { opacity: 0; animation: heroFadeUp 0.8s ease 0.45s forwards; }
        .hero-btns { opacity: 0; animation: heroFadeUp 0.8s ease 0.65s forwards; }

        @keyframes heroFadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Hero image float animation */
        .hero-img-wrap {
            opacity: 0;
            animation: heroImgIn 1s ease 0.3s forwards;
        }

        .hero-img-wrap img {
            animation: heroFloat 5s ease-in-out 1.3s infinite;
        }

        @keyframes heroImgIn {
            from { opacity: 0; transform: scale(0.88) translateY(20px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        @keyframes heroFloat {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-14px); }
        }

        /* Wave divider */
        .hero-wave {
            position: absolute;
            bottom: 0; left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            z-index: 3;
        }

        .hero-wave svg {
            display: block;
            width: calc(100% + 2px);
            height: 72px;
        }

        /* Wave path animation */
        .hero-wave .wave-path {
            animation: waveShift 6s ease-in-out infinite;
        }

        .hero-wave .wave-path-2 {
            animation: waveShift 8s ease-in-out infinite reverse;
            opacity: 0.4;
        }

        @keyframes waveShift {
            0%, 100% { d: path("M0,40 C150,80 350,0 600,35 C850,70 1050,10 1200,40 L1200,72 L0,72 Z"); }
            50%       { d: path("M0,55 C180,10 370,65 600,30 C830,0 1020,60 1200,45 L1200,72 L0,72 Z"); }
        }

        @media (max-width: 768px) {
            .hero-text-wrap h1 { font-size: 2rem; }
            #hero { padding-bottom: 60px; }
            .hero-wave svg { height: 48px; }
        }

        /* =============================================
           STATS
        ============================================= */
        #stats {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            padding: 64px 0;
        }

        .stats-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 28px 24px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 16px;
            height: 100%;
        }

        .stats-card i        { font-size: 2.6rem; flex-shrink: 0; }
        .stats-card .num     { font-size: 2.2rem; font-weight: 700; line-height: 1; display: block; }
        .stats-card .label   { font-size: 0.9rem; opacity: 0.88; margin: 0; }

        /* =============================================
           ABOUT
        ============================================= */
        #about { padding: 80px 0; }

        .btn-read-more {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: #fff !important;
            padding: 12px 28px;
            border-radius: var(--radius-btn);
            font-weight: 600;
            text-decoration: none !important;
            transition: var(--transition);
        }

        .btn-read-more:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
        }

        /* =============================================
           FEATURES
        ============================================= */
        #features { padding: 80px 0; }

        .feature-box {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border-radius: 10px;
            transition: var(--transition);
        }

        .feature-box:hover { background: var(--bg-light); }

        .feature-box i  { font-size: 1.4rem; flex-shrink: 0; }
        .feature-box h3 { margin: 0; font-size: 0.95rem; font-weight: 600; }

        /* =============================================
           SERVICES
        ============================================= */
        #services { background: var(--bg-light); padding: 80px 0; }

        .service-card {
            padding: 36px 28px;
            text-align: center;
        }

        .service-card h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: 10px; }
        .service-card p  { font-size: 0.9rem; color: var(--text-muted); margin: 0; }

        /* =============================================
           CALL TO ACTION
        ============================================= */
        #call-to-action {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            padding: 80px 0;
            text-align: center;
            color: #fff;
        }

        #call-to-action h2 { font-size: 2.2rem; font-weight: 700; margin-bottom: 16px; }
        #call-to-action p  { font-size: 1.05rem; opacity: 0.9; margin-bottom: 28px; }

        /* =============================================
           EXAM CARDS (Recent + Active)
        ============================================= */
        #recent-exams  { padding: 80px 0; }
        #active-exams  { background: var(--bg-light); padding: 80px 0; }

        .exam-card {
            padding: 28px 24px;
            text-align: center;
        }

        .exam-card h3     { font-size: 1.05rem; font-weight: 700; margin-bottom: 10px; }
        .exam-card .meta  { font-size: 0.9rem; color: var(--text-muted); margin-bottom: 6px; }
        .exam-card .badge-active {
            display: inline-block;
            background: var(--secondary);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 14px;
            border-radius: 20px;
            margin-bottom: 14px;
            letter-spacing: 0.5px;
        }

        .btn-exam {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff !important;
            border: none;
            padding: 10px 22px;
            font-size: 0.88rem;
            font-weight: 600;
            border-radius: var(--radius-btn);
            text-decoration: none !important;
            transition: var(--transition);
            margin-top: 14px;
        }

        .btn-exam:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.3);
        }

        .btn-exam-success {
            background: var(--secondary);
        }

        .btn-exam-success:hover {
            box-shadow: 0 6px 20px rgba(32, 201, 151, 0.35);
        }

        /* Active exam card accent border */
        .exam-card-active {
            border-left: 4px solid var(--secondary) !important;
        }

        /* =============================================
           CONTACT
        ============================================= */
        #contact { padding: 80px 0; }

        .info-item {
            padding: 28px 24px;
            background: var(--bg-light);
            border-radius: 12px;
            text-align: center;
            height: 100%;
        }

        .info-item i  { font-size: 1.8rem; color: var(--primary); display: block; margin-bottom: 12px; }
        .info-item h3 { font-size: 1rem; font-weight: 700; margin-bottom: 8px; }
        .info-item p  { font-size: 0.9rem; color: var(--text-muted); margin: 0; line-height: 1.7; }

        .contact-form {
            background: var(--bg-light);
            padding: 36px 32px;
            border-radius: var(--radius-card);
        }

        .contact-form .form-control {
            padding: 12px 16px;
            border-radius: 10px;
            border: 1.5px solid #e0e0e0;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }

        .contact-form .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
            border: none;
            padding: 13px 40px;
            border-radius: var(--radius-btn);
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(13, 110, 253, 0.35);
        }

        /* =============================================
           FOOTER
        ============================================= */
        #footer {
            background: #111827;
            color: rgba(255,255,255,0.75);
            padding-top: 60px;
        }

        #footer h4 { color: #fff; font-weight: 700; margin-bottom: 16px; font-size: 1rem; }
        #footer p  { font-size: 0.88rem; line-height: 1.7; }

        .footer-links ul { list-style: none; padding: 0; margin: 0; }
        .footer-links ul li { margin-bottom: 8px; font-size: 0.88rem; }
        .footer-links ul li a { color: rgba(255,255,255,0.65); text-decoration: none; transition: color 0.2s; }
        .footer-links ul li a:hover { color: var(--accent); }
        .footer-links ul li i { color: var(--accent); margin-right: 6px; font-size: 0.75rem; }

        .footer-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: var(--transition);
            margin-right: 8px;
        }

        .footer-social a:hover {
            background: var(--accent);
            color: #fff;
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 20px 0;
            margin-top: 48px;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.45);
            text-align: center;
        }

        .footer-bottom a { color: var(--accent); text-decoration: none; }

        /* =============================================
           SCROLL TOP
        ============================================= */
        #scroll-top {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            text-decoration: none;
            z-index: 9999;
            transition: var(--transition);
            box-shadow: 0 4px 14px rgba(13,110,253,0.35);
        }

        #scroll-top:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(13,110,253,0.4); }

        /* =============================================
           BOTTOM NAV BAR — mobile only
        ============================================= */
        #sm-bottom-nav {
            display: none; /* hidden on desktop */
        }

        @media (max-width: 1199px) {
            #sm-bottom-nav {
                display: flex;
                position: fixed;
                bottom: 0; left: 0; right: 0;
                z-index: 9998;
                background: rgba(255,255,255,0.97);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border-top: 1px solid rgba(0,0,0,0.07);
                box-shadow: 0 -4px 24px rgba(0,0,0,0.1);
                padding: 0 8px;
                padding-bottom: env(safe-area-inset-bottom, 0px); /* iPhone notch support */
                height: calc(60px + env(safe-area-inset-bottom, 0px));
                align-items: stretch;
                justify-content: space-around;
            }

            .sm-bnav-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                flex: 1;
                gap: 3px;
                text-decoration: none;
                color: #aaa;
                font-size: 0.65rem;
                font-weight: 500;
                padding: 8px 4px;
                transition: color 0.2s ease;
                position: relative;
            }

            .sm-bnav-item i {
                font-size: 1.25rem;
                transition: transform 0.2s ease, color 0.2s ease;
            }

            .sm-bnav-item:hover,
            .sm-bnav-item.active {
                color: var(--primary);
            }

            .sm-bnav-item.active i {
                transform: translateY(-2px);
            }

            /* Active indicator dot */
            .sm-bnav-item.active::after {
                content: '';
                position: absolute;
                bottom: 6px;
                width: 4px; height: 4px;
                background: var(--primary);
                border-radius: 50%;
            }

            /* Center FAB button */
            .sm-bnav-center {
                flex: 1.2;
                margin-top: -18px;
                z-index: 1;
            }

            .sm-bnav-fab {
                width: 50px; height: 50px;
                background: linear-gradient(135deg, var(--primary), var(--accent));
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.3rem;
                box-shadow: 0 6px 20px rgba(13,110,253,0.45);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                margin-bottom: 2px;
            }

            .sm-bnav-center:hover .sm-bnav-fab,
            .sm-bnav-center.active .sm-bnav-fab {
                transform: translateY(-4px) scale(1.08);
                box-shadow: 0 10px 28px rgba(13,110,253,0.55);
            }

            .sm-bnav-center span { color: var(--primary); font-weight: 600; }

            /* Push footer content up so bottom nav doesn't cover it */
            body { padding-bottom: calc(60px + env(safe-area-inset-bottom, 0px)); }

            /* Hide scroll-top button on mobile (bottom nav takes over) */
            #scroll-top { display: none !important; }
        }
    </style>
    <!-- 
  ================================================================
  SIMORO SMANLI — PREMIUM STYLE PATCH
  Paste CSS ini ke dalam <style> yang sudah ada (setelah semua 
  CSS yang lama, sebelum penutup </style>)
  ================================================================
-->
<style>
/* ================================================================
   GLOBAL ENHANCEMENTS — noise texture + refined feel
================================================================ */

/* Subtle noise overlay on body for "expensive paper" feel */
body::before {
    content: '';
    position: fixed;
    inset: 0;
    z-index: 0;
    pointer-events: none;
    opacity: 0.018;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
    background-size: 180px;
}

/* Ensure all sections sit above the noise */
section, header, footer, main { position: relative; z-index: 1; }

/* ================================================================
   HEADER — refined glass morphism
================================================================ */
#sm-header {
    background: rgba(255, 255, 255, 0.88) !important;
    backdrop-filter: blur(20px) saturate(180%) !important;
    -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
    border-bottom: 1px solid rgba(13, 110, 253, 0.08);
    box-shadow: 0 1px 0 rgba(255,255,255,0.9), 0 4px 24px rgba(0,0,0,0.05) !important;
}

/* ================================================================
   HERO — premium layered background
================================================================ */
#hero {
    background:
        /* Dot grid pattern */
        radial-gradient(circle, rgba(255,255,255,0.12) 1px, transparent 1px),
        /* Diagonal lines */
        repeating-linear-gradient(
            -45deg,
            transparent,
            transparent 40px,
            rgba(255,255,255,0.03) 40px,
            rgba(255,255,255,0.03) 41px
        ),
        /* Main gradient */
        linear-gradient(135deg, rgba(13,110,253,0.97) 0%, rgba(6,182,212,0.92) 60%, rgba(13,202,240,0.88) 100%) !important;
    background-size: 28px 28px, 100% 100%, 100% 100% !important;
}

/* Glowing orb accents */
#hero .container::before {
    content: '';
    position: absolute;
    width: 420px; height: 420px;
    background: radial-gradient(circle, rgba(255,255,255,0.14) 0%, transparent 70%);
    border-radius: 50%;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
    z-index: 0;
}

/* Floating hexagon decorations */
#hero::before {
    content: '';
    position: absolute;
    width: 600px; height: 600px;
    background: 
        radial-gradient(circle at 30% 30%, rgba(255,255,255,0.08) 0%, transparent 50%),
        radial-gradient(circle at 70% 70%, rgba(13,202,240,0.15) 0%, transparent 50%);
    border-radius: 50%;
    top: -150px; right: -200px;
    pointer-events: none;
    animation: floatCircle 8s ease-in-out infinite;
}

/* Extra decorative rings */
#hero .container::after {
    content: '';
    position: absolute;
    width: 220px; height: 220px;
    border: 1.5px solid rgba(255,255,255,0.15);
    border-radius: 50%;
    bottom: -30px; left: -60px;
    pointer-events: none;
    z-index: 0;
    animation: ringPulse 6s ease-in-out infinite;
}

@keyframes ringPulse {
    0%, 100% { transform: scale(1); opacity: 0.6; }
    50% { transform: scale(1.12); opacity: 0.25; }
}

/* Badge chip above title */
.hero-text-wrap::before {
    content: '✦ Sistem Ujian Digital';
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.18);
    border: 1px solid rgba(255,255,255,0.35);
    color: #fff;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 6px 16px;
    border-radius: 100px;
    margin-bottom: 18px;
    backdrop-filter: blur(8px);
    display: block;
    width: fit-content;
}

/* Enhanced wave — 3 layers */
.hero-wave {
    filter: drop-shadow(0 -4px 12px rgba(13,110,253,0.12));
}

.hero-wave svg {
    height: 90px !important;
}

/* ================================================================
   STATS — richer gradient + pattern
================================================================ */
#stats {
    background:
        radial-gradient(circle at 20% 50%, rgba(255,255,255,0.06) 0%, transparent 50%),
        radial-gradient(circle at 80% 50%, rgba(13,202,240,0.2) 0%, transparent 50%),
        repeating-linear-gradient(
            90deg,
            transparent,
            transparent 60px,
            rgba(255,255,255,0.025) 60px,
            rgba(255,255,255,0.025) 61px
        ),
        linear-gradient(135deg, var(--primary), #0ea5e9, var(--accent)) !important;
}

.stats-card {
    background: rgba(255,255,255,0.12) !important;
    border: 1px solid rgba(255,255,255,0.22) !important;
    backdrop-filter: blur(16px) !important;
    position: relative;
    overflow: hidden;
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
}

.stats-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 60%);
    border-radius: inherit;
    pointer-events: none;
}

.stats-card:hover {
    transform: translateY(-6px) scale(1.03);
    background: rgba(255,255,255,0.2) !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15), 0 0 0 1px rgba(255,255,255,0.3);
}

/* ================================================================
   ABOUT — elegant section separator
================================================================ */
#about {
    position: relative;
    overflow: hidden;
}

#about::before {
    content: '';
    position: absolute;
    top: -200px; right: -300px;
    width: 700px; height: 700px;
    background: radial-gradient(circle, rgba(13,110,253,0.04) 0%, transparent 65%);
    border-radius: 50%;
    pointer-events: none;
}

#about img {
    box-shadow: 
        0 2px 0 rgba(255,255,255,0.8) inset,
        0 32px 80px rgba(13,110,253,0.15),
        0 8px 24px rgba(0,0,0,0.08) !important;
    border: 1px solid rgba(13,110,253,0.08) !important;
}

/* ================================================================
   FEATURE CARDS — premium glass + shimmer
================================================================ */
.feature-card {
    border: 1px solid rgba(13,110,253,0.08) !important;
    background: #fff !important;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
}

/* Shimmer line on top */
.feature-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--primary), var(--accent), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.feature-card:hover::before {
    opacity: 1;
}

/* Subtle inner glow on hover */
.feature-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(13,110,253,0.03) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
    border-radius: inherit;
}

.feature-card:hover::after {
    opacity: 1;
}

.feature-card:hover {
    transform: translateY(-10px) !important;
    box-shadow: 0 24px 60px rgba(13,110,253,0.14), 0 4px 16px rgba(0,0,0,0.06) !important;
    border-color: rgba(13,110,253,0.18) !important;
}

/* ================================================================
   SERVICES SECTION — background pattern
================================================================ */
#services {
    background:
        radial-gradient(ellipse at 0% 0%, rgba(13,110,253,0.04) 0%, transparent 50%),
        radial-gradient(ellipse at 100% 100%, rgba(13,202,240,0.05) 0%, transparent 50%),
        linear-gradient(180deg,
            rgba(248,249,250,0) 0%,
            #f1f5ff 30%,
            #f0f9ff 70%,
            rgba(248,249,250,0) 100%
        ) !important;
    position: relative;
}

/* Decorative wave top edge */
#services::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, 
        transparent 0%,
        var(--primary) 20%,
        var(--accent) 50%,
        var(--primary) 80%,
        transparent 100%
    );
    opacity: 0.3;
}

/* ================================================================
   CALL TO ACTION — layered pattern
================================================================ */
#call-to-action {
    background:
        /* Concentric rings */
        radial-gradient(circle at 50% 50%, rgba(255,255,255,0.06) 0%, transparent 40%),
        radial-gradient(circle at 50% 50%, rgba(255,255,255,0.04) 0%, transparent 65%),
        /* Cross-hatch */
        repeating-linear-gradient(
            0deg,
            transparent,
            transparent 30px,
            rgba(255,255,255,0.03) 30px,
            rgba(255,255,255,0.03) 31px
        ),
        repeating-linear-gradient(
            90deg,
            transparent,
            transparent 30px,
            rgba(255,255,255,0.03) 30px,
            rgba(255,255,255,0.03) 31px
        ),
        linear-gradient(135deg, var(--primary), #0ea5e9, var(--accent)) !important;
    position: relative;
    overflow: hidden;
}

/* Glowing circles behind CTA */
#call-to-action::before {
    content: '';
    position: absolute;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(255,255,255,0.07) 0%, transparent 65%);
    border-radius: 50%;
    top: -200px; left: -100px;
    pointer-events: none;
}

#call-to-action::after {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 65%);
    border-radius: 50%;
    bottom: -160px; right: -80px;
    pointer-events: none;
}

/* Animated border ring around CTA button */
.btn-school-inverted {
    box-shadow: 0 0 0 0 rgba(255,255,255,0.4);
    animation: ctaPulse 3s ease-in-out infinite;
}

@keyframes ctaPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(255,255,255,0.4); }
    50% { box-shadow: 0 0 0 12px rgba(255,255,255,0); }
}

/* ================================================================
   RECENT / ACTIVE EXAMS sections
================================================================ */
#active-exams {
    background:
        radial-gradient(ellipse at 100% 0%, rgba(32,201,151,0.05) 0%, transparent 50%),
        radial-gradient(ellipse at 0% 100%, rgba(13,110,253,0.04) 0%, transparent 50%),
        linear-gradient(180deg, #f0fff8 0%, #f0f9ff 100%) !important;
}

/* Active exam card — glowing left border */
.exam-card-active {
    border-left: 4px solid var(--secondary) !important;
    box-shadow: -3px 0 20px rgba(32,201,151,0.12), var(--shadow-card) !important;
}

.exam-card-active::before {
    background: linear-gradient(90deg, transparent, var(--secondary), var(--accent), transparent) !important;
}

/* ================================================================
   SECTION TITLES — accent line decoration
================================================================ */
.section-title h2 {
    position: relative;
    display: inline-block;
}

.section-title h2::after {
    content: '';
    position: absolute;
    bottom: -10px; left: 50%; 
    transform: translateX(-50%);
    width: 48px; height: 3px;
    background: linear-gradient(90deg, var(--primary), var(--accent));
    border-radius: 2px;
}

/* ================================================================
   CONTACT — subtle side accent
================================================================ */
#contact {
    position: relative;
    overflow: hidden;
}

#contact::after {
    content: '';
    position: absolute;
    bottom: -300px; right: -300px;
    width: 700px; height: 700px;
    background: radial-gradient(circle, rgba(13,202,240,0.05) 0%, transparent 60%);
    border-radius: 50%;
    pointer-events: none;
}

.info-item {
    border: 1px solid rgba(13,110,253,0.06) !important;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.info-item::before {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary), var(--accent));
    transform: scaleX(0);
    transition: transform 0.3s ease;
    transform-origin: left;
}

.info-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(13,110,253,0.1);
    border-color: rgba(13,110,253,0.15) !important;
}

.info-item:hover::before {
    transform: scaleX(1);
}

/* ================================================================
   FOOTER — premium dark with pattern
================================================================ */
#footer {
    background:
        repeating-linear-gradient(
            -45deg,
            transparent,
            transparent 50px,
            rgba(255,255,255,0.012) 50px,
            rgba(255,255,255,0.012) 51px
        ),
        radial-gradient(ellipse at 20% 80%, rgba(13,110,253,0.12) 0%, transparent 50%),
        radial-gradient(ellipse at 80% 20%, rgba(13,202,240,0.08) 0%, transparent 50%),
        #0f172a !important;
}

/* Footer top divider glow */
#footer::before {
    content: '';
    display: block;
    height: 1px;
    background: linear-gradient(90deg,
        transparent 0%,
        rgba(13,110,253,0.5) 20%,
        rgba(13,202,240,0.6) 50%,
        rgba(13,110,253,0.5) 80%,
        transparent 100%
    );
    margin-bottom: 60px;
}

/* ================================================================
   WAVE HERO — enhanced multi-layer
================================================================ */
.hero-wave svg {
    height: 90px !important;
}

/* ================================================================
   SCROLL TOP — premium fab
================================================================ */
#scroll-top {
    background: linear-gradient(135deg, var(--primary), var(--accent)) !important;
    box-shadow: 0 4px 20px rgba(13,110,253,0.4), 0 0 0 4px rgba(13,110,253,0.1) !important;
}

#scroll-top:hover {
    box-shadow: 0 8px 28px rgba(13,110,253,0.5), 0 0 0 8px rgba(13,110,253,0.08) !important;
}

/* ================================================================
   BOTTOM NAV — glass upgrade
================================================================ */
#sm-bottom-nav {
    background: rgba(255,255,255,0.92) !important;
    backdrop-filter: blur(20px) saturate(180%) !important;
    -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
    border-top: 1px solid rgba(13,110,253,0.08) !important;
    box-shadow: 0 -2px 0 rgba(255,255,255,0.9), 0 -8px 32px rgba(0,0,0,0.08) !important;
}

/* ================================================================
   BUTTONS — premium micro-interaction
================================================================ */
.btn-school {
    box-shadow: 0 4px 14px rgba(13,110,253,0.25);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
}

.btn-school:hover {
    box-shadow: 0 10px 30px rgba(13,110,253,0.4) !important;
    transform: translateY(-3px) scale(1.03) !important;
}

.btn-exam {
    box-shadow: 0 4px 14px rgba(13,110,253,0.2);
}

/* ================================================================
   FEATURE ICON — subtle ring decoration
================================================================ */
.feature-icon {
    box-shadow: 0 8px 28px rgba(13,110,253,0.25), 0 0 0 8px rgba(13,110,253,0.06);
}

/* ================================================================
   WAVE BETWEEN SECTIONS — add a subtle SVG divider after stats
================================================================ */
#stats {
    position: relative;
}

#stats::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0; right: 0;
    height: 48px;
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 48' preserveAspectRatio='none'%3E%3Cpath d='M0,20 C200,48 400,0 600,22 C800,44 1000,8 1200,20 L1200,48 L0,48 Z' fill='%23ffffff'/%3E%3C/svg%3E");
    background-size: cover;
    background-repeat: no-repeat;
    z-index: 2;
}

/* Wave between services → CTA */
#services::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0; right: 0;
    height: 48px;
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 48' preserveAspectRatio='none'%3E%3Cpath d='M0,28 C300,48 500,4 700,26 C900,48 1100,10 1200,24 L1200,48 L0,48 Z' fill='%230d6efd' fill-opacity='0.95'/%3E%3C/svg%3E");
    background-size: cover;
    background-repeat: no-repeat;
    z-index: 2;
}

/* ================================================================
   TYPOGRAPHY — subtle letter-spacing refinement
================================================================ */
h1, h2, h3 { letter-spacing: -0.02em; }
.section-title h2 { letter-spacing: -0.03em; }
.btn-school, .btn-outline-school, .btn-school-inverted, .btn-exam {
    letter-spacing: 0.01em;
}

/* ================================================================
   SMOOTH SCROLL + SELECTION COLOR
================================================================ */
html { scroll-behavior: smooth; }

::selection {
    background: rgba(13,110,253,0.2);
    color: var(--primary-dark);
}
</style>
</head>

<body class="index-page">

    <!-- ============ HEADER ============ -->
    <!-- Pakai id/class custom (sm-header, sm-nav, dll) agar tidak di-hook main.js template -->
    <header id="sm-header">
        <div class="sm-header-inner">

            <a href="{{ url('/') }}" class="sm-logo">
                {{-- <img src="{{ asset('assets/frondend/assets/img/logo.png') }}" alt="Logo SIMORO"> --}}
                <img src="{{ asset('assets/img/icon.png') }}" alt="Logo" style="width: 150px; height: 100px;">
                {{-- <span>SIMORO SMANLI</span> --}}
            </a>

            <!-- Nav desktop + mobile dropdown -->
            <nav id="sm-nav">
                <ul id="sm-nav-list">
                    <li><a href="#hero" class="sm-nav-link active">Beranda</a></li>
                    <li><a href="#about" class="sm-nav-link">Tentang</a></li>
                    <li><a href="#features" class="sm-nav-link">Fitur</a></li>
                    <li><a href="#services" class="sm-nav-link">Layanan</a></li>
                    <li><a href="#contact" class="sm-nav-link">Kontak</a></li>
                </ul>
            </nav>

            <div class="sm-header-actions">
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

                <!-- Hamburger — pakai button bukan <i> agar lebih reliable di mobile -->
                <button id="sm-burger" aria-label="Menu" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

        </div>

        <!-- Mobile dropdown panel -->
        <div id="sm-mobile-menu">
            <ul>
                <li><a href="#hero" class="sm-nav-link">Beranda</a></li>
                <li><a href="#about" class="sm-nav-link">Tentang</a></li>
                <li><a href="#features" class="sm-nav-link">Fitur</a></li>
                <li><a href="#services" class="sm-nav-link">Layanan</a></li>
                <li><a href="#contact" class="sm-nav-link">Kontak</a></li>
            </ul>
        </div>
    </header>

    <main class="main">

        <!-- ============ HERO ============ -->
        <section id="hero">
            <div class="container">
                <div class="row gy-5 align-items-center">

                    <!-- Text side -->
                    <div class="col-lg-6 order-2 order-lg-1">
                        <div class="hero-text-wrap">
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
                    </div>

                    <!-- Image side -->
                    <div class="col-lg-6 order-1 order-lg-2 text-center">
                        <div class="hero-img-wrap">
                            <img src="{{ asset('assets/frondend/assets/img/hero-img.png') }}"
                                 class="img-fluid"
                                 alt="Hero Image"
                                 style="max-height: 440px; filter: drop-shadow(0 24px 48px rgba(0,0,0,0.2));">
                        </div>
                    </div>

                </div>
            </div>

            <!-- Animated wave divider -->
            <div class="hero-wave">
                <svg viewBox="0 0 1200 72" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Layer belakang semi-transparan -->
                    <path class="wave-path-2"
                          d="M0,55 C180,10 370,65 600,30 C830,0 1020,60 1200,45 L1200,72 L0,72 Z"
                          fill="#ffffff"/>
                    <!-- Layer depan putih solid -->
                    <path class="wave-path"
                          d="M0,40 C150,80 350,0 600,35 C850,70 1050,10 1200,40 L1200,72 L0,72 Z"
                          fill="#ffffff"/>
                </svg>
            </div>
        </section>

        <!-- ============ ABOUT ============ -->
        <section id="about">
            <div class="container">
                <div class="row gy-5 align-items-center">
                    <div class="col-lg-6" data-aos="fade-right">
                        <h3 style="color: var(--primary); font-weight: 600; font-size: 0.95rem; letter-spacing: 1px; text-transform: uppercase;">Tentang SIMORO SMANLI</h3>
                        <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 1.25rem;">Sistem Ujian Online Modern untuk Pendidikan Terbaik</h2>
                        <p style="color: var(--text-muted);">SIMORO SMANLI adalah platform ujian online yang dirancang khusus untuk mendukung kegiatan pembelajaran di SMA Negeri 5 Morotai. Dengan teknologi terkini, kami menghadirkan pengalaman ujian yang aman, praktis, dan transparan.</p>
                        <p style="color: var(--text-muted);">Sistem ini memungkinkan siswa untuk mengikuti ujian secara online dengan mudah, sementara guru dapat mengelola dan memantau ujian dengan lebih efisien.</p>
                        <a href="#features" class="btn-read-more mt-3">
                            Lihat Fitur <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="100">
                        <img src="{{ asset('assets/frondend/assets/img/about.jpg') }}" class="img-fluid w-100" alt="About" style="border-radius: var(--radius-card); box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ STATS ============ -->
        <section id="stats">
            <div class="container" data-aos="fade-up">
                <div class="row gy-4">
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
                            <i class="bi {{ $item['icon'] }}"></i>
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
        </section>

        <!-- ============ FEATURES ============ -->
        <section id="features">
            <div class="container section-title" data-aos="fade-up">
                <h2>Fitur Unggulan</h2>
                <p>Kemudahan dan Keamanan dalam Setiap Ujian</p>
            </div>
            <div class="container">
                <div class="row gy-5 align-items-center">
                    <div class="col-xl-6" data-aos="zoom-out" data-aos-delay="100">
                        <img src="{{ asset('assets/frondend/assets/img/features.png') }}" class="img-fluid" alt="Features">
                    </div>
                    <div class="col-xl-6">
                        <div class="row gy-3">
                            @php
                                $features = [
                                    ['icon' => 'bi-check-circle-fill', 'color' => 'var(--primary)',  'label' => 'Ujian Online'],
                                    ['icon' => 'bi-shield-check',      'color' => 'var(--secondary)','label' => 'Aman & Terpercaya'],
                                    ['icon' => 'bi-clock-history',     'color' => 'var(--accent)',   'label' => 'Waktu Realtime'],
                                    ['icon' => 'bi-graph-up',          'color' => '#fd7e14',         'label' => 'Hasil Instan'],
                                    ['icon' => 'bi-phone',             'color' => '#6f42c1',         'label' => 'Multi Device'],
                                    ['icon' => 'bi-cloud-upload',      'color' => '#e83e8c',         'label' => 'Backup Data'],
                                ];
                            @endphp
                            @foreach($features as $i => $f)
                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ 150 + ($i * 80) }}">
                                <div class="feature-box">
                                    <i class="bi {{ $f['icon'] }}" style="color: {{ $f['color'] }}; font-size: 1.5rem;"></i>
                                    <h3>{{ $f['label'] }}</h3>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ SERVICES ============ -->
        <section id="services">
            <div class="container section-title" data-aos="fade-up">
                <h2>Layanan</h2>
                <p>Layanan Terbaik untuk Pendidikan</p>
            </div>
            <div class="container">
                <div class="row gy-4">
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
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 + ($i * 80) }}">
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

        <!-- ============ CALL TO ACTION ============ -->
        <section id="call-to-action">
            <div class="container" data-aos="fade-up">
                <h2>Siap Memulai?</h2>
                <p>Bergabunglah dengan SMA Negeri 5 Morotai dan rasakan kemudahan ujian online yang modern dan terpercaya.</p>
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
        </section>

        <!-- ============ RECENT EXAMS ============ -->
        @if($recentExams->count() > 0)
        <section id="recent-exams">
            <div class="container section-title" data-aos="fade-up">
                <h2>Ujian Terbaru</h2>
                <p>Ujian yang baru dibuat</p>
            </div>
            <div class="container">
                <div class="row gy-4">
                    @foreach($recentExams as $exam)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="feature-card exam-card">
                            <div class="feature-icon">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <h3>{{ $exam->title }}</h3>
                            <p class="meta"><i class="bi bi-book me-2"></i>{{ $exam->subject->name ?? 'Tidak ada mata pelajaran' }}</p>
                            <p class="meta"><i class="bi bi-people me-2"></i>{{ $exam->schoolClass->name ?? 'Tidak ada kelas' }}</p>
                            <p class="meta" style="font-size: 0.85rem; color: #aaa;"><i class="bi bi-calendar me-2"></i>{{ \Carbon\Carbon::parse($exam->start_time)->format('d M Y') }}</p>
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

        <!-- ============ ACTIVE EXAMS ============ -->
        @if($activeExams->count() > 0)
        <section id="active-exams">
            <div class="container section-title" data-aos="fade-up">
                <h2>Ujian Sedang Aktif</h2>
                <p>Segera ikuti ujian sebelum tertutup</p>
            </div>
            <div class="container">
                <div class="row gy-4">
                    @foreach($activeExams as $exam)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="feature-card exam-card exam-card-active">
                            <span class="badge-active">● AKTIF</span>
                            <h3>{{ $exam->title }}</h3>
                            <p class="meta"><i class="bi bi-book me-2"></i>{{ $exam->subject->name ?? 'Tidak ada mata pelajaran' }}</p>
                            <p class="meta"><i class="bi bi-clock me-2"></i>{{ $exam->duration }} menit</p>
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

        <!-- ============ CONTACT ============ -->
        <section id="contact">
            <div class="container section-title" data-aos="fade-up">
                <h2>Kontak</h2>
                <p>Hubungi Kami</p>
            </div>
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-lg-6">
                        <div class="row gy-4 h-100">
                            @php
                                $contacts = [
                                    ['icon' => 'bi-geo-alt',  'title' => 'Alamat',     'lines' => ['SMA Negeri 5 Morotai', 'Kabupaten Pulau Morotai, Maluku Utara'], 'delay' => 200],
                                    ['icon' => 'bi-telephone','title' => 'Telepon',    'lines' => ['+62 123 4567 890', '+62 987 6543 210'], 'delay' => 300],
                                    ['icon' => 'bi-envelope', 'title' => 'Email',      'lines' => ['info@sman5morotai.sch.id', 'ujian@sman5morotai.sch.id'], 'delay' => 400],
                                    ['icon' => 'bi-clock',    'title' => 'Jam Kerja',  'lines' => ['Senin - Jumat', '07:00 - 16:00 WIT'], 'delay' => 500],
                                ];
                            @endphp
                            @foreach($contacts as $c)
                            <div class="col-md-6" data-aos="fade" data-aos-delay="{{ $c['delay'] }}">
                                <div class="info-item">
                                    <i class="bi {{ $c['icon'] }}"></i>
                                    <h3>{{ $c['title'] }}</h3>
                                    @foreach($c['lines'] as $line)
                                        <p>{{ $line }}</p>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
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
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn-submit">
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

    <!-- ============ FOOTER ============ -->
    <footer id="footer">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4 col-md-6">
                    <a href="{{ url('/') }}" class="d-flex align-items-center mb-3">
                        <img src="{{ asset('assets/frondend/assets/img/logo.png') }}" alt="Logo" style="max-height: 36px;">
                        <span style="font-size: 1.1rem; font-weight: 700; color: #fff; margin-left: 10px;">SIMORO SMANLI</span>
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
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> ·
                Distributed by <a href="#">SMA Negeri 5 Morotai</a>
            </div>
        </div>
    </footer>

    <a href="#" id="scroll-top"><i class="bi bi-arrow-up-short"></i></a>

    <!-- ============ BOTTOM NAV BAR (mobile only) ============ -->
    <nav id="sm-bottom-nav">
        <a href="#hero" class="sm-bnav-item active" data-section="hero">
            <i class="bi bi-house-fill"></i>
            <span>Beranda</span>
        </a>
        <a href="#about" class="sm-bnav-item" data-section="about">
            <i class="bi bi-info-circle-fill"></i>
            <span>Tentang</span>
        </a>
        <a href="#" class="sm-bnav-item sm-bnav-center" id="sm-bnav-cta">
            @auth
                <div class="sm-bnav-fab">
                    <i class="bi bi-speedometer2"></i>
                </div>
                <span>Dashboard</span>
            @else
                <div class="sm-bnav-fab">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>
                <span>Login</span>
            @endauth
        </a>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ── AOS ──────────────────────────────────────────
            if (typeof AOS !== 'undefined') AOS.init({ duration: 900, once: true });

            // ── HAMBURGER MENU ───────────────────────────────
            var burger     = document.getElementById('sm-burger');
            var mobileMenu = document.getElementById('sm-mobile-menu');

            if (burger && mobileMenu) {

                burger.addEventListener('click', function (e) {
                    e.stopPropagation();
                    var isOpen = mobileMenu.classList.toggle('open');
                    burger.classList.toggle('open', isOpen);
                    burger.setAttribute('aria-expanded', String(isOpen));
                });

                // Tutup saat klik link di menu mobile
                mobileMenu.querySelectorAll('a').forEach(function (link) {
                    link.addEventListener('click', closeMenu);
                });

                // Tutup saat klik di luar
                document.addEventListener('click', function (e) {
                    if (!mobileMenu.contains(e.target) && !burger.contains(e.target)) {
                        closeMenu();
                    }
                });
            }

            function closeMenu() {
                if (mobileMenu) mobileMenu.classList.remove('open');
                if (burger)     { burger.classList.remove('open'); burger.setAttribute('aria-expanded', 'false'); }
            }

            // ── ACTIVE NAV LINK ON SCROLL ────────────────────
            var allNavLinks = document.querySelectorAll('.sm-nav-link');
            var sections    = document.querySelectorAll('section[id]');

            window.addEventListener('scroll', function () {
                var scrollY = window.scrollY + 90;
                sections.forEach(function (section) {
                    if (scrollY >= section.offsetTop && scrollY < section.offsetTop + section.offsetHeight) {
                        allNavLinks.forEach(function (a) { a.classList.remove('active'); });
                        document.querySelectorAll('.sm-nav-link[href="#' + section.id + '"]')
                                .forEach(function (a) { a.classList.add('active'); });

                        // Sync bottom nav active state
                        document.querySelectorAll('.sm-bnav-item[data-section]').forEach(function (item) {
                            item.classList.toggle('active', item.getAttribute('data-section') === section.id);
                        });
                    }
                });
            });

            // ── BOTTOM NAV CTA LINK ──────────────────────────
            var bnavCta = document.getElementById('sm-bnav-cta');
            if (bnavCta) {
                @auth
                bnavCta.setAttribute('href', '{{ url("/dashboard") }}');
                @else
                bnavCta.setAttribute('href', '{{ route("login") }}');
                @endauth
            }

        });
    </script>

</body>
</html>
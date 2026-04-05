<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="SIMORO SMANLI - Sistem Ujian Online SMA Negeri 5 Morotai">
    <meta name="keywords" content="ujian online, sekolah, SMA, Morotai, pendidikan">

    <title>{{ config('app.name', 'SIMORO SMANLI') }} - SMA Negeri 5 Morotai</title>

    <!-- Favicons -->
    {{-- <link href="{{ asset('assets/frondend/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/frondend/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon"> --}}
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/frondend/assets/img/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/frondend/assets/img/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('assets/frondend/assets/img/site.webmanifest') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/frondend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frondend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frondend/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frondend/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frondend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/frondend/assets/css/main.css') }}" rel="stylesheet">

    <!-- Custom CSS for School Theme -->
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #20c997;
            --accent-color: #0dcaf0;
        }
        
        .school-logo {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .hero-section {
            background: linear-gradient(rgba(13, 110, 253, 0.9), rgba(32, 201, 151, 0.8));
        }
        
        .feature-card {
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-item {
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
            color: white;
        }
        
        .btn-school {
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
        }
        
        .btn-school:hover {
            background: linear-gradient(135deg, #0dcaf0, #0d6efd);
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="index-page">

    {{ $slot }}

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/frondend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frondend/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/frondend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/frondend/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/frondend/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/frondend/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/frondend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/frondend/assets/js/main.js') }}"></script>

</body>
</html>


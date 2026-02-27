{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') | SMA5</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    @include('layouts.sections.styles')
    @include('layouts.sections.scriptsIncludes')
</head>
<body class="bg-light">
    <div class="container-fluid p-0">
        <div class="row g-0 min-vh-100">
            <!-- Sidebar responsive -->
            <nav class="col-12 col-md-2 bg-white border-end d-md-flex flex-column d-none d-md-block" style="min-width:220px;">
                @if(auth()->check() && auth()->user()->role === 'teacher')
                    @include('layouts.partials.verticalMenuGuru')
                @elseif(auth()->check() && auth()->user()->role === 'student')
                    @include('layouts.partials.verticalMenuSiswa')
                @else
                    @include('layouts.partials.verticalMenu')
                @endif
            </nav>
            <nav class="col-12 d-md-none bg-white border-bottom py-2 px-3">
                <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
                    <i class="bi bi-list"></i> Menu
                </button>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        @if(auth()->check() && auth()->user()->role === 'teacher')
                            @include('layouts.partials.verticalMenuGuru')
                        @elseif(auth()->check() && auth()->user()->role === 'student')
                            @include('layouts.partials.verticalMenuSiswa')
                        @else
                            @include('layouts.partials.verticalMenu')
                        @endif
                    </div>
                </div>
            </nav>
            <div class="col-12 col-md-10 d-flex flex-column">
                <div class="sticky-top bg-white border-bottom">
                    @include('layouts.partials.navbar')
                </div>
                <main class="flex-grow-1 p-4">
                    <div class="container-fluid">
                        @yield('layoutContent')
                    </div>
                </main>
            </div>
        </div>
    </div>
    @include('layouts.sections.scripts')
</body>
</html> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') | SMA5</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    @include('layouts.sections.styles')
    @include('layouts.sections.scriptsIncludes')
</head>
<body class="bg-light">
    <div class="layout-wrapper">
        <!-- Sidebar Desktop & Tablet -->
        <aside class="layout-sidebar d-none d-lg-block">
            @if(auth()->check() && auth()->user()->role === 'teacher')
                @include('layouts.partials.verticalMenuGuru')
            @elseif(auth()->check() && auth()->user()->role === 'student')
                @include('layouts.partials.verticalMenuSiswa')
            @else
                @include('layouts.partials.verticalMenu')
            @endif
        </aside>

        <!-- Main Content Area -->
        <div class="layout-content-wrapper">
            <!-- Mobile Menu Button -->
            <div class="mobile-menu-toggle d-lg-none">
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                    <i class="bi bi-list"></i> Menu
                </button>
            </div>

            <!-- Navbar -->
            <header class="layout-navbar">
                @include('layouts.partials.navbar')
            </header>

            <!-- Main Content -->
            <main class="layout-main">
                <div class="container-fluid">
                    @yield('layoutContent')
                </div>
            </main>
             @include('layouts.partials.footer-dashboard')
        </div>

        <!-- Mobile Offcanvas -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-0">
                @if(auth()->check() && auth()->user()->role === 'teacher')
                    @include('layouts.partials.verticalMenuGuru')
                @else
                    @include('layouts.partials.verticalMenu')
                @endif
            </div>
        </div>
    </div>

    @include('layouts.sections.scripts')


    
</body>
</html>
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
    <div class="container-fluid p-0">
        <div class="row g-0 min-vh-100">
            <!-- Sidebar responsive -->
            <nav class="col-12 col-md-2 bg-white border-end d-md-flex flex-column d-none d-md-block" style="min-width:220px;">
                @include('layouts.partials.verticalMenu')
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
                        @include('layouts.partials.verticalMenu')
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
</html>

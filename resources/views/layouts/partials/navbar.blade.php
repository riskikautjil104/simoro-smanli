{{-- <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-3 py-2">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="/dashboard">
      <img src="{{ asset('assets/img/icon.png') }}" alt="Logo" height="100" class="me-2">
      <span>SIMORO SMANLI</span>
    </a>
    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('assets/img/people.svg') }}" alt="alt" class="rounded-circle me-2" height="32" />
            <span>Admin SMA5</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="/profile">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
              <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav> --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
  <div class="container-fluid px-3 px-lg-4">
    <!-- Logo & Brand -->
    <a class="navbar-brand fw-bold d-flex align-items-center" href="/dashboard">
      <img src="{{ asset('assets/img/icon.png') }}" alt="Logo" height="40" class="me-2 d-none d-sm-block">
      <img src="{{ asset('assets/img/icon.png') }}" alt="Logo" height="32" class="me-2 d-block d-sm-none">
      <span class="brand-text d-none d-md-inline">SIMORO SMANLI</span>
      <span class="brand-text d-inline d-md-none">SIMORO</span>
    </a>

    <!-- Navbar Toggle for Mobile -->
    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Menu -->
    <div class="collapse navbar-collapse" id="navbarMenu">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center py-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
            <img src="{{ asset('assets/img/people.svg') }}" alt="User" class="rounded-circle me-2" height="32" width="32" />
            <span class="user-name d-none d-sm-inline">Admin SMA5</span>
            <span class="user-name d-inline d-sm-none">Admin</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i>Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
              <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
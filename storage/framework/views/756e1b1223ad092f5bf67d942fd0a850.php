
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
  <div class="container-fluid px-3 px-lg-4">
    <!-- Logo & Brand -->
    <a class="navbar-brand fw-bold d-flex align-items-center" href="/dashboard">
      <img src="<?php echo e(asset('assets/img/icon.png')); ?>" alt="Logo" height="40" class="me-2 d-none d-sm-block">
      <img src="<?php echo e(asset('assets/img/icon.png')); ?>" alt="Logo" height="32" class="me-2 d-block d-sm-none">
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
            <img src="<?php echo e(asset('assets/img/people.svg')); ?>" alt="User" class="rounded-circle me-2" height="32" width="32" />
            <span class="user-name d-none d-sm-inline"><?php echo e(auth()->user()->name); ?></span>
            <span class="user-name d-inline d-sm-none"><?php echo e(auth()->user()->name); ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i>Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo csrf_field(); ?>
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
</nav><?php /**PATH /Users/rizkihiibrahim/Documents/simoro-smanli/resources/views/layouts/partials/navbar.blade.php ENDPATH**/ ?>
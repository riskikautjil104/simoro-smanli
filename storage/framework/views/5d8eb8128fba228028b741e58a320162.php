
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('assets/frondend/assets/img/favicon-32x32.png')); ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('assets/frondend/assets/img/favicon-16x16.png')); ?>">
<link rel="manifest" href="<?php echo e(asset('assets/frondend/assets/img/site.webmanifest')); ?>">
    <title><?php echo $__env->yieldContent('title'); ?> | SMA5</title>
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('assets/img/favicon/favicon.ico')); ?>" />
    <?php echo $__env->make('layouts.sections.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.sections.scriptsIncludes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body class="bg-light">
    <div class="layout-wrapper">
        <!-- Sidebar Desktop & Tablet -->
        <aside class="layout-sidebar d-none d-lg-block">
            <?php if(auth()->check() && auth()->user()->role === 'teacher'): ?>
                <?php echo $__env->make('layouts.partials.verticalMenuGuru', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php elseif(auth()->check() && auth()->user()->role === 'student'): ?>
                <?php echo $__env->make('layouts.partials.verticalMenuSiswa', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php else: ?>
                <?php echo $__env->make('layouts.partials.verticalMenu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
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
                <?php echo $__env->make('layouts.partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </header>

            <!-- Main Content -->
            <main class="layout-main">
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('layoutContent'); ?>
                </div>
            </main>
             <?php echo $__env->make('layouts.partials.footer-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <!-- Mobile Offcanvas -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-0">
                <?php if(auth()->check() && auth()->user()->role === 'teacher'): ?>
                    <?php echo $__env->make('layouts.partials.verticalMenuGuru', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php else: ?>
                    <?php echo $__env->make('layouts.partials.verticalMenu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php echo $__env->make('layouts.sections.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


    
</body>
</html><?php /**PATH /Users/rizkihiibrahim/Documents/simoro-smanli/resources/views/layouts/master.blade.php ENDPATH**/ ?>
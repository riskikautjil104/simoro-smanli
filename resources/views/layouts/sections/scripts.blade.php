<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== Page Loader =====
    const pageLoader = document.createElement('div');
    pageLoader.className = 'page-loader';
    pageLoader.innerHTML = '<div class="loader-spinner"></div>';
    document.body.prepend(pageLoader);
    
    window.addEventListener('load', function() {
        setTimeout(() => {
            pageLoader.classList.add('fade-out');
            setTimeout(() => pageLoader.remove(), 500);
        }, 300);
    });

    // ===== Active Menu Highlighting =====
    const currentUrl = window.location.href;
    const menuLinks = document.querySelectorAll('.sidebar-menu .nav-link');
    
    menuLinks.forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add('active');
            link.classList.add('animate__animated', 'animate__fadeInLeft');
        }
        
        // Add click animation with ripple effect
        link.addEventListener('click', function(e) {
            if (!this.classList.contains('active')) {
                menuLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                
                // Ripple effect
                const ripple = document.createElement('span');
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.5);
                    width: 20px;
                    height: 20px;
                    animation: ripple 0.6s ease-out;
                    pointer-events: none;
                `;
                
                const rect = this.getBoundingClientRect();
                ripple.style.left = (e.clientX - rect.left - 10) + 'px';
                ripple.style.top = (e.clientY - rect.top - 10) + 'px';
                
                this.style.position = 'relative';
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            }
        });
    });

    // ===== Mobile Menu Auto-Close =====
    const offcanvasEl = document.getElementById('sidebarOffcanvas');
    if (offcanvasEl) {
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
                if (offcanvas && window.innerWidth < 992) {
                    setTimeout(() => offcanvas.hide(), 200);
                }
            });
        });
    }

    // ===== Navbar Collapse Auto-Close =====
    const navbarCollapse = document.getElementById('navbarMenu');
    if (navbarCollapse) {
        const navLinks = navbarCollapse.querySelectorAll('.dropdown-item');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                const collapse = bootstrap.Collapse.getInstance(navbarCollapse);
                if (collapse && window.innerWidth < 992) {
                    setTimeout(() => collapse.hide(), 200);
                }
            });
        });
    }

    // ===== Navbar Scroll Effect =====
    const navbar = document.querySelector('.navbar');
    let lastScroll = 0;
    
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 50) {
            navbar?.classList.add('scrolled');
        } else {
            navbar?.classList.remove('scrolled');
        }
        
        lastScroll = currentScroll;
    });

    // ===== Smooth Scroll for Anchor Links =====
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // ===== Card Entrance Animation =====
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                }, index * 100);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.card').forEach(card => {
        observer.observe(card);
    });

    // ===== Touch Device Detection & Feedback =====
    if ('ontouchstart' in window || navigator.maxTouchPoints > 0) {
        document.body.classList.add('touch-device');
        
        document.querySelectorAll('.btn, .card, .nav-link').forEach(el => {
            el.addEventListener('touchstart', function() {
                this.style.opacity = '0.7';
            });
            
            el.addEventListener('touchend', function() {
                this.style.opacity = '1';
            });
        });
    }

    // ===== Form Validation with Animation =====
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                
                const invalidInputs = form.querySelectorAll(':invalid');
                invalidInputs.forEach(input => {
                    input.classList.add('animate__animated', 'animate__shakeX');
                    setTimeout(() => {
                        input.classList.remove('animate__animated', 'animate__shakeX');
                    }, 1000);
                });
            }
            form.classList.add('was-validated');
        });
    });

    // ===== Responsive Table Wrapper =====
    document.querySelectorAll('table:not(.table-responsive table)').forEach(table => {
        const wrapper = document.createElement('div');
        wrapper.className = 'table-responsive';
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    });

    // ===== Tooltips Initialization =====
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            trigger: 'hover'
        });
    });

    // ===== Popovers Initialization =====
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // ===== Tablet Orientation Change Handler =====
    window.addEventListener('orientationchange', function() {
        setTimeout(() => {
            const offcanvas = offcanvasEl ? bootstrap.Offcanvas.getInstance(offcanvasEl) : null;
            if (offcanvas && window.innerWidth >= 992) {
                offcanvas.hide();
            }
        }, 100);
    });

    // ===== Responsive Sidebar Width Adjustment =====
    function adjustLayout() {
        const width = window.innerWidth;
        const sidebar = document.querySelector('.layout-sidebar');
        
        if (sidebar) {
            if (width >= 992 && width <= 1200) {
                sidebar.style.width = '220px';
            } else if (width > 1200) {
                sidebar.style.width = '260px';
            }
        }
    }

    adjustLayout();
    window.addEventListener('resize', adjustLayout);

    // ===== Dynamic Viewport Height Fix (Mobile Safari) =====
    const setVH = () => {
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    };
    
    setVH();
    window.addEventListener('resize', setVH);
    window.addEventListener('orientationchange', setVH);

    // ===== Debounced Resize Handler =====
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            document.body.classList.add('resizing');
            setTimeout(() => document.body.classList.remove('resizing'), 300);
        }, 250);
    });

    // ===== CSRF Token Setup for AJAX =====
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken && typeof window.axios !== 'undefined') {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
    }

    // ===== Keyboard Navigation Enhancement =====
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            // Close all open modals
            const openModals = document.querySelectorAll('.modal.show');
            openModals.forEach(modal => {
                bootstrap.Modal.getInstance(modal)?.hide();
            });
            
            // Close offcanvas
            if (offcanvasEl) {
                const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
                offcanvas?.hide();
            }
        }
    });

    // ===== Performance Monitoring =====
    if (window.performance && window.performance.timing) {
        window.addEventListener('load', () => {
            const perfData = window.performance.timing;
            const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
            if (pageLoadTime > 0) {
                console.log(`⚡ Page loaded in ${pageLoadTime}ms`);
            }
        });
    }
});
</script>

@stack('scripts')
<!-- External CSS Libraries -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">

<style>
/* ===== Global Reset & Base ===== */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Poppins', Arial, sans-serif !important;
  background: #f5f7fa !important;
  color: #2d3748;
  overflow-x: hidden;
}

.navbar, .sidebar, .card, .btn, .form-control, .nav, .offcanvas, .dropdown-menu {
  font-family: 'Poppins', Arial, sans-serif !important;
}

/* ===== Layout Structure ===== */
.layout-wrapper {
  display: flex;
  min-height: 100vh;
  overflow-x: hidden;
  background: #f5f7fa;
}

.layout-sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 260px;
  height: 100vh;
  background: #ffffff;
  border-right: 1px solid #e2e8f0;
  z-index: 1000;
  overflow-y: auto;
  transition: all 0.3s ease;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.03);
}

.layout-content-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  margin-left: 0;
  transition: margin-left 0.3s ease;
  background: #f5f7fa;
}

.layout-navbar {
  position: sticky;
  top: 0;
  z-index: 999;
  background: #ffffff;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
}

.layout-main {
  flex: 1;
  padding: 2rem;
  overflow-x: hidden;
  background: #f5f7fa;
}

/* ===== Sidebar Components ===== */
.sidebar-wrapper {
  display: flex;
  flex-direction: column;
  height: 100%;
  background: #ffffff;
}

.sidebar-header {
  flex-shrink: 0;
  padding: 1.5rem 1rem;
  background: linear-gradient(135deg, #4095F0 0%, #3026FB 100%);
  border-bottom: none;
  text-align: center;
}

.sidebar-header h5 {
  color: #ffffff;
  font-weight: 700;
  margin-bottom: 0.25rem;
  font-size: 1.1rem;
  text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.sidebar-header .small {
  color: rgba(255, 255, 255, 0.9);
  font-weight: 500;
  letter-spacing: 0.5px;
}

.sidebar-logo img {
  filter: brightness(0) invert(1);
  margin-bottom: 0.5rem;
}

.sidebar-body {
  flex: 1;
  overflow-y: auto;
  padding: 1.5rem 0;
  background: #ffffff;
}

.sidebar-menu {
  padding: 0 1rem;
  list-style: none;
}

.sidebar-menu .nav-item {
  margin-bottom: 0.35rem;
}

.sidebar-menu .nav-link {
  display: flex;
  align-items: center;
  padding: 0.85rem 1rem;
  border-radius: 10px;
  color: #4a5568;
  text-decoration: none;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  font-size: 0.95rem;
  font-weight: 500;
  overflow: hidden;
  background: transparent;
}

.sidebar-menu .nav-link::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  width: 4px;
  /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
  background: linear-gradient(135deg, #4095F0 0%, #3026FB 100%);
  transform: scaleY(0);
  transition: transform 0.3s ease;
  border-radius: 0 4px 4px 0;
}

.sidebar-menu .nav-link:hover::before {
  transform: scaleY(1);
}

.sidebar-menu .nav-link i {
  font-size: 1.2rem;
  margin-right: 0.85rem;
  width: 24px;
  text-align: center;
  transition: all 0.3s ease;
  color: #718096;
}

.sidebar-menu .nav-link span {
  flex: 1;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.sidebar-menu .nav-link:hover {
  background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
  color: #1D49FA;
  transform: translateX(5px);
  padding-left: 1.25rem;
}

.sidebar-menu .nav-link:hover i {
  transform: scale(1.15);
  color: #3744FE;
}

.sidebar-menu .nav-link.active {
  /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
  background: linear-gradient(135deg, #4095F0 0%, #3026FB 100%);
  color: #ffffff;
  box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
  transform: translateX(5px);
}

.sidebar-menu .nav-link.active i {
  color: #ffffff;
  animation: iconBounce 1.5s ease-in-out infinite;
}

@keyframes iconBounce {
  0%, 100% { transform: translateY(0) scale(1); }
  50% { transform: translateY(-3px) scale(1.1); }
}

/* ===== Navbar Styling ===== */
.navbar {
  backdrop-filter: blur(10px);
  background: rgba(255, 255, 255, 0.98) !important;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
  transition: all 0.3s ease;
  border-bottom: 1px solid #e2e8f0;
}

.navbar.scrolled {
  box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
}

.navbar-brand {
  font-size: 1.35rem;
  transition: all 0.3s ease;
  text-decoration: none;
  font-weight: 700;
}

.navbar-brand img {
  transition: all 0.3s ease;
}

.navbar-brand:hover img {
  transform: scale(1.08) rotate(5deg);
}

.brand-text {
  font-weight: 700;
  /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
  background: linear-gradient(135deg, #4095F0 0%, #3026FB 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  letter-spacing: 0.5px;
}

.navbar-toggler {
  padding: 0.5rem 0.75rem;
  border: 2px solid #3357F5 !important;
  border-radius: 8px;
}

.navbar-toggler:focus {
  box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* ===== Mobile Menu Toggle ===== */
.mobile-menu-toggle {
  padding: 1rem;
  background: #ffffff;
  border-bottom: 1px solid #e2e8f0;
}

.mobile-menu-toggle .btn {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.85rem;
  font-weight: 600;
  /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
  background: linear-gradient(135deg, #4095F0 0%, #3026FB 100%);
  border: none;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.mobile-menu-toggle .btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

/* ===== Offcanvas Styling ===== */
.offcanvas {
  width: 280px !important;
  transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  background: #ffffff;
}

.offcanvas-header {
  /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
  background: linear-gradient(135deg, #4095F0 0%, #3026FB 100%);
  color: white;
  padding: 1.5rem;
}

.offcanvas-header .offcanvas-title {
  font-weight: 700;
}

.offcanvas-header .btn-close {
  filter: brightness(0) invert(1);
  opacity: 1;
  transition: transform 0.3s ease;
}

.offcanvas-header .btn-close:hover {
  transform: rotate(90deg);
}

.offcanvas-body {
  padding: 0;
  background: #ffffff;
}

/* ===== Card Styling ===== */
.card {
  transition: all 0.3s ease;
  border: 1px solid #e2e8f0;
  overflow: hidden;
  background: #ffffff;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
  border-radius: 12px;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 30px rgba(102, 126, 234, 0.15);
  border-color: rgba(102, 126, 234, 0.3);
}

.card-header {
  background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
  border-bottom: 2px solid #e2e8f0;
  font-weight: 600;
  color: #2d3748;
}

.card-body {
  background: #ffffff;
  color: #2d3748;
}

/* ===== Button Enhancements ===== */
.btn {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
  font-weight: 600;
  border-radius: 8px;
}

.btn::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.4);
  transform: translate(-50%, -50%);
  transition: width 0.6s, height 0.6s;
}

.btn:active::before {
  width: 300px;
  height: 300px;
}

.btn-primary {
  /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
  background: linear-gradient(135deg, #4095F0 0%, #3026FB 100%);
  border: none;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
  color: #ffffff;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
  background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
}

.btn-success {
  background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
  border: none;
  box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
}

.btn-success:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(72, 187, 120, 0.4);
}

/* ===== Form Controls ===== */
.form-control, .form-select {
  transition: all 0.3s ease;
  border: 2px solid #e2e8f0;
  border-radius: 8px;
  padding: 0.65rem 1rem;
  background: #ffffff;
  color: #2d3748;
}

.form-control:focus, .form-select:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
  transform: scale(1.01);
  background: #ffffff;
}

.form-label {
  font-weight: 600;
  color: #2d3748;
  margin-bottom: 0.5rem;
}

/* ===== Loading Animation ===== */
.page-loader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
  background: linear-gradient(135deg, #4095F0 0%, #3026FB 100%);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
  opacity: 1;
  transition: opacity 0.5s ease;
}

.page-loader.fade-out {
  opacity: 0;
  pointer-events: none;
}

.loader-spinner {
  width: 60px;
  height: 60px;
  border: 5px solid rgba(255, 255, 255, 0.3);
  border-top: 5px solid #ffffff;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* ===== Dropdown Menu ===== */
.dropdown-menu {
  border: none;
  box-shadow: 0 8px 30px rgba(0,0,0,0.12);
  border-radius: 10px;
  padding: 0.75rem;
  min-width: 220px;
  animation: dropdownFade 0.3s ease;
  background: #ffffff;
}

@keyframes dropdownFade {
  from {
    opacity: 0;
    transform: translateY(-15px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.dropdown-item {
  padding: 0.75rem 1rem;
  border-radius: 8px;
  transition: all 0.2s ease;
  font-weight: 500;
  color: #2d3748;
}

.dropdown-item:hover {
  background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
  color: #667eea;
  transform: translateX(5px);
}

.dropdown-item i {
  font-size: 1.15rem;
  margin-right: 0.5rem;
}

/* ===== Smooth Scrollbar ===== */
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  background: #f7fafc;
}

::-webkit-scrollbar-thumb {
  /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
  background: linear-gradient(135deg, #4095F0 0%, #3026FB 100%);
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  /* background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%); */
  background: linear-gradient(135deg, #4095F0 0%, #3026FB 100%);
}

/* ===== Desktop & Large Tablet (>= 992px) ===== */
@media (min-width: 992px) {
  .layout-content-wrapper {
    margin-left: 260px;
  }
  
  .mobile-menu-toggle {
    display: none;
  }
}

/* ===== Tablet (768px - 991px) ===== */
@media (min-width: 768px) and (max-width: 991px) {
  .layout-sidebar {
    width: 220px;
  }
  
  .sidebar-menu .nav-link {
    padding: 0.7rem 0.9rem;
    font-size: 0.9rem;
  }
  
  .layout-main {
    padding: 1.5rem;
  }
  
  .navbar-brand {
    font-size: 1.15rem;
  }
}

/* ===== Mobile (< 768px) ===== */
@media (max-width: 767px) {
  .layout-main {
    padding: 1rem;
  }
  
  .navbar-brand {
    font-size: 1rem;
  }
  
  .card {
    margin-bottom: 1rem;
  }
}

/* ===== Touch Device Optimizations ===== */
@media (hover: none) and (pointer: coarse) {
  .sidebar-menu .nav-link:active {
    background: rgba(102, 126, 234, 0.15);
    transform: scale(0.98);
  }
  
  .btn:active {
    transform: scale(0.96);
  }
}

/* ===== Ripple Animation ===== */
@keyframes ripple {
  to {
    width: 200px;
    height: 200px;
    opacity: 0;
  }
}

body.resizing * {
  transition: none !important;
}

/* ===== Print Styles ===== */
@media print {
  .layout-sidebar,
  .mobile-menu-toggle,
  .layout-navbar {
    display: none !important;
  }
  
  .layout-content-wrapper {
    margin-left: 0 !important;
  }
  
  body {
    background: #fff !important;
  }
}
</style>
<style>
/* ===== Footer Styling ===== */
.layout-footer {
  background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
  color: #e2e8f0;
  padding: 3rem 2rem 1.5rem;
  margin-top: auto;
  border-top: 3px solid #667eea;
  position: relative;
  overflow: hidden;
}

.layout-footer::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #667eea 100%);
  background-size: 200% 100%;
  animation: gradientShift 3s linear infinite;
}

@keyframes gradientShift {
  0% { background-position: 0% 0%; }
  100% { background-position: 200% 0%; }
}

.footer-content {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
  margin-bottom: 2rem;
}

/* Footer Brand */
.footer-brand {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-bottom: 0.75rem;
}

.footer-logo {
  filter: brightness(0) invert(1);
  transition: transform 0.3s ease;
}

.footer-brand:hover .footer-logo {
  transform: rotate(360deg) scale(1.1);
}

.footer-brand-text {
  font-size: 1.25rem;
  font-weight: 700;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.footer-tagline {
  color: #a0aec0;
  font-size: 0.9rem;
  margin: 0;
  font-weight: 500;
}

/* Footer Links */
.footer-links {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.footer-link {
  color: #e2e8f0;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.95rem;
  font-weight: 500;
  transition: all 0.3s ease;
  padding: 0.5rem;
  border-radius: 6px;
}

.footer-link i {
  font-size: 1.1rem;
  transition: transform 0.3s ease;
}

.footer-link:hover {
  color: #667eea;
  background: rgba(102, 126, 234, 0.1);
  transform: translateX(5px);
}

.footer-link:hover i {
  transform: scale(1.2);
}

/* Footer Social */
.footer-social {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
}

.social-link {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.1);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #e2e8f0;
  font-size: 1.2rem;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
}

.social-link::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  transform: scale(0);
  transition: transform 0.3s ease;
  border-radius: 50%;
}

.social-link i {
  position: relative;
  z-index: 1;
}

.social-link:hover {
  transform: translateY(-5px) scale(1.1);
  box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.social-link:hover::before {
  transform: scale(1);
}

.social-link:hover {
  color: #ffffff;
}

.footer-school {
  color: #a0aec0;
  font-size: 0.95rem;
  font-weight: 600;
  margin: 0;
}

/* Footer Bottom */
.footer-bottom {
  max-width: 1200px;
  margin: 0 auto;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(226, 232, 240, 0.2);
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
}

.footer-copyright {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #a0aec0;
  font-size: 0.9rem;
  font-weight: 500;
}

.footer-copyright i {
  font-size: 1rem;
}

.footer-tech {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #a0aec0;
  font-size: 0.9rem;
  font-weight: 500;
}

.footer-tech .pulse {
  animation: heartbeat 1.5s ease-in-out infinite;
}

@keyframes heartbeat {
  0%, 100% { transform: scale(1); }
  10%, 30% { transform: scale(1.3); }
  20%, 40% { transform: scale(1.1); }
}

/* ===== Responsive Footer ===== */
@media (max-width: 768px) {
  .layout-footer {
    padding: 2rem 1rem 1rem;
  }
  
  .footer-content {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
  
  .footer-left,
  .footer-center,
  .footer-right {
    text-align: center;
  }
  
  .footer-brand {
    justify-content: center;
  }
  
  .footer-links {
    align-items: center;
  }
  
  .footer-social {
    justify-content: center;
  }
  
  .footer-bottom {
    flex-direction: column;
    text-align: center;
    gap: 0.75rem;
  }
}

@media (max-width: 576px) {
  .layout-footer {
    padding: 1.5rem 0.75rem 1rem;
  }
  
  .footer-brand-text {
    font-size: 1.1rem;
  }
  
  .footer-tagline {
    font-size: 0.85rem;
  }
  
  .footer-link {
    font-size: 0.9rem;
  }
  
  .social-link {
    width: 36px;
    height: 36px;
    font-size: 1.1rem;
  }
  
  .footer-copyright,
  .footer-tech {
    font-size: 0.85rem;
  }
}

/* ===== Tablet Portrait ===== */
@media (min-width: 768px) and (max-width: 991px) {
  .footer-content {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .footer-right {
    grid-column: 1 / -1;
    text-align: center;
  }
  
  .footer-social {
    justify-content: center;
  }
}

/* ===== Print Styles ===== */
@media print {
  .layout-footer {
    display: none !important;
  }
}
</style>
@stack('styles')
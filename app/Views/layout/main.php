<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIMPA</title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('images/icon_simpa.png') ?>" />
  <link rel="stylesheet" href="<?= base_url('template/src/assets/css/styles.min.css') ?>" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Animation Libraries -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #004996;
      --secondary-color: #FFB800;
      --primary-gradient: linear-gradient(135deg, #004996 0%, #002d5f 100%);
      --accent-gradient: linear-gradient(135deg, #FFB800 0%, #e5a500 100%);
      --surface-color: #ffffff;
      --bg-color: #f4f6f9;
      --text-main: #1e293b;
      --text-muted: #64748b;
      --border-color: #e2e8f0;
      --shadow-sm: 0 2px 8px rgba(0, 73, 150, 0.04);
      --shadow-md: 0 8px 20px rgba(0, 73, 150, 0.06);
      --shadow-lg: 0 16px 32px rgba(0, 73, 150, 0.08), 0 4px 12px rgba(0,0,0,0.02);
      --radius-md: 12px;
      --radius-lg: 20px;
    }
    
    body {
      font-family: 'Plus Jakarta Sans', sans-serif !important;
      background-color: var(--bg-color);
      color: var(--text-main);
      overflow-x: hidden;
    }
    
    h1, h2, h3, h4, h5, h6, .hero-card h4 {
      font-family: 'Plus Jakarta Sans', sans-serif !important;
      font-weight: 700 !important;
      letter-spacing: -0.02em;
    }
    
    /* Elegant Corporate Cards */
    .card {
      border: 1px solid rgba(226, 232, 240, 0.8) !important;
      border-radius: var(--radius-lg) !important;
      box-shadow: var(--shadow-sm) !important;
      transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
      background: var(--surface-color);
    }
    .card:hover {
      box-shadow: var(--shadow-lg) !important;
      border-color: rgba(0, 73, 150, 0.15) !important;
    }
    
    /* Hero / Header Cards */
    .hero-card {
      background: var(--primary-gradient);
      color: white;
      border-radius: var(--radius-lg) !important;
      padding: 2.25rem !important;
      position: relative;
      overflow: hidden;
      box-shadow: 0 12px 24px rgba(0, 73, 150, 0.15) !important;
      border: none !important;
    }
    .hero-card::after {
      content: '';
      position: absolute;
      top: -50%;
      right: -10%;
      width: 350px;
      height: 350px;
      background: radial-gradient(circle, rgba(255, 184, 0, 0.2) 0%, rgba(255,255,255,0) 70%);
      border-radius: 50%;
    }
    .hero-card h4 { color: white !important; font-weight: 800; letter-spacing: -0.5px; }
    .hero-card p { opacity: 0.9; font-weight: 400; }
    
    /* Buttons */
    .btn {
      border-radius: 10px !important;
      font-weight: 600 !important;
      letter-spacing: 0.3px;
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
      padding: 0.6rem 1.4rem;
      font-size: 0.875rem;
    }
    .btn-primary { 
      background: var(--primary-color) !important; 
      border-color: var(--primary-color) !important; 
      box-shadow: 0 4px 10px rgba(0, 73, 150, 0.25) !important; 
      color: #ffffff !important;
    }
    .btn-primary:hover { 
      transform: translateY(-2px); 
      box-shadow: 0 6px 16px rgba(0, 73, 150, 0.35) !important;
      background: #003770 !important;
      border-color: #003770 !important;
    }
    .btn-outline-danger {
      border-color: #ef4444 !important;
      color: #ef4444 !important;
    }
    .btn-outline-danger:hover {
      background-color: #ef4444 !important;
      color: white !important;
      transform: translateY(-1px);
    }
    
    /* Tables */
    .table-responsive { 
      border-radius: var(--radius-md); 
      overflow: hidden; 
      border: 1px solid var(--border-color); 
      box-shadow: var(--shadow-sm);
    }
    .table thead th { 
      background-color: #f8fafc !important; 
      color: #475569 !important; 
      font-weight: 700 !important; 
      text-transform: uppercase; 
      font-size: 0.75rem; 
      letter-spacing: 0.05em; 
      border-bottom: 2px solid var(--border-color) !important; 
      padding: 1.1rem 1rem; 
    }
    .table tbody td { 
      padding: 1.1rem 1rem; 
      vertical-align: middle; 
      border-bottom: 1px solid var(--border-color); 
      color: var(--text-main); 
    }
    .table tbody tr {
      transition: background-color 0.2s ease;
    }
    .table tbody tr:hover { 
      background-color: rgba(0, 73, 150, 0.015) !important; 
    }
    
    /* Badges */
    .badge { 
      padding: 0.6em 1em !important; 
      font-weight: 700; 
      border-radius: 8px !important; 
      letter-spacing: 0.4px; 
      font-size: 0.75rem;
    }
    .bg-light-success { background-color: #ecfdf5 !important; color: #059669 !important; border: 1px solid #d1fae5 !important; }
    .bg-light-warning { background-color: #fffbeb !important; color: #d97706 !important; border: 1px solid #fef3c7 !important; }
    .bg-light-danger { background-color: #fef2f2 !important; color: #dc2626 !important; border: 1px solid #fee2e2 !important; }
    .bg-light-primary { background-color: #eff6ff !important; color: #1d4ed8 !important; border: 1px solid #dbeafe !important; }
    
    /* Sidebar */
    .left-sidebar { 
      box-shadow: 6px 0 30px rgba(0, 73, 150, 0.03) !important; 
      border-right: 1px solid rgba(226, 232, 240, 0.8) !important; 
      background: rgba(255, 255, 255, 0.85) !important; 
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
    }
    .sidebar-link { 
      border-radius: 12px !important; 
      margin: 0.25rem 1rem !important; 
      padding: 12px 18px !important;
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important; 
      color: var(--text-muted) !important; 
      font-weight: 600; 
      border: 1px solid transparent;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .sidebar-link:hover { 
      background-color: rgba(0, 73, 150, 0.04) !important; 
      color: var(--primary-color) !important; 
      transform: translateX(6px); 
      border-color: rgba(0, 73, 150, 0.08);
    }
    .sidebar-link.active { 
      background: linear-gradient(90deg, rgba(0, 73, 150, 0.08) 0%, rgba(0, 73, 150, 0.02) 100%) !important; 
      color: var(--primary-color) !important; 
      font-weight: 700 !important;
      border-left: 4px solid var(--secondary-color) !important; 
      border-color: rgba(0, 73, 150, 0.08) rgba(0, 73, 150, 0.08) rgba(0, 73, 150, 0.08) var(--secondary-color) !important;
      box-shadow: 0 4px 12px rgba(0, 73, 150, 0.03) !important;
    }
    .sidebar-link i { 
      font-size: 1.35rem; 
      transition: transform 0.3s; 
    }
    .sidebar-link:hover i { 
      transform: scale(1.15) rotate(2deg); 
    }
    
    /* Header */
    .app-header { 
      background: rgba(255, 255, 255, 0.8) !important; 
      backdrop-filter: blur(15px); 
      -webkit-backdrop-filter: blur(15px); 
      border-bottom: 1px solid rgba(226, 232, 240, 0.8); 
      box-shadow: 0 4px 30px rgba(0, 73, 150, 0.02) !important; 
      transition: all 0.3s; 
    }
    
    /* Inputs */
    .form-control, .form-select { 
      border-radius: 10px; 
      border: 1px solid var(--border-color); 
      padding: 0.65rem 1.1rem; 
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); 
      box-shadow: none !important; 
      background-color: #f8fafc;
      color: var(--text-main);
      font-size: 0.875rem;
    }
    .form-control:focus, .form-select:focus { 
      border-color: var(--primary-color); 
      background-color: #ffffff; 
      box-shadow: 0 0 0 4px rgba(0, 73, 150, 0.1) !important; 
    }
    .input-group-text { 
      background-color: transparent; 
      border: 1px solid var(--border-color); 
      color: var(--text-muted);
    }
    
    /* Elegant Glow Scrollbars */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }
    ::-webkit-scrollbar-track {
      background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 100px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }
    /* Automatic Enterprise Header Card Conversion */
    .card:has(> .card-body.border-primary) .card-body.border-primary,
    .card:has(> .card-body.border-primary) .card-body.border-start.border-primary,
    .card:has(> .card-body.border-primary) .card-body.border-start.border-4.border-primary,
    .card:has(> .card-body.border-primary) .card-body.border-start.border-5.border-primary {
      border-left: none !important;
      padding: 2rem !important;
    }
    
    .card:has(> .card-body.border-primary) {
      background: var(--primary-gradient) !important;
      border: none !important;
      box-shadow: 0 12px 24px rgba(0, 73, 150, 0.12) !important;
      position: relative !important;
      overflow: hidden !important;
      border-radius: var(--radius-lg) !important;
    }
    
    .card:has(> .card-body.border-primary)::after {
      content: '';
      position: absolute;
      top: -50%;
      right: -10%;
      width: 350px;
      height: 350px;
      background: radial-gradient(circle, rgba(255, 184, 0, 0.18) 0%, rgba(255,255,255,0) 70%);
      border-radius: 50%;
      pointer-events: none;
    }
    
    .card:has(> .card-body.border-primary) h4,
    .card:has(> .card-body.border-primary) h5,
    .card:has(> .card-body.border-primary) .card-title {
      color: #ffffff !important;
      font-weight: 800 !important;
      font-size: 1.6rem !important;
    }
    
    .card:has(> .card-body.border-primary) p,
    .card:has(> .card-body.border-primary) .text-muted {
      color: rgba(255, 255, 255, 0.75) !important;
      font-weight: 400 !important;
      font-size: 0.95rem !important;
      line-height: 1.6;
    }
    
    .card:has(> .card-body.border-primary) .badge.bg-primary {
      background-color: rgba(255, 255, 255, 0.2) !important;
      color: #ffffff !important;
      border: 1px solid rgba(255, 255, 255, 0.15) !important;
      font-weight: 700 !important;
    }
    
    .card:has(> .card-body.border-primary) .btn-primary {
      background-color: var(--secondary-color) !important;
      border-color: var(--secondary-color) !important;
      color: #1e293b !important;
      box-shadow: 0 4px 12px rgba(255, 184, 0, 0.25) !important;
      font-weight: 700 !important;
    }
    
    .card:has(> .card-body.border-primary) .btn-primary:hover {
      background-color: #e5a500 !important;
      border-color: #e5a500 !important;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(255, 184, 0, 0.35) !important;
    }

    /* Custom Animations */
    .fade-in-up { animation: fadeInUp 0.6s ease-out both; }
    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }
    .stagger-4 { animation-delay: 0.4s; }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .hover-scale { transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
    .hover-scale:hover { transform: scale(1.02); }
    
    .hover-elevate { transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .hover-elevate:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg) !important; }

    /* Staggered Table Row Appearance (Global) */
    .table tbody tr {
        opacity: 0;
        animation: slideInRight 0.5s ease forwards;
    }
    <?php for($i=1; $i<=50; $i++): ?>
    .table tbody tr:nth-child(<?= $i ?>) { animation-delay: <?= 0.1 + ($i * 0.04) ?>s; }
    <?php endfor; ?>

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    /* Smooth page loading */
    #main-wrapper { opacity: 0; transition: opacity 0.5s ease; }
    #main-wrapper.loaded { opacity: 1; }
  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between px-4 py-3 border-bottom mb-2 bg-white" style="position: sticky; top: 0; z-index: 10;">
          <a href="<?= base_url('dashboard') ?>" class="text-nowrap logo-img d-flex align-items-center text-decoration-none">
            <img src="<?= base_url('images/logo_simpa.png') ?>" alt="SIMPA Logo" height="60" class="object-contain">
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('dashboard') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>

            <?php if (session()->get('role') == 'Admin') : ?>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">ADMINISTRATOR</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('admin/app-master') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-apps"></i>
                </span>
                <span class="hide-menu">Master Aplikasi</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('admin/kpi') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-target"></i>
                </span>
                <span class="hide-menu">Master KPI</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('admin/approval') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-checklist"></i>
                </span>
                <span class="hide-menu">Antrean Approval</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('admin/cobit') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-shield-check"></i>
                </span>
                <span class="hide-menu">Form COBIT-19</span>
              </a>
            </li>
            <?php endif; ?>

            <?php if (session()->get('role') == 'User') : ?>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">OPERATION</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('progress') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-chart-line"></i>
                </span>
                <span class="hide-menu">Kelola Progres</span>
              </a>
            </li>
            <?php endif; ?>

            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">MONITORING</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('monitoring') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-presentation-analytics"></i>
                </span>
                <span class="hide-menu">Executive Monitoring</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('document-center') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-folder"></i>
                </span>
                <span class="hide-menu">Pusat Dokumen</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('absensi/list') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-users"></i>
                </span>
                <span class="hide-menu">Daftar Absensi</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('calendar') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-calendar"></i>
                </span>
                <span class="hide-menu">Kalender Progres</span>
              </a>
            </li>

            <?php if (session()->get('role') == 'Admin') : ?>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">SETTINGS</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('master/karyawan') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-users"></i>
                </span>
                <span class="hide-menu">Kelola User</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('master/divisi') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-building"></i>
                </span>
                <span class="hide-menu">Kelola Divisi</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('admin/logs') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-history"></i>
                </span>
                <span class="hide-menu">Log Aktivitas</span>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <div class="d-none d-md-block text-end me-3">
                  <p class="mb-0 fs-2 text-primary fw-bold text-uppercase"><?= session()->get('role') ?></p>
                  <p class="mb-0 fs-3 fw-semibold text-dark"><?= session()->get('nama_lengkap') ?></p>
              </div>
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <?php 
                    $photo = session()->get('photo');
                    $avatar = (!empty($photo)) 
                      ? base_url('uploads/profile/' . $photo) 
                      : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';
                  ?>
                  <img src="<?= $avatar ?>" alt="Profile" width="35" height="35" class="rounded-circle border border-2 border-primary shadow-sm bg-light" style="object-fit: cover;">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item" data-bs-toggle="modal" data-bs-target="#modalGantiFoto">
                      <i class="ti ti-user-circle fs-6"></i>
                      <p class="mb-0 fs-3">Ganti Foto Profil</p>
                    </a>
                    <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      
      <div id="main-content" class="container-fluid">
        <!-- Render Content Here -->
        <div class="animate__animated animate__fadeIn">
          <?= $this->renderSection('content') ?>
        </div>
        

      </div>
    </div>
  </div>
  
  <script src="<?= base_url('template/src/assets/libs/jquery/dist/jquery.min.js') ?>"></script>
  <script src="<?= base_url('template/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('template/src/assets/js/sidebarmenu.js') ?>"></script>
  <script src="<?= base_url('template/src/assets/js/app.min.js') ?>"></script>
  <script src="<?= base_url('template/src/assets/libs/simplebar/dist/simplebar.js') ?>"></script>
  
  <!-- Animation Scripts -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      
      // --- GLOBAL AUTO ANIMATOR ---
      // Automatically add fade-up animations and hover-elevate to all cards and important elements across ALL pages
      const animateElements = document.querySelectorAll('.container-fluid .card:not([data-aos]), .container-fluid .alert:not([data-aos]), .container-fluid form:not([data-aos]), .container-fluid .table-responsive:not([data-aos])');
      
      animateElements.forEach((el, index) => {
        el.setAttribute('data-aos', 'fade-up');
        // Add a slight staggered delay
        let delay = ((index % 4) + 1) * 100;
        el.setAttribute('data-aos-delay', delay.toString());
        
        // Add hover elevate class to cards automatically if it's a card
        if(el.classList.contains('card') && !el.classList.contains('hover-scale')) {
            el.classList.add('hover-elevate');
        }
      });
      // ----------------------------

      // Initialize AOS
      AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        mirror: false
      });

      // Page Load Animation
      document.getElementById('main-wrapper').classList.add('loaded');

      // Add stagger animations to sidebar items
      const sidebarItems = document.querySelectorAll('#sidebarnav .sidebar-item');
      sidebarItems.forEach((item, index) => {
        item.style.animationDelay = `${(index + 1) * 0.05}s`;
        item.classList.add('animate__animated', 'animate__fadeInLeft');
      });

      // --- GLOBAL AJAX FORMS INTERCEPTOR ---
      document.addEventListener('submit', function(e) {
          const form = e.target;
          
          // Skip auth actions
          if (form.action.includes('logout') || form.action.includes('login') || form.action.includes('auth')) {
              return;
          }
          
          // Skip already custom-handled forms
          if (form.id === 'formProgress' || form.id === 'formApproval' || form.getAttribute('data-no-ajax')) {
              return;
          }

          e.preventDefault();
          const btn = form.querySelector('button[type="submit"]');
          const originalText = btn ? btn.innerHTML : '';
          if (btn) {
              btn.innerHTML = '<i class="ti ti-loader ti-spin"></i> Processing...';
              btn.disabled = true;
          }

          const formData = new FormData(form);
          fetch(form.action, {
              method: form.method || 'POST',
              body: formData,
              headers: {
                  'X-Requested-With': 'XMLHttpRequest'
              }
          })
          .then(res => {
              const contentType = res.headers.get('content-type');
              if (contentType && contentType.includes('application/json')) {
                  return res.json();
              } else {
                  window.location.reload();
                  return null;
              }
          })
          .then(data => {
              if (!data) return;
              if (data.status === 'success') {
                  const modalEl = form.closest('.modal');
                  if (modalEl) {
                      const modalInstance = bootstrap.Modal.getInstance(modalEl);
                      if (modalInstance) modalInstance.hide();
                  }
                  alert(data.message || 'Berhasil menyimpan data.');
                  
                  // Special check for AppMaster module modal
                  if (form.action.includes('save-module')) {
                      if (typeof showModulModal === 'function') {
                          const appId = document.getElementById('modul_app_id').value;
                          const appName = document.getElementById('modul_app_name').innerText.replace('Aplikasi: ', '');
                          showModulModal(appId, appName);
                          form.reset();
                          if (btn) {
                              btn.innerHTML = originalText;
                              btn.disabled = false;
                          }
                      } else {
                          window.location.reload();
                      }
                  } else {
                      window.location.reload();
                  }
              } else {
                  alert(data.message || 'Terjadi kesalahan');
                  if (btn) {
                      btn.innerHTML = originalText;
                      btn.disabled = false;
                  }
              }
          })
          .catch(err => {
              console.error(err);
              if (btn) {
                  btn.innerHTML = originalText;
                  btn.disabled = false;
              }
          });
      });

      // --- GLOBAL AJAX DELETES INTERCEPTOR ---
      document.addEventListener('click', function(e) {
          const anchor = e.target.closest('a');
          if (!anchor || !anchor.href) return;
          
          const isDeleteRoute = anchor.href.includes('/delete/') || anchor.href.includes('/delete-module/');
          if (!isDeleteRoute) return;

          e.preventDefault();

          const clickAttr = anchor.getAttribute('onclick');
          let confirmMsg = 'Apakah Anda yakin ingin menghapus data ini?';
          if (clickAttr && clickAttr.includes('confirm')) {
              const match = clickAttr.match(/confirm\('([^']+)'\)/);
              if (match) confirmMsg = match[1];
          }
              
          if (!confirm(confirmMsg)) {
              return;
          }

          fetch(anchor.href, {
              headers: {
                  'X-Requested-With': 'XMLHttpRequest'
              }
          })
          .then(res => {
              const contentType = res.headers.get('content-type');
              if (contentType && contentType.includes('application/json')) {
                  return res.json();
              } else {
                  window.location.reload();
                  return null;
              }
          })
          .then(data => {
              if (!data) return;
              if (data.status === 'success') {
                  // Dynamically remove row
                  const row = anchor.closest('tr');
                  if (row) {
                      row.style.transition = 'all 0.5s ease';
                      row.style.opacity = '0';
                      row.style.transform = 'scale(0.9)';
                      setTimeout(() => {
                          row.remove();
                          if (anchor.href.includes('/delete-module/')) {
                              if (typeof showModulModal === 'function') {
                                  const appId = document.getElementById('modul_app_id').value;
                                  const appName = document.getElementById('modul_app_name').innerText.replace('Aplikasi: ', '');
                                  showModulModal(appId, appName);
                              }
                          }
                      }, 500);
                  } else {
                      window.location.reload();
                  }
              } else {
                  alert(data.message || 'Gagal menghapus data.');
              }
          })
          .catch(err => {
              console.error(err);
              alert('Terjadi kesalahan jaringan.');
          });
      });

      // --- SPA SIDEBAR NAVIGATION ---
      $(document).on('click', '.sidebar-link', function(e) {
          const url = $(this).attr('href');
          // Skip empty links or logout routes
          if (!url || url === 'javascript:void(0)' || url.includes('#') || url.includes('logout')) return;

          e.preventDefault();

          // Close sidebar on mobile
          if (window.innerWidth < 1200) {
              $('#sidebarCollapse').click();
          }

          // Update active state
          $('.sidebar-link').removeClass('active');
          $(this).addClass('active');

          const $mainContent = $('#main-content');
          $mainContent.css({'opacity': '0.5', 'pointer-events': 'none'});

          $.get(url, function(data) {
              // Hack to run scripts that wait for DOMContentLoaded, since DOM is already loaded
              data = data.replace(/document\.addEventListener\(['"]DOMContentLoaded['"],\s*function\s*\(\)\s*\{/g, '$(function() {');
              
              const parser = new DOMParser();
              const doc = parser.parseFromString(data, 'text/html');
              const newContent = doc.querySelector('#main-content');
              
              if (newContent) {
                  // Use jQuery html() to inject and automatically execute inline scripts
                  $mainContent.html(newContent.innerHTML);
                  document.title = doc.title;
                  window.history.pushState({path: url}, '', url);
                  
                  // Re-initialize animations globally
                  const animateElements = document.querySelectorAll('#main-content .card:not([data-aos]), #main-content .alert:not([data-aos]), #main-content form:not([data-aos]), #main-content .table-responsive:not([data-aos])');
                  animateElements.forEach((el, index) => {
                      el.setAttribute('data-aos', 'fade-up');
                      let delay = ((index % 4) + 1) * 100;
                      el.setAttribute('data-aos-delay', delay.toString());
                      if(el.classList.contains('card') && !el.classList.contains('hover-scale')) {
                          el.classList.add('hover-elevate');
                      }
                  });
                  
                  if (typeof AOS !== 'undefined') {
                      AOS.init({ duration: 800, once: true });
                      setTimeout(() => AOS.refreshHard(), 100);
                  }
                  
                  // Also re-render modals section if they are part of the new page
                  const newModals = doc.querySelector('#dynamic-modals');
                  if (newModals) {
                      $('#dynamic-modals').html(newModals.innerHTML);
                  }
                  
                  // Scroll to top
                  window.scrollTo(0,0);
              } else {
                  window.location.href = url;
              }
          }).fail(function() {
              window.location.href = url;
          }).always(function() {
              $mainContent.css({'opacity': '1', 'pointer-events': 'auto'});
          });
      });

      $(window).on('popstate', function() {
          window.location.reload();
      });
    });
  </script>
  <div id="dynamic-modals">
    <?= $this->renderSection('modals') ?>
  </div>

  <!-- Modal Ganti Foto Profil -->
  <div class="modal fade" id="modalGantiFoto" tabindex="-1" aria-labelledby="modalGantiFotoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold fs-3" id="modalGantiFotoLabel">Ganti Profil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('dashboard/update-profile-photo') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body text-center p-4">
                    <div class="mb-4">
                        <img src="<?= $avatar ?>" alt="Profile Preview" class="rounded-circle border border-4 border-light shadow-sm" width="100" height="100" style="object-fit: cover;">
                    </div>
                    <div class="text-start mb-3">
                        <label class="form-label fw-bold small">Pilih Foto Baru</label>
                        <input type="file" name="photo" class="form-control form-control-sm" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Update Foto</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</body>

</html>

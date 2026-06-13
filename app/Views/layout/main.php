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
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
  
  <!-- Animation Libraries -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  
  <!-- FullCalendar -->
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
  
  <style>
    :root {
      --primary-color: #3874ff;
      --secondary-color: #f3f6f9;
      --primary-gradient: none;
      --accent-gradient: none;
      --surface-color: #ffffff;
      --bg-color: #f5f7fa;
      --text-main: #31374a;
      --text-muted: #8a94ad;
      --border-color: #e3ebf6;
      --shadow-sm: 0 .125rem .25rem rgba(116, 129, 148, 0.075);
      --shadow-md: 0 .5rem 1rem rgba(116, 129, 148, 0.15);
      --shadow-lg: 0 1rem 2rem rgba(116, 129, 148, 0.15);
      --radius-md: 0.375rem;
      --radius-lg: 0.5rem;
    }
    
    body {
      font-family: 'Nunito Sans', sans-serif !important;
      background-color: var(--bg-color);
      color: var(--text-main);
      overflow-x: hidden;
      font-weight: 400;
      font-size: 0.875rem; /* Phoenix uses 14px as base */
    }
    
    h1, h2, h3, h4, h5, h6, .hero-card h4 {
      font-family: 'Nunito Sans', sans-serif !important;
      font-weight: 700 !important;
      letter-spacing: -0.01em;
    }
    
    /* Elegant Corporate Cards */
    .card {
      border: 1px solid var(--border-color) !important;
      border-radius: var(--radius-lg) !important;
      box-shadow: none !important;
      transition: all 0.2s ease-in-out;
      background: var(--surface-color);
    }
    .card:hover {
      box-shadow: var(--shadow-md) !important;
    }
    
    /* Hero / Header Cards */
    .hero-card {
      background: var(--surface-color);
      color: var(--text-main);
      border-radius: var(--radius-lg) !important;
      padding: 2.25rem !important;
      position: relative;
      overflow: hidden;
      box-shadow: var(--shadow-sm) !important;
      border: 1px solid var(--border-color) !important;
    }
    .hero-card h4 { color: var(--text-main) !important; font-weight: 800; }
    .hero-card p { font-weight: 400; color: var(--text-muted) !important; }
    
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
      color: #ffffff !important;
      box-shadow: none !important;
    }
    .btn-primary:hover { 
      background: #2b5bc7 !important;
      border-color: #2b5bc7 !important;
      box-shadow: var(--shadow-md) !important;
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
      background-color: transparent !important; 
      color: var(--text-muted) !important; 
      font-weight: 800 !important; 
      text-transform: uppercase; 
      font-size: 0.75rem; 
      letter-spacing: 0.05em; 
      border-bottom: 1px solid var(--border-color) !important; 
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
      white-space: normal !important;
      line-height: 1.3;
    }
    .sidebar-link:hover { 
      background-color: rgba(0, 73, 150, 0.04) !important; 
      color: var(--primary-color) !important; 
      transform: translateX(6px); 
      border-color: rgba(0, 73, 150, 0.08);
    }
    .sidebar-link.active { 
      background: transparent !important; 
      color: var(--primary-color) !important; 
      font-weight: 700 !important;
      position: relative;
    }
    .sidebar-link.active::before {
      content: '';
      position: absolute;
      left: -1rem;
      top: 15%;
      height: 70%;
      width: 4px;
      background-color: var(--primary-color);
      border-radius: 0 4px 4px 0;
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
    html, body {
      max-width: 100vw;
      overflow-x: hidden;
    }
    
    @media (max-width: 768px) {
        .card-header.d-flex, .card-header .d-flex {
            flex-wrap: wrap !important;
        }
        .page-wrapper {
            overflow-x: hidden;
            width: 100%;
        }
        .container-fluid {
            padding-left: 12px !important;
            padding-right: 12px !important;
            overflow-x: hidden;
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        /* Hero section on mobile */
        .hero-gradient {
            flex-direction: column !important;
            padding: 1.5rem !important;
        }
        .hero-gradient .d-none.d-md-block {
            display: none !important;
        }
        .hero-gradient h2.display-6 {
            font-size: 1.4rem !important;
        }
        .hero-gradient p.fs-5 {
            font-size: 0.9rem !important;
        }
        /* Stat cards on mobile */
        .stat-card .display-5 {
            font-size: 1.75rem !important;
        }
        /* Card body padding */
        .card-body {
            padding: 1rem !important;
        }
        /* Badge font sizes */
        .badge.fs-2 { font-size: 0.7rem !important; }
        .badge.fs-3 { font-size: 0.75rem !important; }
        /* Responsive buttons in card header */
        .card-header .btn {
            font-size: 0.8rem !important;
            padding: 0.4rem 0.8rem !important;
        }
        /* Nav items on mobile */
        .app-header .navbar {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        /* Glass cards on mobile */
        .glass-card {
            border-radius: 0.875rem !important;
        }
        /* Hide overflow on body wrapper */
        .body-wrapper {
            overflow-x: hidden;
        }
    }

    @media (max-width: 576px) {
        /* Extra small screens */
        .container-fluid {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        .card {
            margin-bottom: 0.75rem !important;
        }
        /* Row gap reduction */
        .row.g-4 { --bs-gutter-x: 0.75rem; --bs-gutter-y: 0.75rem; }
        .row.g-3 { --bs-gutter-x: 0.5rem; --bs-gutter-y: 0.5rem; }
        /* Table cell font */
        .table thead th, .table tbody td {
            font-size: 0.78rem !important;
            padding: 0.75rem 0.5rem !important;
        }
        /* Progress text */
        .d-flex.justify-content-between.align-items-end .fs-4 {
            font-size: 0.85rem !important;
        }
    }

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
    /* Automatic Enterprise Header Card Conversion - Reset for Phoenix theme */
    .card:has(> .card-body.border-primary) .card-body.border-primary,
    .card:has(> .card-body.border-primary) .card-body.border-start.border-primary,
    .card:has(> .card-body.border-primary) .card-body.border-start.border-4.border-primary,
    .card:has(> .card-body.border-primary) .card-body.border-start.border-5.border-primary {
      border-left: none !important;
      padding: 2rem !important;
    }
    
    .card:has(> .card-body.border-primary) {
      background: var(--surface-color) !important;
      border: 1px solid var(--border-color) !important;
      box-shadow: var(--shadow-sm) !important;
      position: relative !important;
      overflow: hidden !important;
      border-radius: var(--radius-lg) !important;
    }
    
    .card:has(> .card-body.border-primary)::after {
      display: none;
    }
    
    .card:has(> .card-body.border-primary) h4,
    .card:has(> .card-body.border-primary) h5,
    .card:has(> .card-body.border-primary) .card-title {
      color: var(--text-main) !important;
      font-weight: 800 !important;
      font-size: 1.6rem !important;
    }
    
    .card:has(> .card-body.border-primary) p,
    .card:has(> .card-body.border-primary) .text-muted {
      color: var(--text-muted) !important;
      font-weight: 400 !important;
      font-size: 0.95rem !important;
      line-height: 1.6;
    }
    
    .card:has(> .card-body.border-primary) .badge.bg-primary {
      background-color: rgba(56, 116, 255, 0.1) !important;
      color: var(--primary-color) !important;
      border: none !important;
      font-weight: 700 !important;
    }
    
    .card:has(> .card-body.border-primary) .btn-primary {
      background-color: var(--primary-color) !important;
      border-color: var(--primary-color) !important;
      color: #ffffff !important;
      box-shadow: none !important;
      font-weight: 600 !important;
    }
    
    .card:has(> .card-body.border-primary) .btn-primary:hover {
      background-color: #2b5bc7 !important;
      border-color: #2b5bc7 !important;
      transform: translateY(-2px);
      box-shadow: var(--shadow-sm) !important;
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
    .hover-elevate:hover { transform: translateY(-4px); box-shadow: var(--shadow-md) !important; }

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

            <?php if (session()->get('role') == 'Admin' || session()->get('role') == 'PM') : ?>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">ADMINISTRATOR & MANAJEMEN</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('admin/app-master') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-apps"></i>
                </span>
                <span class="hide-menu">Master Aplikasi</span>
              </a>
            </li>
            <?php if (session()->get('role') == 'Admin') : ?>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('admin/kpi') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-target"></i>
                </span>
                <span class="hide-menu">Master KPI</span>
              </a>
            </li>
            <?php endif; ?>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('admin/approval') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-checklist"></i>
                </span>
                <span class="hide-menu">Antrean Approval</span>
              </a>
            </li>
            <?php if (session()->get('role') == 'Admin') : ?>
            <li class="sidebar-item">
              <a class="sidebar-link" href="<?= base_url('admin/cobit') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-shield-check"></i>
                </span>
                <span class="hide-menu">Form COBIT-19</span>
              </a>
            </li>
            <?php endif; ?>
            <?php endif; ?>

            <?php if (session()->get('role') == 'User' || session()->get('role') == 'PM') : ?>
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
                  <p class="mb-0 text-muted" style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;"><?= session()->get('role') ?></p>
                  <p class="mb-0 text-dark fw-bold" style="font-size: 0.85rem;"><?= session()->get('nama_lengkap') ?></p>
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

      // --- SPA RELOAD FUNCTION ---
      function reloadSPA(url = window.location.href, isNewPage = false) {
          const $mainContent = $('#main-content');
          $.get(url, function(data) {
              data = data.replace(/document\.addEventListener\(['"]DOMContentLoaded['"],\s*function\s*\(\)\s*\{/g, '$(function() {');
              
              const parser = new DOMParser();
              const doc = parser.parseFromString(data, 'text/html');
              const newContent = doc.querySelector('#main-content');
              
              if (newContent) {
                  $mainContent.html(newContent.innerHTML);
                  document.title = doc.title;
                  if (isNewPage) {
                      window.history.pushState({path: url}, '', url);
                      window.scrollTo(0,0);
                  }
                  
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
                      try {
                          AOS.init({ duration: 800, once: true });
                          if (typeof AOS.refreshHard === 'function') {
                              setTimeout(() => AOS.refreshHard(), 100);
                          } else {
                              setTimeout(() => AOS.refresh(), 100);
                          }
                      } catch(e) { console.error('AOS Error:', e); }
                  }
                  
                  const newModals = doc.querySelector('#dynamic-modals');
                  if (newModals) {
                      $('#dynamic-modals').html(newModals.innerHTML);
                  }
              } else {
                  window.location.href = url;
              }
          }).fail(function() {
              window.location.href = url;
          });
      }

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
                  reloadSPA();
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
                          reloadSPA();
                      }
                  } else {
                      reloadSPA();
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
                  reloadSPA();
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
                      reloadSPA();
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

          reloadSPA(url, true);
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

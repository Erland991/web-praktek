<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Monitoring Aset SI</title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('template/src/assets/images/logos/favicon.png') ?>" />
  <link rel="stylesheet" href="<?= base_url('template/src/assets/css/styles.min.css') ?>" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Animation Libraries -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #0b5ed7;
      --primary-gradient: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
      --surface-color: #ffffff;
      --bg-color: #f8f9fa;
      --text-main: #2b3445;
      --text-muted: #7d879c;
      --border-color: #e3e9ef;
      --shadow-sm: 0 2px 4px rgba(0,0,0,0.04);
      --shadow-md: 0 4px 6px rgba(0,0,0,0.07);
      --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
      --radius-md: 12px;
      --radius-lg: 16px;
    }
    
    body {
      font-family: 'Inter', sans-serif !important;
      background-color: var(--bg-color);
      color: var(--text-main);
    }
    
    h1, h2, h3, h4, h5, h6, .hero-card h4 {
      font-family: 'Outfit', sans-serif !important;
    }
    
    /* Elegant Cards */
    .card {
      border: 1px solid rgba(255,255,255,0.4) !important;
      border-radius: var(--radius-lg) !important;
      box-shadow: var(--shadow-sm) !important;
      transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
      background: var(--surface-color);
    }
    .card:hover {
      box-shadow: var(--shadow-lg) !important;
      border-color: rgba(13, 110, 253, 0.1) !important;
    }
    
    /* Hero / Header Cards */
    .hero-card {
      background: var(--primary-gradient);
      color: white;
      border-radius: var(--radius-lg) !important;
      padding: 2rem !important;
      position: relative;
      overflow: hidden;
      box-shadow: 0 10px 20px rgba(13, 110, 253, 0.15) !important;
    }
    .hero-card::after {
      content: '';
      position: absolute;
      top: -50%;
      right: -10%;
      width: 300px;
      height: 300px;
      background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
      border-radius: 50%;
    }
    .hero-card h4 { color: white !important; font-weight: 700; letter-spacing: -0.5px; }
    .hero-card p { opacity: 0.9; }
    
    /* Buttons */
    .btn {
      border-radius: 8px !important;
      font-weight: 500 !important;
      letter-spacing: 0.3px;
      transition: all 0.2s ease !important;
      padding: 0.5rem 1.25rem;
    }
    .btn-primary { background: var(--primary-color) !important; border-color: var(--primary-color) !important; box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2) !important; }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 12px rgba(13, 110, 253, 0.25) !important; }
    
    /* Tables */
    .table-responsive { border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-color); }
    .table thead th { background-color: #f1f5f9 !important; color: #475569 !important; font-weight: 600 !important; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; border-bottom: 2px solid var(--border-color) !important; padding: 1rem; }
    .table tbody td { padding: 1rem; vertical-align: middle; border-bottom: 1px solid var(--border-color); color: var(--text-main); }
    .table tbody tr:hover { background-color: #f8fafc !important; }
    
    /* Badges */
    .badge { padding: 0.5em 0.8em !important; font-weight: 600; border-radius: 6px !important; letter-spacing: 0.3px; }
    .bg-light-success { background-color: #ecfdf5 !important; color: #059669 !important; border: 1px solid #d1fae5; }
    .bg-light-warning { background-color: #fffbeb !important; color: #d97706 !important; border: 1px solid #fef3c7; }
    .bg-light-danger { background-color: #fef2f2 !important; color: #dc2626 !important; border: 1px solid #fee2e2; }
    .bg-light-primary { background-color: #eff6ff !important; color: #2563eb !important; border: 1px solid #dbeafe; }
    
    /* Sidebar */
    .left-sidebar { box-shadow: 4px 0 24px rgba(0,0,0,0.02) !important; border-right: 1px solid var(--border-color); background: #ffffff; }
    .sidebar-link { border-radius: 10px !important; margin: 0 0.8rem; transition: all 0.3s ease; color: var(--text-muted) !important; font-weight: 500; }
    .sidebar-link:hover { background-color: #f1f5f9 !important; color: var(--primary-color) !important; transform: translateX(4px); }
    .sidebar-link.active { background: linear-gradient(90deg, rgba(13,110,253,0.1) 0%, rgba(13,110,253,0.02) 100%) !important; color: var(--primary-color) !important; border-left: 3px solid var(--primary-color); }
    .sidebar-link i { font-size: 1.25rem; transition: transform 0.3s; }
    .sidebar-link:hover i { transform: scale(1.1); }
    
    /* Header */
    .app-header { background: rgba(255,255,255,0.85) !important; backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,0.05); box-shadow: 0 4px 20px rgba(0,0,0,0.02) !important; transition: all 0.3s; }
    
    /* Inputs */
    .form-control, .form-select { border-radius: 8px; border: 1px solid var(--border-color); padding: 0.6rem 1rem; transition: all 0.2s; box-shadow: none !important; background-color: #f8fafc; }
    .form-control:focus, .form-select:focus { border-color: var(--primary-color); background-color: #fff; box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1) !important; }
    .input-group-text { background-color: transparent; border: 1px solid var(--border-color); }

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
    .hover-elevate:hover { transform: translateY(-6px); box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important; }

    /* Staggered Table Row Appearance (Global) */
    .table tbody tr {
        opacity: 0;
        animation: slideInRight 0.5s ease forwards;
    }
    <?php for($i=1; $i<=50; $i++): ?>
    .table tbody tr:nth-child(<?= $i ?>) { animation-delay: <?= 0.1 + ($i * 0.05) ?>s; }
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
        <div class="brand-logo d-flex align-items-center justify-content-between px-4">
          <a href="<?= base_url('dashboard') ?>" class="text-nowrap logo-img d-flex align-items-center mt-4 text-decoration-none">
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
              <a class="sidebar-link" href="<?= base_url('admin/cobit') ?>" aria-expanded="false">
                <span>
                  <i class="ti ti-report"></i>
                </span>
                <span class="hide-menu">Form COBIT-19</span>
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
                    $jk = session()->get('jenis_kelamin');
                    $avatar = ($jk == 'P') 
                      ? 'https://cdn-icons-png.flaticon.com/512/6997/6997674.png' 
                      : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';
                  ?>
                  <img src="<?= $avatar ?>" alt="Profile" width="35" height="35" class="rounded-circle border border-2 border-primary shadow-sm bg-light">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      
      <div class="container-fluid">
        <!-- Render Content Here -->
        <div class="animate__animated animate__fadeIn">
          <?= $this->renderSection('content') ?>
        </div>
        
        <div class="py-6 px-6 text-center mt-4">
          <p class="mb-0 fs-4">&copy; 2026 PT Surveyor Indonesia | Portal Monitoring Progres Aplikasi. Design based on <a href="https://adminmart.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">AdminMart</a></p>
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
    });
  </script>
  <?= $this->renderSection('modals') ?>
</body>

</html>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Monitoring Aset SI</title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('template/src/assets/images/logos/favicon.png') ?>" />
  <link rel="stylesheet" href="<?= base_url('template/src/assets/css/styles.min.css') ?>" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="<?= base_url('dashboard') ?>" class="text-nowrap logo-img d-flex align-items-center mt-3 gap-2 text-decoration-none">
            <div class="bg-primary p-2 rounded text-white shadow-sm">
                <i class="fas fa-server"></i>
            </div>
            <span class="fw-bold fs-5 text-dark">Monitoring SI</span>
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
              <span class="hide-menu">ADMINISTRATION</span>
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
                  <img src="<?= base_url('template/src/assets/images/profile/user-1.jpg') ?>" alt="" width="35" height="35" class="rounded-circle">
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
        <?= $this->renderSection('content') ?>
        
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
</body>

</html>

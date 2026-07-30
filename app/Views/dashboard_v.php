<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row mb-4 mt-2">
    <div class="col-12" data-aos="fade-down">
        <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-3">
            <div>
                <h3 class="fw-bolder text-dark mb-1">Executive Dashboard</h3>
                <p class="mb-0 text-muted fs-3">
                    Selamat datang, <span class="text-dark fw-bold"><?= session()->get('nama_lengkap') ?></span>. Berikut adalah ringkasan performa Anda.
                </p>
            </div>
            <div class="d-none d-lg-block text-end">
                <span class="badge bg-light-primary text-primary fs-3 fw-bold px-3 py-2 rounded-pill border border-primary border-opacity-10"><i class="ti ti-building-monitor me-1"></i> SIMPA</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Stats Cards -->
    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="card h-100 hover-elevate">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="text-muted mb-1 fs-3 fw-semibold text-uppercase tracking-wider">Total Aplikasi</p>
                        <h2 class="fw-bolder mb-0 text-dark"><?= number_format($total_aset, 0, ',', '.') ?></h2>
                    </div>
                    <div class="p-3 bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                        <i class="ti ti-box fs-7 text-primary"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-3 empty-state">
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill fw-semibold"><i class="ti ti-arrow-up-right"></i> +12%</span>
                    <span class="text-muted fs-3 ms-2">Bulan ini</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="card h-100 hover-elevate">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="text-muted mb-1 fs-3 fw-semibold text-uppercase tracking-wider">PIC Terdaftar</p>
                        <h2 class="fw-bolder mb-0 text-dark"><?= number_format($total_pic, 0, ',', '.') ?></h2>
                    </div>
                    <div class="p-3 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                        <i class="ti ti-users fs-7 text-success"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-3">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill fw-semibold"><i class="ti ti-minus"></i> Tetap</span>
                    <span class="text-muted fs-3 ms-2">Bulan ini</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="card h-100 hover-elevate">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="text-muted mb-1 fs-3 fw-semibold text-uppercase tracking-wider">Total Divisi</p>
                        <h2 class="fw-bolder mb-0 text-dark"><?= number_format($total_divisi, 0, ',', '.') ?></h2>
                    </div>
                    <div class="p-3 bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                        <i class="ti ti-building-monument fs-7 text-warning"></i>
                    </div>
                </div>
                 <div class="d-flex align-items-center mt-3">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill fw-semibold"><i class="ti ti-minus"></i> Tetap</span>
                    <span class="text-muted fs-3 ms-2">Bulan ini</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
        <div class="card h-100 hover-elevate">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="text-muted mb-1 fs-3 fw-semibold text-uppercase tracking-wider">Aplikasi Digital</p>
                        <h2 class="fw-bolder mb-0 text-dark"><?= number_format($total_app, 0, ',', '.') ?></h2>
                    </div>
                    <div class="p-3 bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                        <i class="ti ti-apps fs-7 text-danger"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-3">
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill fw-semibold"><i class="ti ti-arrow-up-right"></i> +3%</span>
                    <span class="text-muted fs-3 ms-2">Bulan ini</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Chart 1: Distribusi Aplikasi -->
    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="500">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark" style="font-size: 1.25rem;">Distribusi Aplikasi Per Kategori</h4>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Jumlah aplikasi Aktif vs Maintenance</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4 pt-4">
                <div style="height: 300px; position: relative;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Chart 2: Capaian Progres Proyek -->
    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="500">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark" style="font-size: 1.25rem;">Capaian Progres Proyek</h4>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Perbandingan Target vs Progres Aktual Aplikasi</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4 pt-4">
                <div style="height: 300px; position: relative;">
                    <canvas id="progressChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Inventory Table -->
<div class="card mb-4" data-aos="fade-up" data-aos-delay="500">
    <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="flex-grow-1" style="min-width: 320px;">
            <h5 class="fw-bold mb-1 text-dark"><i class="ti ti-list-check text-primary me-2"></i>Database Inventaris & Aplikasi</h5>
            <p class="text-muted fs-3 mb-0">Manajemen komprehensif aplikasi IT dan aplikasi terpusat.</p>
        </div>
        
        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-xl-end">
            <div class="input-group input-group-sm rounded-3 shadow-none border" style="width: 120px;">
                <input type="date" id="filter_start_date" class="form-control border-0 shadow-none text-muted fs-2 px-1" value="<?= esc($start_date ?? '') ?>" title="Tanggal Mulai">
            </div>
            <span class="text-muted d-none d-sm-inline">-</span>
            <div class="input-group input-group-sm rounded-3 shadow-none border" style="width: 120px;">
                <input type="date" id="filter_end_date" class="form-control border-0 shadow-none text-muted fs-2 px-1" value="<?= esc($end_date ?? '') ?>" title="Tanggal Akhir">
            </div>
            <div class="input-group input-group-sm rounded-3 shadow-none border" style="width: 180px; max-width: 100%;">
                <span class="input-group-text bg-white border-0 text-muted px-2"><i class="ti ti-search fs-5"></i></span>
                <input type="text" id="filter_keyword" class="form-control border-0 ps-0 shadow-none fs-3" placeholder="Cari aplikasi..." value="<?= esc($keyword ?? '') ?>">
            </div>
            <button type="button" id="btn_filter_dashboard" class="btn btn-sm btn-primary px-3 rounded-3 fw-medium">
                <i class="ti ti-filter me-1"></i>Filter
            </button>
            <?php if(!empty($start_date) || !empty($keyword)): ?>
                <a href="<?= base_url('dashboard') ?>" class="btn btn-sm btn-light text-muted px-2 rounded-3" title="Reset Filter">
                    <i class="ti ti-refresh"></i>
                </a>
            <?php endif; ?>
            
            <div class="vr my-1 mx-1 d-none d-xl-block"></div>
            
            <a href="<?= base_url('dashboard/export') . '?' . http_build_query(['keyword' => $keyword ?? '', 'kategori' => $kategori ?? '', 'status' => $status ?? '', 'start_date' => $start_date ?? '', 'end_date' => $end_date ?? '']) ?>" class="btn btn-sm btn-outline-danger shadow-sm rounded-3 fw-medium px-3 text-nowrap" target="_blank">
                <i class="ti ti-file-type-pdf fs-5 me-1"></i> Cetak PDF
            </a>
            <?php if (session()->get('role') == 'Admin' || session()->get('role') == 'PM') : ?>
            <a href="<?= base_url('dashboard/add') ?>" class="btn btn-sm btn-dark px-3 rounded-3 fw-medium text-nowrap">
                <i class="ti ti-plus me-1"></i>Tambah Aplikasi
            </a>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted fs-3 text-uppercase fw-semibold tracking-wider">
                    <tr>
                        <th class="ps-4 py-3 border-bottom-0">Aplikasi Fisik / Digital</th>
                        <th class="py-3 border-bottom-0 text-center">Kategori</th>
                        <th class="py-3 border-bottom-0">Penanggung Jawab (PIC)</th>
                        <th class="text-center py-3 border-bottom-0">Status Sistem</th>
                        <th class="text-end px-4 py-3 border-bottom-0">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if(empty($semua_aset)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted">
                                <i class="ti ti-folder-off fs-1 mb-2"></i>
                                <h6>Tidak ada data ditemukan</h6>
                                <p class="fs-3 mb-0">Coba ubah kata kunci pencarian Anda.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php foreach ($semua_aset as $a) : ?>
                    <tr class="border-bottom">
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light-primary rounded-2 p-2 me-3 text-primary">
                                    <i class="ti ti-<?= (isset($a['pic_id']) ? 'apps' : 'box') ?> fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark"><?= esc($a['nama_aset'] ?? $a['nama_app'] ?? 'Aset Tidak Diketahui') ?></h6>
                                    <small class="text-muted d-block mt-1">ID Ref: #<?= sprintf('%04d', $a['id'] ?? 0) ?></small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark fw-medium border px-2 py-1 rounded-pill shadow-none fst-normal"><?= esc($a['kategori'] ?? 'Umum') ?></span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-sm d-flex align-items-center justify-content-center rounded-circle bg-light-info text-info border border-info border-opacity-10 fw-bold" style="width: 32px; height: 32px;">
                                    <?= substr(strtoupper(esc($a['pic'] ?? 'U')), 0, 1) ?>
                                </div>
                                <span class="fs-3 fw-medium text-dark"><?= esc($a['pic'] ?? 'Unassigned') ?></span>
                            </div>
                        </td>
                        <td class="text-center">
                            <?php if (isset($a['status']) && $a['status'] == 'Aktif') : ?>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-success rounded-circle" style="width:6px;height:6px;"></span> Online</span>
                            <?php else : ?>
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-warning rounded-circle" style="width:6px;height:6px;"></span> Maintenance</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end px-4">
                            <div class="d-flex flex-wrap gap-1 justify-content-end">
                                <?php if (isset($a['delete_request']) && $a['delete_request'] == 1): ?>
                                    <?php if (session()->get('role') == 'Admin' || session()->get('role') == 'PM') : ?>
                                        <button type="button" onclick="showReviewModal(<?= $a['id'] ?>, <?= !empty($a['is_app']) ? 1 : 0 ?>, '<?= esc($a['nama_aset'] ?? '') ?>', '<?= esc(str_replace(array("\r", "\n"), ' ', $a['delete_reason'] ?? '')) ?>')" class="btn btn-sm btn-warning text-white px-2" data-bs-toggle="tooltip" title="Review Pengajuan Penghapusan"><i class="ti ti-alert-circle fs-4"></i></button>
                                    <?php else: ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1 rounded-pill" style="font-size:0.7rem;"><i class="ti ti-clock"></i> Menunggu Dihapus</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if (!empty($a['is_app'])) : ?>
                                        <a href="<?= base_url('notula?app_id=' . ($a['id'] ?? '') . '&quick=1') ?>" class="btn btn-sm btn-light-success text-success hover-success px-2" data-bs-toggle="tooltip" title="Quick MoM Build"><i class="ti ti-bolt fs-4"></i></a>
                                        <a href="<?= base_url('absensi?app_id=' . ($a['id'] ?? '')) ?>" class="btn btn-sm btn-light-info text-info hover-info px-2" data-bs-toggle="tooltip" title="Buat Daftar Hadir"><i class="ti ti-users fs-4"></i></a>
                                    <?php endif; ?>
                                    <?php if (session()->get('role') == 'Admin' || session()->get('role') == 'PM') : ?>
                                        <a href="<?= !empty($a['is_app']) ? base_url('admin/app-master') : base_url('dashboard/edit/' . ($a['id'] ?? '')) ?>" class="btn btn-sm btn-light text-primary hover-primary px-2" data-bs-toggle="tooltip" title="<?= !empty($a['is_app']) ? 'Lihat di Master Aplikasi' : 'Edit Data' ?>"><i class="ti <?= !empty($a['is_app']) ? 'ti-eye' : 'ti-pencil' ?> fs-4"></i></a>
                                    <?php elseif (session()->get('role') == 'User' && (($a['pic'] ?? '') == session()->get('nama_lengkap'))) : ?>
                                        <button type="button" onclick="showRequestDeleteModal(<?= $a['id'] ?>, <?= !empty($a['is_app']) ? 1 : 0 ?>, '<?= esc($a['nama_aset'] ?? '') ?>')" class="btn btn-sm btn-light-danger text-danger hover-danger px-2" data-bs-toggle="tooltip" title="Ajukan Penghapusan"><i class="ti ti-trash fs-4"></i></button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Simple Pagination/Footer area -->
    <?php if(count($semua_aset) > 0): ?>
    <div class="card-footer bg-white border-top p-3 d-flex justify-content-between align-items-center text-muted fs-3">
        <span>Menampilkan <?= count($semua_aset) ?> entri data</span>
    </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function renderDashboardCharts() {
    // Enable Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // 1. Chart 1: Distribusi Aplikasi
    const canvas1 = document.getElementById('categoryChart');
    if (!canvas1) return;
    const ctx1 = canvas1.getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: <?= json_encode($cat_labels) ?>,
            datasets: [
                {
                    label: 'Aktif',
                    data: <?= json_encode($cat_aktif) ?>,
                    backgroundColor: '#2c7be5', // Phoenix primary blue
                    borderWidth: 0,
                    borderRadius: 2,
                    barPercentage: 0.5,
                    categoryPercentage: 0.5
                },
                {
                    label: 'Maintenance / Dev',
                    data: <?= json_encode($cat_mtn) ?>,
                    backgroundColor: '#d8e2ef', // Phoenix light blue / gray-ish
                    borderWidth: 0,
                    borderRadius: 2,
                    barPercentage: 0.5,
                    categoryPercentage: 0.5
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { 
                    display: true,
                    position: 'top',
                    align: 'end',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                        boxHeight: 8,
                        font: { family: "'Nunito Sans', sans-serif", size: 12 },
                        color: '#5e6e82'
                    }
                },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#000',
                    bodyColor: '#000',
                    borderColor: '#e3ebf6',
                    borderWidth: 1,
                    padding: 10,
                    boxPadding: 4,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            if (context.parsed.y !== null) {
                                label += context.parsed.y + ' Aplikasi';
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { borderDash: [4, 4], color: '#edf2f9', drawBorder: false },
                    ticks: { 
                        font: { family: "'Nunito Sans', sans-serif", size: 11 }, 
                        color: '#9da9bb',
                        callback: function(value) {
                            return value;
                        },
                        stepSize: 1
                    }
                },
                x: { 
                    grid: { display: false, drawBorder: false },
                    ticks: { 
                        font: { family: "'Nunito Sans', sans-serif", size: 11 }, 
                        color: '#9da9bb',
                        maxRotation: 0,
                        autoSkip: true,
                        maxTicksLimit: 5
                    }
                }
            }
        }
    });

    // 2. Chart 2: Capaian Progres Proyek
    const canvas2 = document.getElementById('progressChart');
    if (!canvas2) return;
    const ctx2 = canvas2.getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: <?= json_encode($proj_labels) ?>,
            datasets: [
                {
                    label: 'Target Progres',
                    data: <?= json_encode($proj_target) ?>,
                    borderColor: '#a6c5f7',
                    borderWidth: 2,
                    borderDash: [4, 4],
                    fill: false,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#a6c5f7',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    tension: 0
                },
                {
                    label: 'Progres Aktual',
                    data: <?= json_encode($proj_aktual) ?>,
                    borderColor: '#2c7be5',
                    borderWidth: 2,
                    fill: false,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#2c7be5',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    tension: 0 
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: { 
                    display: true,
                    position: 'top',
                    align: 'end',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                        boxHeight: 8,
                        font: { family: "'Nunito Sans', sans-serif", size: 12 },
                        color: '#5e6e82'
                    }
                },
                tooltip: {
                    backgroundColor: '#edf2f9',
                    titleColor: '#5e6e82',
                    bodyColor: '#344050',
                    bodyFont: { weight: 'bold', family: "'Nunito Sans', sans-serif" },
                    titleFont: { family: "'Nunito Sans', sans-serif" },
                    borderColor: '#d8e2ef',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 4,
                    usePointStyle: true,
                    itemSort: function(a, b) { return b.datasetIndex - a.datasetIndex; }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: { borderDash: [4, 4], color: '#edf2f9', drawBorder: false },
                    ticks: {
                        font: { family: "'Nunito Sans', sans-serif", size: 11 }, 
                        color: '#9da9bb',
                        callback: function(value) {
                            return value + '%';
                        },
                        stepSize: 20
                    }
                },
                x: {
                    grid: { borderDash: [4, 4], color: '#edf2f9', drawBorder: false },
                    ticks: {
                        font: { family: "'Nunito Sans', sans-serif", size: 11 }, 
                        color: '#9da9bb'
                    }
                }
            }
        }
    });
}

// Pastikan grafik dirender saat load pertama kali ATAU saat kembali dari SPA (pjax)
if (document.readyState === 'loading') {
    document.addEventListener("DOMContentLoaded", renderDashboardCharts);
} else {
    renderDashboardCharts();
}
</script>

<style>
    /* Premium Dashboard Styles */
    .tracking-wider { letter-spacing: 0.05em; }
    .hover-primary:hover { background-color: #003770 !important; color: white !important; }
    .hover-danger:hover { background-color: #dc2626 !important; color: white !important; }
    .avatar-sm { font-size: 14px; }
    .bg-light-info { background-color: rgba(255, 184, 0, 0.08) !important; border: 1px solid rgba(255, 184, 0, 0.15) !important; }
    .text-info { color: #d49a00 !important; }
    table > thead > tr > th { text-transform: uppercase; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px; }
</style>

<!-- Modal Ajukan Penghapusan (User) -->
<div class="modal fade" id="modalRequestDelete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-danger text-white p-4">
                <h5 class="modal-title fw-bold"><i class="ti ti-alert-triangle me-2"></i>Pengajuan Penghapusan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formRequestDelete" action="" method="POST" data-no-ajax="true">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <p class="mb-3">Anda akan mengajukan permohonan hapus untuk aplikasi <strong><span id="req_app_name"></span></strong>.</p>
                    <div class="alert alert-warning border-0 bg-light-warning text-warning d-flex align-items-center rounded-3 mb-3">
                        <i class="ti ti-info-circle fs-5 me-2"></i>
                        <div class="fs-3">Aplikasi tidak akan langsung terhapus. Permohonan Anda akan ditinjau oleh Admin/PM.</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alasan Penghapusan</label>
                        <textarea name="alasan" class="form-control" rows="3" placeholder="Contoh: Aplikasi sudah digantikan sistem baru, atau sudah tidak dipakai..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger px-4 fw-bold shadow-sm">KIRIM PENGAJUAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Review Penghapusan (Admin/PM) -->
<div class="modal fade" id="modalReviewDelete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-warning text-white p-4">
                <h5 class="modal-title fw-bold text-dark"><i class="ti ti-alert-circle me-2"></i>Review Pengajuan Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-2">User mengajukan penghapusan untuk aplikasi:</p>
                <h5 class="fw-bold mb-3"><span id="rev_app_name"></span></h5>
                <div class="alert alert-secondary border-0 d-flex flex-column rounded-3 mb-3">
                    <span class="fw-bold fs-2 text-uppercase text-muted mb-1">Alasan User:</span>
                    <div class="fs-3 text-dark fst-italic" id="rev_app_reason"></div>
                </div>
                <p class="fs-3 text-muted mb-0">Apakah Anda menyetujui penghapusan aplikasi ini secara permanen?</p>
            </div>
            <div class="modal-footer bg-light p-3 justify-content-between">
                <a href="#" id="btnRejectDelete" class="btn btn-outline-secondary px-4 fw-bold shadow-sm">TOLAK</a>
                <a href="#" id="btnApproveDelete" class="btn btn-danger px-4 fw-bold shadow-sm">SETUJUI & HAPUS</a>
            </div>
        </div>
    </div>
</div>

<style>
    #filter-progress-bar {
        position: fixed; top: 0; left: 0; height: 3px; width: 0%;
        background: linear-gradient(90deg, #3874ff, #00c6ff);
        z-index: 99999;
        transition: width 0.3s ease;
        border-radius: 0 2px 2px 0;
    }
</style>
<div id="filter-progress-bar"></div>

<script>
    // --- FILTER DASHBOARD: Menggunakan reloadSPA bawaan ---
    function doFilterDashboard() {
        const startDate = document.getElementById('filter_start_date').value;
        const endDate   = document.getElementById('filter_end_date').value;
        const keyword   = document.getElementById('filter_keyword').value;

        const params = new URLSearchParams();
        if (startDate) params.set('start_date', startDate);
        if (endDate)   params.set('end_date', endDate);
        if (keyword)   params.set('keyword', keyword);

        const url = '<?= base_url('dashboard') ?>' + (params.toString() ? '?' + params.toString() : '');

        // Tampilkan progress bar
        let progressBar = document.getElementById('filter-progress-bar');
        if (progressBar) {
            progressBar.style.width = '30%';
        }

        // Tampilkan loading
        const btn = document.getElementById('btn_filter_dashboard');
        if (btn) { btn.innerHTML = '<i class="ti ti-loader ti-spin me-1"></i>Loading...'; btn.disabled = true; }

        // Fetch data secara manual agar kita bisa menghapus animasi AOS
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.text())
            .then(html => {
                if (progressBar) progressBar.style.width = '70%';
                
                // Gunakan DOMParser untuk memparsing HTML
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newMainContent = doc.getElementById('main-content');
                
                if (newMainContent) {
                    // Hapus semua data-aos agar tidak berkedip (tidak ada animasi fade-up ulang)
                    newMainContent.querySelectorAll('[data-aos]').forEach(el => {
                        el.removeAttribute('data-aos');
                    });
                    
                    // Timpa konten
                    document.getElementById('main-content').innerHTML = newMainContent.innerHTML;
                    
                    // Re-init chart
                    if (typeof renderDashboardCharts === 'function') {
                        renderDashboardCharts();
                    }
                    
                    // Update URL browser
                    history.pushState(null, '', url);
                } else {
                    window.location.href = url; // Fallback
                }
                
                if (progressBar) {
                    progressBar.style.width = '100%';
                    setTimeout(() => { progressBar.style.width = '0%'; }, 300);
                }
            })
            .catch(error => {
                console.error('Filter error:', error);
                window.location.href = url; // Fallback jika gagal
            });
    }

    // Event Delegation menggunakan pure JS agar tidak error saat jQuery belum siap (initial load)
    // dan flag window agar listener tidak dobel saat SPA direload.
    if (!window.filterDashboardInitialized) {
        document.addEventListener('click', function(e) {
            if (e.target && e.target.closest('#btn_filter_dashboard')) {
                doFilterDashboard();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.target && e.target.id === 'filter_keyword' && e.key === 'Enter') {
                doFilterDashboard();
            }
        });
        window.filterDashboardInitialized = true;
    }

    var requestModal = null;
    function showRequestDeleteModal(id, is_app, name) {
        document.getElementById('formRequestDelete').action = '<?= base_url('dashboard/request_delete') ?>/' + id + '/' + is_app;
        document.getElementById('req_app_name').innerText = name;
        if(!requestModal) {
            let modalEl = document.getElementById('modalRequestDelete');
            document.body.appendChild(modalEl);
            requestModal = new bootstrap.Modal(modalEl);
        }
        requestModal.show();
    }

    var reviewModal = null;
    function showReviewModal(id, is_app, name, reason) {
        document.getElementById('rev_app_name').innerText = name;
        document.getElementById('rev_app_reason').innerText = `"` + reason + `"`;
        document.getElementById('btnApproveDelete').href = '<?= base_url('dashboard/approve_delete') ?>/' + id + '/' + is_app;
        document.getElementById('btnRejectDelete').href = '<?= base_url('dashboard/reject_delete') ?>/' + id + '/' + is_app;
        if(!reviewModal) {
            let modalEl = document.getElementById('modalReviewDelete');
            document.body.appendChild(modalEl);
            reviewModal = new bootstrap.Modal(modalEl);
        }
        reviewModal.show();
    }
</script>
<?= $this->endSection() ?>
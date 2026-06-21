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
                <span class="badge bg-light-primary text-primary fs-3 fw-bold px-3 py-2 rounded-pill border border-primary border-opacity-10"><i class="ti ti-building-monitor me-1"></i> SIMPA Enterprise</span>
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
    <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-2 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <h5 class="fw-bold mb-1 text-dark"><i class="ti ti-list-check text-primary me-2"></i>Database Inventaris & Aplikasi</h5>
            <p class="text-muted fs-3 mb-0">Manajemen komprehensif aplikasi IT dan aplikasi terpusat.</p>
        </div>
        <div class="d-flex flex-wrap gap-2 align-items-center mt-3 mt-md-0 ms-md-auto">
            <form action="<?= base_url('dashboard') ?>" method="GET" class="d-flex gap-2">
                <div class="input-group input-group-sm rounded-3 shadow-none border" style="width: 220px; max-width: 100%;">
                    <span class="input-group-text bg-white border-0 text-muted"><i class="ti ti-search fs-5"></i></span>
                    <input type="text" name="keyword" class="form-control border-0 ps-0 shadow-none" placeholder="Cari aplikasi..." value="<?= $keyword ?? '' ?>">
                </div>
                <button type="submit" class="btn btn-sm btn-primary px-3 rounded-3 fw-medium">Filter</button>
            </form>
            <div class="vr my-2 mx-1 d-none d-md-block"></div>
            <a href="<?= base_url('dashboard/export') . '?' . http_build_query(['keyword' => $keyword ?? '', 'kategori' => $kategori ?? '', 'status' => $status ?? '']) ?>" class="btn btn-sm btn-outline-danger shadow-sm rounded-3 d-flex justify-content-center align-items-center fw-medium px-3 text-nowrap" target="_blank">
                <i class="ti ti-file-type-pdf fs-5 me-1"></i> Cetak PDF
            </a>
            <?php if (session()->get('role') == 'Admin' || session()->get('role') == 'PM') : ?>
            <a href="<?= base_url('dashboard/add') ?>" class="btn btn-sm btn-dark px-3 rounded-3 fw-medium d-flex justify-content-center align-items-center text-nowrap"><i class="ti ti-plus me-1"></i>Tambah Aplikasi</a>
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
                                <?php if (!empty($a['is_app'])) : ?>
                                    <a href="<?= base_url('notula?app_id=' . ($a['id'] ?? '') . '&quick=1') ?>" class="btn btn-sm btn-light-success text-success hover-success px-2" data-bs-toggle="tooltip" title="Quick MoM Build"><i class="ti ti-bolt fs-4"></i></a>
                                    <a href="<?= base_url('absensi?app_id=' . ($a['id'] ?? '')) ?>" class="btn btn-sm btn-light-info text-info hover-info px-2" data-bs-toggle="tooltip" title="Buat Daftar Hadir"><i class="ti ti-users fs-4"></i></a>
                                <?php endif; ?>
                                <?php if (session()->get('role') == 'Admin' || session()->get('role') == 'PM') : ?>
                                    <a href="<?= !empty($a['is_app']) ? base_url('admin/app-master') : base_url('dashboard/edit/' . ($a['id'] ?? '')) ?>" class="btn btn-sm btn-light text-primary hover-primary px-2" data-bs-toggle="tooltip" title="Edit Data"><i class="ti ti-pencil fs-4"></i></a>
                                    <a href="<?= !empty($a['is_app']) ? base_url('admin/app-master/delete/' . ($a['id'] ?? '')) : base_url('dashboard/delete/' . ($a['id'] ?? '')) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?')" class="btn btn-sm btn-light text-danger hover-danger px-2" data-bs-toggle="tooltip" title="Hapus Data"><i class="ti ti-trash fs-4"></i></a>
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
document.addEventListener("DOMContentLoaded", function() {
    // Enable Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // 1. Chart 1: Distribusi Aplikasi
    const ctx1 = document.getElementById('categoryChart').getContext('2d');
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
    const ctx2 = document.getElementById('progressChart').getContext('2d');
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
});
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
<?= $this->endSection() ?>
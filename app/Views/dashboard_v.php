<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row mb-4 mt-3">
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <!-- Decorative circle -->
            <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle" style="width: 300px; height: 300px; transform: translate(25%, -25%);"></div>
            <div class="position-absolute bottom-0 start-0 bg-primary opacity-20 rounded-circle" style="width: 200px; height: 200px; transform: translate(-30%, 30%); blur: 40px;"></div>
            
            <div class="card-body p-4 p-xl-5 position-relative z-1 d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-white bg-opacity-10 text-white mb-2 fs-2 fw-medium px-3 py-2 rounded-pill border border-white border-opacity-10"><i class="ti ti-building-monitor me-1"></i> SIMPA Enterprise</span>
                    <h2 class="fw-bold text-white mb-2">Executive Monitoring Dashboard</h2>
                    <p class="mb-0 fs-4 text-white-50" style="max-width: 600px;">
                        Selamat datang, <span class="text-white fw-semibold"><?= session()->get('nama_lengkap') ?></span>. 
                        Tinjau ringkasan performa aset fisik dan progres aplikasi digital perusahaan secara real-time.
                    </p>
                </div>
                <div class="d-none d-lg-block">
                    <img src="<?= base_url('assets/images/backgrounds/rocket.png') ?>" alt="Dashboard Hero" class="img-fluid" style="max-height: 140px; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.2)); opacity: 0.9;" onerror="this.style.display='none';">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Stats Cards -->
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 hover-elevate">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="text-muted mb-1 fs-3 fw-semibold text-uppercase tracking-wider">Total Aset</p>
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
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 hover-elevate">
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
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 hover-elevate">
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
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 hover-elevate">
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

<!-- Main Inventory Table -->
<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-2 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h5 class="fw-bold mb-1 text-dark"><i class="ti ti-list-check text-primary me-2"></i>Database Inventaris & Aplikasi</h5>
            <p class="text-muted fs-3 mb-0">Manajemen komprehensif aset IT dan aplikasi terpusat.</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <form action="<?= base_url('dashboard') ?>" method="GET" class="d-flex gap-2">
                <div class="input-group input-group-sm rounded-3 shadow-none border">
                    <span class="input-group-text bg-white border-0 text-muted"><i class="ti ti-search fs-5"></i></span>
                    <input type="text" name="keyword" class="form-control border-0 ps-0 shadow-none" placeholder="Cari aset/aplikasi..." value="<?= $keyword ?? '' ?>">
                </div>
                <button type="submit" class="btn btn-sm btn-primary px-3 rounded-3 fw-medium">Filter</button>
            </form>
            <div class="vr my-2 mx-1"></div>
            <a href="<?= base_url('dashboard/export') . '?' . http_build_query(['keyword' => $keyword ?? '', 'kategori' => $kategori ?? '', 'status' => $status ?? '']) ?>" class="btn btn-sm btn-outline-danger shadow-sm rounded-3 d-flex align-items-center fw-medium px-3 text-nowrap" target="_blank">
                <i class="ti ti-file-type-pdf fs-5 me-1"></i> Cetak PDF
            </a>
            <?php if (session()->get('role') == 'Admin') : ?>
            <a href="<?= base_url('dashboard/add') ?>" class="btn btn-sm btn-dark px-3 rounded-3 fw-medium text-nowrap"><i class="ti ti-plus me-1"></i>Tambah Aset</a>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="table-light text-muted fs-3 text-uppercase fw-semibold tracking-wider">
                    <tr>
                        <th class="ps-4 py-3 border-bottom-0">Aplikasi / Aset Fisik</th>
                        <th class="py-3 border-bottom-0 text-center">Kategori</th>
                        <th class="py-3 border-bottom-0">Penanggung Jawab (PIC)</th>
                        <th class="text-center py-3 border-bottom-0">Status Sistem</th>
                        <?php if (session()->get('role') == 'Admin') : ?>
                        <th class="text-end px-4 py-3 border-bottom-0">Tindakan</th>
                        <?php endif; ?>
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
                                    <h6 class="fw-bold mb-0 text-dark"><?= esc($a['nama_aset']) ?></h6>
                                    <small class="text-muted d-block mt-1">ID Ref: #<?= sprintf('%04d', $a['id']) ?></small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark fw-medium border px-2 py-1 rounded-pill shadow-none fst-normal"><?= esc($a['kategori']) ?></span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-sm d-flex align-items-center justify-content-center rounded-circle bg-light-info text-info border border-info border-opacity-10 fw-bold" style="width: 32px; height: 32px;">
                                    <?= substr(strtoupper(esc($a['pic'])), 0, 1) ?>
                                </div>
                                <span class="fs-3 fw-medium text-dark"><?= esc($a['pic']) ?></span>
                            </div>
                        </td>
                        <td class="text-center">
                            <?php if ($a['status'] == 'Aktif') : ?>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-success rounded-circle" style="width:6px;height:6px;"></span> Online</span>
                            <?php else : ?>
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-warning rounded-circle" style="width:6px;height:6px;"></span> Maintenance</span>
                            <?php endif; ?>
                        </td>
                        <?php if (session()->get('role') == 'Admin') : ?>
                        <td class="text-end px-4">
                            <div class="d-flex gap-1 justify-content-end">
                                <a href="<?= base_url('dashboard/edit/' . $a['id']) ?>" class="btn btn-sm btn-light text-primary hover-primary px-2" data-bs-toggle="tooltip" title="Edit Data"><i class="ti ti-pencil fs-4"></i></a>
                                <a href="<?= base_url('dashboard/delete/' . $a['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus aset ini secara permanen?')" class="btn btn-sm btn-light text-danger hover-danger px-2" data-bs-toggle="tooltip" title="Hapus Data"><i class="ti ti-trash fs-4"></i></a>
                            </div>
                        </td>
                        <?php endif; ?>
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

<div class="row g-4 mt-1">
    <!-- Chart Kategori -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="ti ti-chart-bar text-primary me-2"></i>Distribusi Aset Per Kategori</h5>
            </div>
            <div class="card-body p-4 pt-3">
                <div style="height: 280px; position: relative;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Chart Progress -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="ti ti-target text-success me-2"></i>Realisasi Project Utama</h5>
            </div>
            <div class="card-body p-4 pt-3 d-flex flex-column justify-content-center">
                <div style="height: 240px; position: relative;">
                    <canvas id="progressChart"></canvas>
                </div>
                <!-- Mini legends for progress chart replacing default Chart.js legend for better corporat UI -->
                <div class="mt-4 pt-2 border-top d-flex flex-wrap justify-content-center gap-3 fs-3">
                    <?php $colors = ['#5d87ff', '#13deb9', '#ffae1f', '#fa896b', '#3dd1ff']; ?>
                    <?php foreach ($proj_labels as $index => $label): ?>
                    <div class="d-flex align-items-center">
                        <span class="rounded-circle me-1" style="width: 10px; height: 10px; background-color: <?= $colors[$index % count($colors)] ?>;"></span>
                        <span class="text-muted fw-medium text-truncate" style="max-width: 80px;" title="<?= esc($label) ?>"><?= esc($label) ?> (<?= $proj_percents[$index] ?>%)</span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Enable Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // 1. Chart Kategori
    const ctx1 = document.getElementById('categoryChart').getContext('2d');
    
    // Create a gradient for the bar chart
    const gradientBar = ctx1.createLinearGradient(0, 0, 0, 400);
    gradientBar.addColorStop(0, 'rgba(93, 135, 255, 0.85)');
    gradientBar.addColorStop(1, 'rgba(93, 135, 255, 0.2)');

    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: <?= json_encode($cat_labels) ?>,
            datasets: [{
                label: 'Jumlah Aset',
                data: <?= json_encode($cat_counts) ?>,
                backgroundColor: gradientBar,
                borderColor: '#5d87ff',
                borderWidth: 1,
                borderRadius: 4,
                barThickness: 30,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 13, family: "'Plus Jakarta Sans', sans-serif" },
                    bodyFont: { size: 14, family: "'Plus Jakarta Sans', sans-serif", weight: 'bold' },
                    displayColors: false,
                    cornerRadius: 8,
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { borderDash: [4, 4], color: '#e5eaef', drawBorder: false },
                    ticks: { font: { family: "'Plus Jakarta Sans', sans-serif" }, color: '#7c8fac' }
                },
                x: { 
                    grid: { display: false },
                    ticks: { font: { family: "'Plus Jakarta Sans', sans-serif" }, color: '#7c8fac' }
                }
            }
        }
    });

    // 2. Chart Progress
    const ctx2 = document.getElementById('progressChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($proj_labels) ?>,
            datasets: [{
                data: <?= json_encode($proj_percents) ?>,
                backgroundColor: <?= json_encode($colors) ?>,
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 4,
                cutout: '75%',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return ' Progress: ' + context.raw + '%';
                        }
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
    .hover-elevate { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-elevate:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important; }
    .hover-primary:hover { background-color: #5d87ff !important; color: white !important; }
    .hover-danger:hover { background-color: #fa896b !important; color: white !important; }
    .avatar-sm { font-size: 14px; }
    .bg-light-info { background-color: #e8f7ff !important; }
    .text-info { color: #13deb9 !important; } /* Reused modernzie colors */
    table > thead > tr > th { text-transform: uppercase; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px; }
</style>
<?= $this->endSection() ?>
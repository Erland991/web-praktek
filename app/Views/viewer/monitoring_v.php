<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Custom CSS for Premium Look -->
<style>
/* Hero Section */
.hero-gradient {
    background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
    position: relative;
    overflow: hidden;
    color: white;
    border-radius: 1.25rem;
}
.hero-gradient::before {
    content: '';
    position: absolute;
    top: -50%; right: -20%;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
    border-radius: 50%;
}
.hero-gradient::after {
    content: '';
    position: absolute;
    bottom: -30%; left: -10%;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
}

/* Glassmorphism Cards */
.glass-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.4);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
    border-radius: 1.25rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.glass-card:hover {
    box-shadow: 0 15px 40px -5px rgba(0, 0, 0, 0.1);
    transform: translateY(-4px);
}

/* Stat Cards Glow */
.stat-card {
    border-radius: 1.25rem;
    overflow: hidden;
    position: relative;
    border: none;
    box-shadow: 0 10px 30px -10px rgba(0,0,0,0.15);
}
.stat-card::before {
    content: "";
    position: absolute;
    width: 150px;
    height: 150px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    top: -30px;
    right: -30px;
}
.stat-card .icon-watermark {
    position: absolute;
    bottom: -15px;
    right: -10px;
    font-size: 6rem;
    opacity: 0.15;
    transform: rotate(-15deg);
}

/* Progress Bar Tweaks */
.progress-slim {
    height: 8px;
    border-radius: 10px;
    background: #e2e8f0;
    overflow: hidden;
}
.progress-slim .progress-bar {
    border-radius: 10px;
    position: relative;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}
.progress-slim .progress-bar::after {
    content: '';
    position: absolute;
    top: 0; right: 0; bottom: 0;
    width: 15px;
    background: linear-gradient(to right, transparent, rgba(255,255,255,0.8));
    border-radius: 10px;
}

/* Form Select Styling */
.custom-select-wrapper select {
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    box-shadow: inset 0 2px 4px 0 rgba(0,0,0,0.02);
    font-size: 0.95rem;
}
.custom-select-wrapper select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
}

/* Hover effects */
a.hover-white:hover {
    background-color: #fff !important;
    border-color: #d1d5db !important;
}
</style>

<div class="container-fluid px-0">
    <!-- Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="hero-gradient p-5 shadow-sm d-flex justify-content-between align-items-center">
                <div class="position-relative z-1">
                    <span class="badge bg-white text-primary fw-bold px-3 py-2 rounded-pill mb-3 shadow-sm" style="font-size: 0.8rem; letter-spacing: 1px;">
                        <i class="ti ti-chart-pie me-1"></i> SIMPA ENTERPRISE
                    </span>
                    <h2 class="fw-bolder mb-2 text-white display-6" style="letter-spacing: -0.5px;">Executive Monitoring</h2>
                    <p class="mb-0 fs-5 text-white-50 opacity-100" style="max-width: 650px;">
                        Oversight terpusat memantau performa dan pengerjaan aplikasi seluruh divisi dengan visualisasi interaktif secara real-time.
                    </p>
                </div>
                <div class="d-none d-md-block z-1 opacity-75">
                    <i class="ti ti-dashboard text-white" style="font-size: 7.5rem; filter: drop-shadow(0px 10px 15px rgba(0,0,0,0.2));"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats & Filters -->
    <div class="row mb-5 g-4">
        <!-- Filter Card -->
        <div class="col-lg-7">
            <div class="card glass-card h-100 border-0">
                <div class="card-body p-4 d-flex flex-column justify-content-center">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                            <div class="bg-light-primary text-primary rounded d-flex align-items-center justify-content-center p-2 me-3" style="width: 40px; height: 40px;">
                                <i class="ti ti-filter fs-6"></i>
                            </div>
                            Oversight Filter
                        </h5>
                    </div>
                    <form action="" method="GET" class="row g-3 custom-select-wrapper mt-auto">
                        <div class="col-md-8">
                            <select name="apps[]" class="form-select w-100" multiple data-placeholder="Pilih aplikasi..." style="min-height: 120px;">
                                <?php foreach($all_apps as $aa): ?>
                                    <option value="<?= $aa['id'] ?>" <?= in_array($aa['id'], $selected) ? 'selected' : '' ?>>
                                        <?= $aa['nama_app'] ?> (PIC: <?= $aa['pic_name'] ?? $aa['pic_id'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted d-block mt-2">
                                <i class="ti ti-hand-click me-1 text-primary"></i>
                                Tahan <b>Ctrl</b> atau <b>Cmd</b> untuk multi-pilihan
                            </small>
                        </div>
                        <div class="col-md-4 d-flex flex-column gap-2 justify-content-start pt-1">
                            <button type="submit" class="btn btn-primary rounded-3 fw-bold shadow-sm py-2 d-flex align-items-center justify-content-center">
                                <i class="ti ti-search me-2"></i> Terapkan
                            </button>
                            <a href="<?= base_url('monitoring') ?>" class="btn btn-light rounded-3 fw-bold border py-2 text-dark hover-white text-center text-decoration-none d-flex align-items-center justify-content-center">
                                <i class="ti ti-refresh me-2"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-lg-5">
            <div class="row g-4 h-100">
                <div class="col-12 h-50">
                    <div class="card stat-card text-white h-100" style="background: linear-gradient(135deg, #1e40af, #3b82f6) !important;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between z-1 h-100">
                            <div>
                                <p class="text-white-50 fw-semibold text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">Tot. Applications</p>
                                <h2 class="fw-bolder mb-0 text-white display-5"><?= count($apps) ?></h2>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center shadow-sm backdrop-blur" style="width: 60px; height: 60px;">
                                <i class="ti ti-apps fs-4 text-white"></i>
                            </div>
                        </div>
                        <i class="ti ti-apps icon-watermark text-white"></i>
                    </div>
                </div>
                <div class="col-12 h-50">
                    <div class="card stat-card text-white h-100" style="background: linear-gradient(135deg, #065f46, #10b981) !important;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between z-1 h-100">
                            <div>
                                <p class="text-white-50 fw-semibold text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">Avg Realization</p>
                                <?php 
                                    $avg = count($apps) > 0 ? array_sum(array_column($apps, 'real_percent')) / count($apps) : 0;
                                ?>
                                <h2 class="fw-bolder mb-0 text-white display-5"><?= round($avg, 1) ?>%</h2>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center shadow-sm backdrop-blur" style="width: 60px; height: 60px;">
                                <i class="ti ti-percentage fs-4 text-white"></i>
                            </div>
                        </div>
                        <i class="ti ti-chart-bar icon-watermark text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card glass-card border-0">
                <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bolder text-dark mb-1 d-flex align-items-center">
                        <i class="ti ti-chart-bar text-primary me-2 fs-5"></i> Benchmarking Capaian Proyek
                    </h5>
                    <p class="text-muted fs-3 mb-0 ms-4 ps-2">Visualisasi perbandingan persentase realisasi antar proyek aktif.</p>
                </div>
                <div class="card-body p-4">
                    <div style="height: 380px;">
                        <canvas id="executiveChart" width="100%" height="100%"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Cards Grid -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold text-dark mb-0 ms-1">Project Detailed View</h4>
        <div class="badge bg-light-primary text-primary px-3 py-2 rounded-pill fw-semibold border border-primary-subtle shadow-sm">
            Menampilkan <?= count($apps) ?> Proyek
        </div>
    </div>

    <div class="row g-4">
        <?php foreach($apps as $app): ?>
        <div class="col-md-6 col-xl-4 py-1">
            <div class="card glass-card h-100 p-0 overflow-hidden">
                <!-- Decorative Top Line -->
                <div class="bg-<?= $app['real_percent'] == 100 ? 'success' : 'primary' ?>" style="height: 5px; width: 100%;"></div>
                
                <div class="p-4 d-flex flex-column h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-light text-secondary border fw-semibold rounded-pill px-3 py-1 fs-2">
                            <?= $app['nama_divisi'] ?>
                        </span>
                        
                        <?php 
                        $statusColor = 'primary';
                        if(strtolower($app['status']) == 'completed' || strtolower($app['status']) == 'selesai') $statusColor = 'success';
                        elseif(strtolower($app['status']) == 'pending') $statusColor = 'warning';
                        elseif(strtolower($app['status']) == 'in progress' || strtolower($app['status']) == 'ongoing') $statusColor = 'info';
                        ?>
                        <span class="badge bg-light-<?= $statusColor ?> text-<?= $statusColor ?> rounded-pill px-3 py-1 fs-2 fw-semibold d-flex align-items-center border border-<?= $statusColor ?>-subtle">
                            <span class="rounded-circle bg-<?= $statusColor ?> me-2" style="width:6px; height:6px; box-shadow: 0 0 5px var(--bs-<?= $statusColor ?>);"></span>
                            <?= $app['status'] ?>
                        </span>
                    </div>

                    <h5 class="fw-bolder text-dark mb-2 lh-base" style="min-height: 48px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        <?= $app['nama_app'] ?>
                    </h5>
                    
                    <div class="d-flex align-items-center text-muted mb-4">
                        <i class="ti ti-calendar-event me-2 text-primary fs-4"></i>
                        <span class="fs-3">Target: <strong class="text-dark fw-semibold"><?= $app['tgl_target'] ? date('d M Y', strtotime($app['tgl_target'])) : 'N/A' ?></strong></span>
                    </div>

                    <!-- Progress Section -->
                    <div class="mt-auto bg-light bg-opacity-50 rounded-4 p-3 mb-4 border border-light shadow-sm">
                        <div class="d-flex justify-content-between align-items-end mb-2">
                            <span class="fs-2 fw-bold text-muted text-uppercase" style="letter-spacing: 0.5px;">Progress Realisasi</span>
                            <span class="fs-4 fw-bolder text-<?= $app['real_percent'] == 100 ? 'success' : 'primary' ?>"><?= $app['real_percent'] ?>%</span>
                        </div>
                        <div class="progress progress-slim">
                            <?php $barColor = $app['real_percent'] == 100 ? '#10b981' : '#3b82f6'; ?>
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" 
                                 style="width: <?= $app['real_percent'] ?>%; background-color: <?= $barColor ?>; border-color: <?= $barColor ?>;">
                            </div>
                        </div>
                    </div>

                    <!-- Footer Info -->
                    <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-auto">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-light-primary text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 38px; height: 38px; font-size: 0.9rem;">
                                <?php 
                                    $pic = !empty($app['pic_name']) ? $app['pic_name'] : 'N A';
                                    $words = explode(' ', trim($pic));
                                    $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                    echo $initials;
                                ?>
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <small class="text-muted fs-1 fw-medium" style="line-height: 1;">Project Lead</small>
                                <small class="fw-bold text-dark fs-3" style="line-height: 1.2; margin-top: 2px; max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= !empty($app['pic_name']) ? $app['pic_name'] : 'Not Assigned' ?></small>
                            </div>
                        </div>
                        <div class="text-end d-flex flex-column justify-content-center">
                            <small class="text-muted fs-1 fw-medium" style="line-height: 1;">Last Update</small>
                            <small class="fw-bold text-dark fs-2 d-flex align-items-center justify-content-end mt-1" style="line-height: 1.2;">
                                <i class="ti ti-clock me-1 text-muted"></i> 
                                <?= ($app['last_update'] != '-') ? date('d/m  H:i', strtotime($app['last_update'])) : '-' ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        
        <?php if(count($apps) == 0): ?>
        <div class="col-12 py-5 text-center mt-3">
            <div class="glass-card p-5 d-flex flex-column align-items-center justify-content-center" style="min-height: 300px;">
                <div class="bg-light-primary text-primary rounded-circle p-4 mb-3">
                    <i class="ti ti-folder-off" style="font-size: 3rem;"></i>
                </div>
                <h4 class="fw-bold text-dark">Tidak ada data ditemukan</h4>
                <p class="text-muted">Cobalah untuk mengubah parameter filter pencarian Anda.</p>
                <a href="<?= base_url('monitoring') ?>" class="btn btn-primary rounded-pill mt-2 fw-semibold px-4">Refresh Halaman</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxExec = document.getElementById('executiveChart');
    if (!ctxExec) return;
    
    const context = ctxExec.getContext('2d');
    const labelsExec = <?= json_encode(array_column($apps, 'nama_app')) ?>;
    const dataExec = <?= json_encode(array_column($apps, 'real_percent')) ?>;

    // Create a smooth gradient for the chart bars
    let gradient = context.createLinearGradient(0, 0, ctxExec.parentElement.offsetWidth, 0);
    gradient.addColorStop(0, 'rgba(56, 189, 248, 0.85)'); // Soft Blue
    gradient.addColorStop(1, 'rgba(59, 130, 246, 0.95)'); // Solid Blue
    
    // Gradient for 100% completion (green)
    let successGradient = context.createLinearGradient(0, 0, ctxExec.parentElement.offsetWidth, 0);
    successGradient.addColorStop(0, 'rgba(52, 211, 153, 0.85)'); // Soft Green
    successGradient.addColorStop(1, 'rgba(16, 185, 129, 0.95)'); // Solid Green
    
    // Map colors based on value
    const backgroundColors = dataExec.map(val => val == 100 ? successGradient : gradient);

    new Chart(context, {
        type: 'bar',
        data: {
            labels: labelsExec,
            datasets: [{
                label: 'Realisasi Capaian',
                data: dataExec,
                backgroundColor: backgroundColors,
                borderRadius: 6,
                borderSkipped: false,
                barThickness: 24,
                hoverBackgroundColor: backgroundColors // Keep same gradient on hover but browser naturally brightens it a little
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 20,
                    top: 10,
                    bottom: 10
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { size: 13, family: "'Inter', sans-serif" },
                    bodyFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return ` ${context.parsed.x}% Selesai`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(0,0,0,0.04)',
                        drawBorder: false
                    },
                    ticks: {
                        font: { family: "'Inter', sans-serif", size: 12 },
                        color: '#64748b',
                        callback: function(value) { return value + "%" }
                    }
                },
                y: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: { family: "'Inter', sans-serif", weight: '500', size: 12 },
                        color: '#334155',
                        crossAlign: 'far'
                    }
                }
            },
            animation: {
                y: {
                    duration: 1500,
                    easing: 'easeOutQuart'
                },
                x: {
                    duration: 1500,
                    easing: 'easeOutQuart'
                }
            }
        }
    });
});
</script>

<?= $this->endSection() ?>

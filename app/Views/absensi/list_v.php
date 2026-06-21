<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <!-- Header Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4 bg-white d-flex justify-content-between align-items-center border-start border-5 border-primary">
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-1 rounded-pill fw-bold">
                    <i class="ti ti-list me-1"></i> Data
                </span>
                <h3 class="fw-bold text-dark mb-1">Daftar Absensi Kehadiran</h3>
                <p class="text-muted mb-0">Manajemen dokumen daftar hadir</p>
            </div>
            <div class="text-end">
                <a href="<?= base_url('absensi') ?>" class="btn btn-primary fw-bold rounded-pill px-4 py-2 shadow-sm">
                    <i class="ti ti-plus me-1"></i> Buat Absensi Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted fs-3 text-uppercase fw-semibold tracking-wider">
                        <tr>
                            <th class="ps-4 py-3 border-bottom-0">Aplikasi / Acara</th>
                            <th class="py-3 border-bottom-0">Pelaksanaan</th>
                            <th class="py-3 border-bottom-0 text-center">Jml Peserta</th>
                            <th class="py-3 border-bottom-0">Waktu Dibuat</th>
                            <th class="px-4 py-3 border-bottom-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($absensi)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted italic">Belum ada dokumen absensi kehadiran.</td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach($absensi as $a): ?>
                        <tr>
                            <td class="border-bottom-0 ps-4">
                                <h6 class="fw-bold mb-1 text-dark text-wrap" style="word-break: break-word; max-width: 250px;"><?= esc($a['acara']) ?></h6>
                                <small class="text-primary fw-bold d-block text-wrap" style="word-break: break-word; max-width: 250px;"><i class="ti ti-device-laptop me-1"></i> <?= esc($a['nama_app'] ?? 'Non-Aplikasi') ?></small>
                            </td>
                            <td class="border-bottom-0">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="ti ti-calendar text-muted me-2"></i>
                                    <span class="text-dark"><?= date('d M Y', strtotime($a['tanggal'])) ?></span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-map-pin text-muted me-2"></i>
                                    <span class="text-muted fs-2 text-wrap" style="word-break: break-word; max-width: 200px;"><?= esc($a['tempat']) ?> (<?= esc($a['waktu']) ?>)</span>
                                </div>
                            </td>
                            <td class="border-bottom-0 text-center">
                                <span class="badge bg-light-info text-info border border-info border-opacity-25 rounded-pill px-3 py-1 fw-bold fs-3">
                                    <i class="ti ti-users me-1"></i> <?= count($a['peserta'] ?? []) ?>
                                </span>
                            </td>
                            <td class="border-bottom-0">
                                <span class="text-muted fs-2 font-monospace"><i class="ti ti-clock me-1"></i> <?= date('d M Y H:i', strtotime($a['created_at'])) ?></span>
                            </td>
                            <td class="border-bottom-0 text-center px-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?= base_url('absensi/edit/'.$a['id']) ?>" class="btn btn-sm btn-light-primary text-primary hover-elevate d-inline-flex align-items-center justify-content-center rounded-circle" style="width:36px; height:36px;" data-bs-toggle="tooltip" title="Edit">
                                        <i class="ti ti-pencil fs-4"></i>
                                    </a>
                                    <a href="<?= base_url('absensi/pdf/'.$a['id']) ?>" class="btn btn-sm btn-light-success text-success hover-elevate d-inline-flex align-items-center justify-content-center rounded-circle" style="width:36px; height:36px;" data-bs-toggle="tooltip" title="Download PDF" target="_blank">
                                        <i class="ti ti-file-download fs-4"></i>
                                    </a>
                                    <a href="<?= base_url('absensi/delete/'.$a['id']) ?>" class="btn btn-sm btn-light-danger text-danger hover-elevate d-inline-flex align-items-center justify-content-center rounded-circle" style="width:36px; height:36px;" data-bs-toggle="tooltip" title="Hapus" onclick="return confirm('Yakin ingin menghapus dokumen absensi ini?')">
                                        <i class="ti ti-trash fs-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

<?= $this->endSection() ?>

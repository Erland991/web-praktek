<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-5 mt-2">
    <div class="col-12">
        <div class="hero-card shadow-lg">
            <div class="position-relative z-1 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-2 fs-7 fw-bold">Log Aktivitas Sistem</h4>
                    <p class="mb-0 fs-4 text-white-50">Transparansi data: Pantau setiap perubahan yang terjadi dalam sistem SIMPA.</p>
                </div>
                <a href="<?= base_url('admin/logs/clear') ?>" class="btn btn-light text-danger fw-bold shadow-sm" onclick="return confirm('Yakin ingin MENGHAPUS SEMUA riwayat log? Ini tidak bisa dibatalkan!')">
                    <i class="ti ti-trash me-2"></i>Bersihkan Semua
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card w-100 shadow-sm border-0">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle table-hover">
                <thead class="text-dark fs-4 bg-light">
                    <tr>
                        <th class="border-bottom-0">Waktu</th>
                        <th class="border-bottom-0">User</th>
                        <th class="border-bottom-0">Aksi</th>
                        <th class="border-bottom-0">Keterangan</th>
                        <th class="border-bottom-0">IP Address</th>
                        <th class="border-bottom-0 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($logs)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted italic">Belum ada riwayat aktivitas yang tercatat.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($logs as $log): ?>
                    <tr>
                        <td class="border-bottom-0">
                            <span class="fw-semibold text-dark"><?= date('d/m/Y H:i', strtotime($log['created_at'])) ?></span>
                        </td>
                        <td class="border-bottom-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-light-primary p-2 rounded-circle me-3">
                                    <i class="ti ti-user text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0"><?= $log['username'] ?></h6>
                                    <span class="fs-2 text-muted">ID: <?= $log['user_id'] ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="border-bottom-0">
                            <span class="badge bg-light-primary text-primary fw-bold text-uppercase"><?= $log['aksi'] ?></span>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-normal text-muted" style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= $log['keterangan'] ?>">
                                <?= $log['keterangan'] ?>
                            </p>
                        </td>
                        <td class="border-bottom-0">
                            <code class="text-secondary"><?= $log['ip_address'] ?></code>
                        </td>
                        <td class="border-bottom-0 text-center">
                            <a href="<?= base_url('admin/logs/delete/' . $log['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus log ini?')" title="Hapus Log">
                                <i class="ti ti-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
        <div class="card-body p-4 text-white">
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 rounded-3 text-white d-flex align-items-center justify-content-center" style="background: rgba(255, 255, 255, 0.15); width: 52px; height: 52px;">
                    <i class="ti ti-notes fs-7"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-white">Daftar Memo / Notula</h2>
                    <p class="mb-0 text-white-50">Proyek: <?= $app['nama_app'] ?></p>
                </div>
                <div class="ms-auto">
                    <a href="<?= base_url('notula?app_id='.$app['id']) ?>" class="btn btn-light text-primary fw-bold rounded-pill px-4 shadow-sm hover-elevate">
                        <i class="ti ti-plus me-1"></i> Buat Memo Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase fw-bold">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th>Agenda / Topik</th>
                            <th>Tanggal</th>
                            <th>Status Approval</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($memos)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted fst-italic">Belum ada memo untuk proyek ini.</td>
                            </tr>
                        <?php endif; ?>
                        <?php $no=1; foreach($memos as $m): ?>
                        <tr>
                            <td class="ps-4 fw-bold"><?= $no++ ?></td>
                            <td>
                                <span class="fw-bold d-block text-dark"><?= $m['agenda'] ?></span>
                                <small class="text-muted"><i class="ti ti-map-pin me-1"></i> <?= $m['tempat'] ?></small>
                            </td>
                            <td><?= date('d M Y', strtotime($m['tanggal'])) ?></td>
                            <td>
                                <?php if($m['is_final']): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill">
                                        <i class="ti ti-circle-check me-1"></i> Final Approved
                                    </span>
                                <?php else: ?>
                                    <div class="d-flex gap-1">
                                        <span class="badge <?= $m['is_approved1'] ? 'bg-success' : 'bg-light text-muted' ?> px-2 py-1 rounded-pill fs-1">App 1</span>
                                        <span class="badge <?= $m['is_approved2'] ? 'bg-success' : 'bg-light text-muted' ?> px-2 py-1 rounded-pill fs-1">App 2</span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="text-center px-4">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="<?= base_url('notula/edit/'.$m['id']) ?>" class="btn btn-sm btn-light-primary text-primary border border-primary border-opacity-25 hover-elevate d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px;" data-bs-toggle="tooltip" title="Lihat/Edit">
                                        <i class="ti ti-edit fs-5"></i>
                                    </a>
                                    <a href="<?= base_url('notula/export/'.$m['id']) ?>" class="btn btn-sm btn-light-success text-success border border-success border-opacity-25 hover-elevate d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px;" data-bs-toggle="tooltip" title="Download PDF">
                                        <i class="ti ti-download fs-5"></i>
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
    
    <div class="mt-4">
        <a href="<?= base_url('progress') ?>" class="btn btn-outline-secondary">
            <i class="ti ti-arrow-left me-1"></i> Kembali ke Kelola Progres
        </a>
    </div>
</div>
<?= $this->endSection() ?>

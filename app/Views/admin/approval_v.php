<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4 mt-3">
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm bg-white">
            <div class="card-body p-4 position-relative z-1 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 border-start border-4 border-primary">
                <div>
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-2 fs-2 fw-medium px-3 py-1 rounded-pill"><i class="ti ti-check-circle me-1"></i> SIMPA Task Workflow</span>
                    <h4 class="fw-bold text-dark mb-1">Workflow & Persetujuan Progres</h4>
                    <p class="mb-0 text-muted" style="max-width: 600px;">Review bertahap laporan progres aplikasi dari PIC Proyek sebelum dideploy dan disinkronkan ke sistem pusat.</p>
                </div>
                <div class="d-none d-md-block opacity-50 text-end">
                    <i class="ti ti-git-pull-request text-primary" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('sukses')) : ?>
    <div class="alert alert-success border-0 shadow-sm mb-4 rounded-3 d-flex align-items-center">
        <i class="ti ti-circle-check fs-5 me-2"></i> <?= session()->getFlashdata('sukses') ?>
    </div>
<?php endif; ?>

<!-- Tabs Nav -->
<div class="row mb-4">
    <div class="col-12">
        <ul class="nav nav-pills p-2 bg-light rounded-4 gap-2 border shadow-sm" id="approvalTabs" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 rounded-3 active fw-bold py-3 position-relative d-flex align-items-center justify-content-center gap-2" id="stage1-tab" data-bs-toggle="tab" data-bs-target="#stage1" type="button" role="tab" aria-controls="stage1" aria-selected="true">
                    <i class="ti ti-shield-check fs-5"></i>
                    <span>Tahap 1: Kepala Divisi</span>
                    <span class="badge bg-warning text-dark rounded-circle font-monospace ms-1" style="width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; font-size: 11px;"><?= count($pending_stage1) ?></span>
                </button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 rounded-3 fw-bold py-3 position-relative d-flex align-items-center justify-content-center gap-2" id="stage2-tab" data-bs-toggle="tab" data-bs-target="#stage2" type="button" role="tab" aria-controls="stage2" aria-selected="false">
                    <i class="ti ti-server fs-5"></i>
                    <span>Tahap 2: IT Admin / PMO</span>
                    <span class="badge bg-info text-white rounded-circle font-monospace ms-1" style="width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; font-size: 11px;"><?= count($pending_stage2) ?></span>
                </button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 rounded-3 fw-bold py-3 position-relative d-flex align-items-center justify-content-center gap-2" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false">
                    <i class="ti ti-history fs-5"></i>
                    <span>Riwayat Persetujuan</span>
                    <span class="badge bg-secondary text-white rounded-circle font-monospace ms-1" style="width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; font-size: 11px;"><?= count($history) ?></span>
                </button>
            </li>
        </ul>
    </div>
</div>

<!-- Tabs Content -->
<div class="tab-content" id="approvalTabsContent">
    
    <!-- TAHAP 1: KEPALA DIVISI -->
    <div class="tab-pane fade show active" id="stage1" role="tabpanel" aria-labelledby="stage1-tab">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted fs-3 text-uppercase fw-semibold tracking-wider">
                            <tr>
                                <th class="ps-4 py-3 border-bottom-0">Aplikasi & PIC</th>
                                <th class="py-3 border-bottom-0 text-center">Tahapan & Progres</th>
                                <th class="py-3 border-bottom-0">Keterangan / Lampiran</th>
                                <th class="py-3 border-bottom-0 text-center">Workflow Status</th>
                                <th class="px-4 py-3 border-bottom-0 text-center">Aksi Persetujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($pending_stage1)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted italic">Tidak ada antrean persetujuan Tahap 1 saat ini. Semua data sudah tervalidasi oleh Kepala Divisi.</td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach($pending_stage1 as $p): ?>
                            <tr id="row-<?= $p['id'] ?>">
                                <td class="border-bottom-0 ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light-warning rounded-2 p-2 me-3 text-warning">
                                            <i class="ti ti-device-laptop fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark"><?= $p['nama_app'] ?></h6>
                                            <small class="text-muted d-block mt-1">Diajukan: <strong class="text-primary"><?= $p['pic_name'] ?></strong> (<?= $p['pic_divisi'] ?? 'Divisi' ?>)</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-bottom-0 text-center">
                                    <div class="d-inline-block text-start">
                                        <span class="badge bg-light-primary text-primary border border-primary border-opacity-10 mb-1 fw-bold fs-2 px-2 py-1 rounded"><?= $p['tahapan'] ?? 'Development' ?></span>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress" style="height: 6px; width: 60px;">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $p['persentase'] ?>%"></div>
                                            </div>
                                            <span class="fw-bold fs-3 text-dark"><?= $p['persentase'] ?>%</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-1 fs-2 text-dark italic" style="max-width:260px; white-space: normal;"><?= $p['pesan_update'] ?></p>
                                    <?php if($p['file_lampiran']): ?>
                                        <a href="<?= base_url('uploads/progress/'.$p['file_lampiran']) ?>" class="btn btn-xs btn-outline-info py-0 px-2 rounded-pill fs-1" target="_blank">
                                            <i class="ti ti-file-download me-1"></i> Bukti Lampiran
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td class="border-bottom-0 text-center">
                                    <!-- Visual Stepper -->
                                    <div class="d-inline-flex align-items-center stepper-flow gap-1 p-2 bg-light rounded-pill border">
                                        <span class="badge bg-success rounded-circle p-1" data-bs-toggle="tooltip" title="PIC Mengajukan"><i class="ti ti-check text-white" style="font-size: 8px;"></i></span>
                                        <div class="stepper-line bg-warning" style="width: 15px; height: 2px;"></div>
                                        <span class="badge bg-warning rounded-circle p-1 animate-pulse" data-bs-toggle="tooltip" title="Review Kepala Divisi"><i class="ti ti-user text-white" style="font-size: 8px;"></i></span>
                                        <div class="stepper-line bg-secondary" style="width: 15px; height: 2px;"></div>
                                        <span class="badge bg-secondary rounded-circle p-1" data-bs-toggle="tooltip" title="IT Admin / PMO"><i class="ti ti-lock text-white" style="font-size: 8px;"></i></span>
                                    </div>
                                </td>
                                <td class="border-bottom-0 text-center px-4">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button class="btn btn-sm btn-outline-warning border-2 shadow-sm fw-bold d-flex align-items-center" onclick="showApprovalModal(<?= $p['id'] ?>, 1)">
                                            <i class="ti ti-check me-1 fs-4"></i> Setujui Tahap 1
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger border-2 shadow-sm fw-bold d-flex align-items-center" onclick="showApprovalModal(<?= $p['id'] ?>, 3)">
                                            <i class="ti ti-x me-1 fs-4"></i> Tolak
                                        </button>
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

    <!-- TAHAP 2: IT ADMIN / PMO -->
    <div class="tab-pane fade" id="stage2" role="tabpanel" aria-labelledby="stage2-tab">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted fs-3 text-uppercase fw-semibold tracking-wider">
                            <tr>
                                <th class="ps-4 py-3 border-bottom-0">Aplikasi & PIC</th>
                                <th class="py-3 border-bottom-0 text-center">Tahapan & Progres</th>
                                <th class="py-3 border-bottom-0">Keterangan / Lampiran</th>
                                <th class="py-3 border-bottom-0 text-center">Workflow Status</th>
                                <th class="px-4 py-3 border-bottom-0 text-center">Aksi Persetujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($pending_stage2)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted italic">Tidak ada antrean persetujuan Tahap 2 saat ini. Semua data sudah disinkronkan ke pusat.</td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach($pending_stage2 as $p): ?>
                            <tr id="row-<?= $p['id'] ?>">
                                <td class="border-bottom-0 ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light-info rounded-2 p-2 me-3 text-info">
                                            <i class="ti ti-device-laptop fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark"><?= $p['nama_app'] ?></h6>
                                            <small class="text-muted d-block mt-1">Diajukan: <strong class="text-primary"><?= $p['pic_name'] ?></strong> (<?= $p['pic_divisi'] ?? 'Divisi' ?>)</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-bottom-0 text-center">
                                    <div class="d-inline-block text-start">
                                        <span class="badge bg-light-primary text-primary border border-primary border-opacity-10 mb-1 fw-bold fs-2 px-2 py-1 rounded"><?= $p['tahapan'] ?? 'Development' ?></span>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress" style="height: 6px; width: 60px;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: <?= $p['persentase'] ?>%"></div>
                                            </div>
                                            <span class="fw-bold fs-3 text-dark"><?= $p['persentase'] ?>%</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-1 fs-2 text-dark italic" style="max-width:260px; white-space: normal;"><?= $p['pesan_update'] ?></p>
                                    <?php if($p['file_lampiran']): ?>
                                        <a href="<?= base_url('uploads/progress/'.$p['file_lampiran']) ?>" class="btn btn-xs btn-outline-info py-0 px-2 rounded-pill fs-1" target="_blank">
                                            <i class="ti ti-file-download me-1"></i> Bukti Lampiran
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td class="border-bottom-0 text-center">
                                    <!-- Visual Stepper -->
                                    <div class="d-inline-flex align-items-center stepper-flow gap-1 p-2 bg-light rounded-pill border">
                                        <span class="badge bg-success rounded-circle p-1" data-bs-toggle="tooltip" title="PIC Mengajukan"><i class="ti ti-check text-white" style="font-size: 8px;"></i></span>
                                        <div class="stepper-line bg-success" style="width: 15px; height: 2px;"></div>
                                        <span class="badge bg-success rounded-circle p-1" data-bs-toggle="tooltip" title="Review Kepala Divisi"><i class="ti ti-check text-white" style="font-size: 8px;"></i></span>
                                        <div class="stepper-line bg-info" style="width: 15px; height: 2px;"></div>
                                        <span class="badge bg-info rounded-circle p-1 animate-pulse" data-bs-toggle="tooltip" title="IT Admin / PMO"><i class="ti ti-settings text-white" style="font-size: 8px;"></i></span>
                                    </div>
                                </td>
                                <td class="border-bottom-0 text-center px-4">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button class="btn btn-sm btn-outline-success border-2 shadow-sm fw-bold d-flex align-items-center" onclick="showApprovalModal(<?= $p['id'] ?>, 2)">
                                            <i class="ti ti-check me-1 fs-4"></i> Setujui Final
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger border-2 shadow-sm fw-bold d-flex align-items-center" onclick="showApprovalModal(<?= $p['id'] ?>, 4)">
                                            <i class="ti ti-x me-1 fs-4"></i> Tolak
                                        </button>
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

    <!-- RIWAYAT PERSETUJUAN -->
    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted fs-3 text-uppercase fw-semibold tracking-wider">
                            <tr>
                                <th class="ps-4 py-3 border-bottom-0">Aplikasi & PIC</th>
                                <th class="py-3 border-bottom-0 text-center">Tahapan & Progres</th>
                                <th class="py-3 border-bottom-0">Keterangan / Lampiran</th>
                                <th class="py-3 border-bottom-0 text-center">Status Akhir</th>
                                <th class="px-4 py-3 border-bottom-0">Catatan Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($history)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted italic">Belum ada riwayat persetujuan atau penolakan.</td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach($history as $h): ?>
                            <tr>
                                <td class="border-bottom-0 ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-2 p-2 me-3 text-muted">
                                            <i class="ti ti-device-laptop fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark"><?= $h['nama_app'] ?></h6>
                                            <small class="text-muted d-block mt-1">Oleh: <strong class="text-primary"><?= $h['pic_name'] ?></strong> (<?= $h['pic_divisi'] ?? 'Divisi' ?>)</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-bottom-0 text-center">
                                    <div class="d-inline-block text-start">
                                        <span class="badge bg-light text-dark border mb-1 fw-bold fs-2 px-2 py-1 rounded"><?= $h['tahapan'] ?? 'Development' ?></span>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress" style="height: 6px; width: 60px;">
                                                <div class="progress-bar bg-secondary" role="progressbar" style="width: <?= $h['persentase'] ?>%"></div>
                                            </div>
                                            <span class="fw-bold fs-3 text-dark"><?= $h['persentase'] ?>%</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-1 fs-2 text-dark italic" style="max-width:260px; white-space: normal;"><?= $h['pesan_update'] ?></p>
                                    <?php if($h['file_lampiran']): ?>
                                        <a href="<?= base_url('uploads/progress/'.$h['file_lampiran']) ?>" class="btn btn-xs btn-outline-info py-0 px-2 rounded-pill fs-1" target="_blank">
                                            <i class="ti ti-file-download me-1"></i> Lihat File
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td class="border-bottom-0 text-center">
                                    <?php if($h['is_approved'] == 2): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-success rounded-circle" style="width:6px;height:6px;"></span> Approved (Final)</span>
                                    <?php elseif($h['is_approved'] == 1): ?>
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-info rounded-circle" style="width:6px;height:6px;"></span> Approved Kadiv</span>
                                    <?php elseif($h['is_approved'] == 3): ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-danger rounded-circle" style="width:6px;height:6px;"></span> Rejected Kadiv</span>
                                    <?php elseif($h['is_approved'] == 4): ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-danger rounded-circle" style="width:6px;height:6px;"></span> Rejected Admin</span>
                                    <?php endif; ?>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fs-2 text-dark" style="max-width:250px; white-space: normal;"><?= $h['komentar_admin'] ?: '<span class="text-muted italic">- Tidak ada komentar -</span>' ?></p>
                                    <small class="text-muted d-block mt-1 font-monospace fs-1"><i class="ti ti-clock"></i> <?= date('d M Y H:i', strtotime($h['updated_at'])) ?></small>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Modal Approval Action -->
<div class="modal fade" id="modalApproval" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div id="modal_header_container" class="modal-header text-white p-4">
                <h5 class="modal-title fw-bold" id="approval_title">Konfirmasi Approval</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formApproval" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4 text-dark">
                    <p id="approval_text" class="text-dark mb-3">Apakah Anda yakin ingin melakukan tindakan ini?</p>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Komentar / Catatan Review</label>
                        <textarea name="komentar" class="form-control" rows="3" placeholder="Tambahkan catatan jika perlu..."></textarea>
                    </div>
                </div>
                <div class="modal-footer p-3">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btn_submit_approval" class="btn fw-bold px-4">KIRIM KEPUTUSAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Premium visual styles */
    .nav-pills .nav-link {
        color: #64748b;
        background-color: transparent;
        transition: all 0.25s ease;
    }
    .nav-pills .nav-link.active {
        color: #ffffff;
        background-color: #0f172a;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
    }
    .nav-pills .nav-link:hover:not(.active) {
        background-color: rgba(15, 23, 42, 0.05);
        color: #0f172a;
    }
    .stepper-flow .stepper-line {
        transition: all 0.3s ease;
    }
    .animate-pulse {
        animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse-ring {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: .7; transform: scale(1.15); }
    }
</style>

<script>
    let approvalModal = null;
    function showApprovalModal(id, status) {
        const form = document.getElementById('formApproval');
        const title = document.getElementById('approval_title');
        const text = document.getElementById('approval_text');
        const header = document.getElementById('modal_header_container');
        const btn = document.getElementById('btn_submit_approval');

        form.action = '<?= base_url('admin/approval/action') ?>/' + id + '/' + status;
        
        if (status == 1) {
            title.innerText = 'Setujui Progres (Tahap 1)';
            text.innerText = 'Konfirmasi persetujuan Kepala Divisi. Progres akan dilanjutkan ke Tahap 2 (IT Admin / PMO Pusat).';
            header.className = 'modal-header bg-warning text-white p-4';
            btn.className = 'btn btn-warning text-dark fw-bold px-4';
            btn.innerText = 'SETUJUI TAHAP 1';
        } else if (status == 2) {
            title.innerText = 'Setujui Progres (Final / Tahap 2)';
            text.innerText = 'Konfirmasi persetujuan akhir (IT Admin). Persentase pengerjaan aplikasi di dashboard akan diperbarui secara permanen.';
            header.className = 'modal-header bg-success text-white p-4';
            btn.className = 'btn btn-success fw-bold px-4';
            btn.innerText = 'SETUJUI FINAL';
        } else if (status == 3) {
            title.innerText = 'Tolak Progres (Oleh Kepala Divisi)';
            text.innerText = 'Pengajuan progres akan ditolak pada Tahap 1. Harap berikan alasan penolakan pada kolom komentar.';
            header.className = 'modal-header bg-danger text-white p-4';
            btn.className = 'btn btn-danger fw-bold px-4';
            btn.innerText = 'TOLAK TAHAP 1';
        } else if (status == 4) {
            title.innerText = 'Tolak Progres (Oleh IT Admin)';
            text.innerText = 'Pengajuan progres akan ditolak pada Tahap 2. Harap berikan alasan penolakan pada kolom komentar.';
            header.className = 'modal-header bg-danger text-white p-4';
            btn.className = 'btn btn-danger fw-bold px-4';
            btn.innerText = 'TOLAK LAPORAN';
        }

        if(!approvalModal) approvalModal = new bootstrap.Modal(document.getElementById('modalApproval'));
        approvalModal.show();
    }

    document.getElementById('formApproval').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('btn_submit_approval');
        const originalText = btn.innerText;
        btn.innerHTML = '<i class="ti ti-loader ti-spin"></i> Processing...';
        btn.disabled = true;

        const formData = new FormData(this);
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                approvalModal.hide();
                alert(data.message || 'Proses persetujuan berhasil!');
                window.location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan');
                btn.innerText = originalText;
                btn.disabled = false;
            }
        })
        .catch(err => {
            alert('Terjadi kesalahan jaringan.');
            btn.innerText = originalText;
            btn.disabled = false;
        });
    });

    // Initialize Tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
<?= $this->endSection() ?>

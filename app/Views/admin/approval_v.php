<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4 mt-3">
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle" style="width: 250px; height: 250px; transform: translate(30%, -30%);"></div>
            <div class="card-body p-4 p-xl-5 position-relative z-1 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <span class="badge bg-white bg-opacity-10 text-white mb-2 fs-2 fw-medium px-3 py-2 rounded-pill border border-white border-opacity-10"><i class="ti ti-check-circle me-1"></i> SIMPA Task</span>
                    <h2 class="fw-bold text-white mb-2">Persetujuan Progress (Approval)</h2>
                    <p class="mb-0 fs-4 text-white-50" style="max-width: 600px;">Tinjau dan validasi laporan progress aplikasi yang dikirimkan oleh para PIC Proyek sebelum diperbarui ke sistem pusat.</p>
                </div>
                <div class="d-none d-md-block opacity-50">
                    <i class="ti ti-checklist text-white" style="font-size: 5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('sukses')) : ?>
    <div class="alert alert-success border-0 shadow-sm mb-4"><?= session()->getFlashdata('sukses') ?></div>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="table-light text-muted fs-3 text-uppercase fw-semibold tracking-wider">
                    <tr>
                        <th class="ps-4 py-3 border-bottom-0">Aplikasi & PIC</th>
                        <th class="py-3 border-bottom-0 text-center">Realisasi</th>
                        <th class="py-3 border-bottom-0">Keterangan User</th>
                        <th class="py-3 border-bottom-0">Lampiran</th>
                        <th class="px-4 py-3 border-bottom-0 text-center">Aksi Persetujuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($pending)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted italic">Tidak ada antrean persetujuan saat ini. Semua data sudah tervalidasi.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($pending as $p): ?>
                    <tr>
                        <td class="border-bottom-0 ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light-primary rounded-2 p-2 me-3 text-primary">
                                    <i class="ti ti-device-laptop fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark"><?= $p['nama_app'] ?></h6>
                                    <small class="text-muted d-block mt-1">Diajukan oleh: <strong class="text-primary"><?= $p['pic_name'] ?></strong></small>
                                </div>
                            </div>
                        </td>
                        <td class="border-bottom-0 text-center">
                            <span class="badge bg-light-primary text-primary border border-primary border-opacity-25 fw-bold fs-3 px-3 py-1 rounded-pill"><?= $p['persentase'] ?>%</span>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fs-2 text-dark italic" style="max-width:300px; white-space: normal;"><?= $p['pesan_update'] ?></p>
                        </td>
                        <td class="border-bottom-0">
                            <?php if($p['file_lampiran']): ?>
                                <a href="<?= base_url('uploads/progress/'.$p['file_lampiran']) ?>" class="btn btn-sm btn-outline-info" target="_blank">
                                    <i class="ti ti-file-download me-1"></i> Lihat File
                                </a>
                            <?php else: ?>
                                <span class="text-muted fs-2">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="border-bottom-0 text-center px-4">
                            <div class="d-flex gap-2 justify-content-center">
                                <button class="btn btn-sm btn-outline-success border-2 shadow-sm fw-bold d-flex align-items-center" onclick="showApprovalModal(<?= $p['id'] ?>, 1)">
                                    <i class="ti ti-check me-1 fs-4"></i> Terima
                                </button>
                                <button class="btn btn-sm btn-outline-danger border-2 shadow-sm fw-bold d-flex align-items-center" onclick="showApprovalModal(<?= $p['id'] ?>, 2)">
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
                <div class="modal-body p-4">
                    <p id="approval_text" class="text-dark mb-3">Apakah Anda yakin ingin menyetujui progress ini?</p>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Komentar / Catatan Admin</label>
                        <textarea name="komentar" class="form-control" rows="3" placeholder="Tambahkan catatan jika perlu..."></textarea>
                    </div>
                </div>
                <div class="modal-footer p-3">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btn_submit_approval" class="btn fw-bold px-4">GAS</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
            title.innerText = 'Approve Progress';
            text.innerText = 'Konfirmasi persetujuan laporan progress ini. Persentase aplikasi akan diperbarui di dashboard.';
            header.className = 'modal-header bg-success text-white p-4';
            btn.className = 'btn btn-success fw-bold px-4';
            btn.innerText = 'APPROVE SEKARANG';
        } else {
            title.innerText = 'Reject Progress';
            text.innerText = 'Laporan progress akan ditolak. Harap berikan alasan penolakan di kolom komentar.';
            header.className = 'modal-header bg-danger text-white p-4';
            btn.className = 'btn btn-danger fw-bold px-4';
            btn.innerText = 'REJECT LAPORAN';
        }

        if(!approvalModal) approvalModal = new bootstrap.Modal(document.getElementById('modalApproval'));
        approvalModal.show();
    }
</script>
<?= $this->endSection() ?>

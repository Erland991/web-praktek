<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<?php
    $currentUserId = session()->get('id');
    $currentRole   = session()->get('role');
?>

<div class="row mb-4 mt-3">
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm bg-white">
            <div class="card-body p-4 position-relative z-1 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 border-start border-4 border-primary">
                <div>
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-2 fs-2 fw-medium px-3 py-1 rounded-pill">
                        <i class="ti ti-mail-check me-1"></i> Persetujuan Memo
                    </span>
                    <h4 class="fw-bold text-dark mb-1">Persetujuan Memo Rapat</h4>
                    <p class="mb-0 text-muted" style="max-width: 600px;">
                        Daftar Memo Rapat yang membutuhkan tanda tangan Anda. Tombol setujui hanya muncul untuk memo yang ditujukan kepada Anda.
                    </p>
                </div>
                <div class="d-none d-md-block opacity-50 text-end">
                    <i class="ti ti-notes text-primary" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(session()->getFlashdata('sukses')): ?>
<div class="alert alert-success border-0 shadow-sm mb-4 rounded-3 d-flex align-items-center">
    <i class="ti ti-circle-check fs-5 me-2"></i> <?= session()->getFlashdata('sukses') ?>
</div>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-0">
        <?php if(empty($pending_memo)): ?>
        <div class="text-center py-5 text-muted">
            <i class="ti ti-mail-check fs-1 d-block mb-3 text-success opacity-50" style="font-size: 3rem !important;"></i>
            <h5 class="fw-bold text-muted">Tidak Ada Memo Menunggu</h5>
            <p class="mb-0">Semua Memo Rapat yang ditujukan kepada Anda sudah disetujui.</p>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted fs-3 text-uppercase fw-semibold tracking-wider">
                    <tr>
                        <th class="ps-4 py-3 border-bottom-0">Judul Memo / Aplikasi</th>
                        <th class="py-3 border-bottom-0">Dibuat Oleh</th>
                        <th class="py-3 border-bottom-0 text-center">Tanggal Rapat</th>
                        <th class="py-3 border-bottom-0" style="min-width:240px;">Status Tanda Tangan</th>
                        <th class="px-4 py-3 border-bottom-0 text-center" style="min-width:160px;">Aksi Saya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($pending_memo as $n):
                        $canSlot1    = !$n['is_approved1'] && ($currentUserId == $n['approval_user1_id']);
                        $canSlot2    = !empty($n['approval_user2_id']) && !$n['is_approved2'] && ($currentUserId == $n['approval_user2_id']);
                        $hasMyAction = $canSlot1 || $canSlot2;
                        $alreadyDone = (!$canSlot1 && $n['is_approved1'] && $currentUserId == $n['approval_user1_id'])
                                    || (!$canSlot2 && !empty($n['approval_user2_id']) && $n['is_approved2'] && $currentUserId == $n['approval_user2_id']);
                    ?>
                    <tr id="memo-row-<?= $n['id'] ?>"
                        class="<?= $hasMyAction ? 'table-warning' : '' ?>"
                        style="<?= (!$hasMyAction && !$alreadyDone) ? 'opacity:0.7' : '' ?>">
                        <td class="border-bottom-0 ps-4">
                            <div class="d-flex align-items-center">
                                <div class="<?= $hasMyAction ? 'bg-warning' : 'bg-primary' ?> bg-opacity-10 <?= $hasMyAction ? 'text-warning' : 'text-primary' ?> rounded-2 p-2 me-3 flex-shrink-0" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
                                    <i class="ti ti-notes fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark text-wrap" style="word-break: break-word; max-width: 250px;"><?= esc($n['agenda'] ?: 'Memo Rapat') ?></h6>
                                    <small class="text-muted d-block mt-1 text-wrap" style="word-break: break-word; max-width: 250px;"><?= esc($n['nama_app'] ?: 'Umum') ?></small>
                                </div>
                            </div>
                        </td>
                        <td class="border-bottom-0">
                            <span class="fw-semibold text-dark"><?= esc($n['dibuat_oleh']) ?></span>
                            <small class="d-block text-muted"><?= date('d M Y H:i', strtotime($n['created_at'] ?? $n['tanggal'])) ?></small>
                        </td>
                        <td class="border-bottom-0 text-center">
                            <span class="badge bg-light text-dark border px-2 py-1 rounded-pill">
                                <i class="ti ti-calendar me-1"></i><?= date('d M Y', strtotime($n['tanggal'])) ?>
                            </span>
                        </td>
                        <td class="border-bottom-0">
                            <!-- Slot 1 -->
                            <div class="mb-1">
                                <?php if($n['is_approved1']): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-2 d-inline-flex align-items-center gap-1 w-100">
                                        <i class="ti ti-check"></i>
                                        <span><?= esc($n['penyetuju1'] ?: $n['nama_setuju1'] ?: '-') ?></span>
                                        <span class="ms-auto opacity-75 small">✓ Disetujui</span>
                                    </span>
                                <?php elseif(!empty($n['approval_user1_id']) || !empty($n['nama_setuju1'])): ?>
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1 rounded-2 d-inline-flex align-items-center gap-1 w-100">
                                        <i class="ti ti-clock-hour-4"></i>
                                        <span><?= esc($n['penyetuju1'] ?: $n['nama_setuju1'] ?: '-') ?></span>
                                        <span class="ms-auto opacity-75 small">Menunggu</span>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <!-- Slot 2 -->
                            <?php if(!empty($n['approval_user2_id']) || !empty($n['nama_setuju2'])): ?>
                            <div>
                                <?php if($n['is_approved2']): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-2 d-inline-flex align-items-center gap-1 w-100">
                                        <i class="ti ti-check"></i>
                                        <span><?= esc($n['penyetuju2'] ?: $n['nama_setuju2'] ?: '-') ?></span>
                                        <span class="ms-auto opacity-75 small">✓ Disetujui</span>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1 rounded-2 d-inline-flex align-items-center gap-1 w-100">
                                        <i class="ti ti-clock-hour-4"></i>
                                        <span><?= esc($n['penyetuju2'] ?: $n['nama_setuju2'] ?: '-') ?></span>
                                        <span class="ms-auto opacity-75 small">Menunggu</span>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td class="border-bottom-0 text-center px-3">
                            <div class="d-flex flex-column gap-2 align-items-center">
                                <?php if($canSlot1): ?>
                                <button onclick="approveMemo(<?= $n['id'] ?>, 1, this)"
                                    id="btn-memo-<?= $n['id'] ?>-1"
                                    class="btn btn-success btn-sm rounded-pill px-4 fw-bold shadow-sm w-100">
                                    <i class="ti ti-check me-1"></i>Setujui
                                </button>
                                <?php elseif($n['is_approved1'] && $currentUserId == $n['approval_user1_id']): ?>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2 w-100">
                                    <i class="ti ti-check me-1"></i>Sudah Disetujui
                                </span>
                                <?php endif; ?>

                                <?php if($canSlot2): ?>
                                <button onclick="approveMemo(<?= $n['id'] ?>, 2, this)"
                                    id="btn-memo-<?= $n['id'] ?>-2"
                                    class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm w-100">
                                    <i class="ti ti-check me-1"></i>Setujui
                                </button>
                                <?php elseif(!empty($n['approval_user2_id']) && $n['is_approved2'] && $currentUserId == $n['approval_user2_id']): ?>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2 w-100">
                                    <i class="ti ti-check me-1"></i>Sudah Disetujui
                                </span>
                                <?php endif; ?>

                                <a href="<?= base_url('notula/edit/'.$n['id']) ?>"
                                    class="btn btn-light btn-sm rounded-pill px-3 border text-primary w-100"
                                    style="min-width:120px;">
                                    <i class="ti ti-eye me-1"></i>Lihat Memo
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<script>
    function approveMemo(id, slot, btn) {
        if (!confirm('Konfirmasi: Setujui Memo Rapat ini?')) return;
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="ti ti-loader ti-spin me-1"></i> Memproses...';
        btn.disabled = true;

        fetch(`<?= base_url('admin/approval/approve-notula/') ?>${id}/${slot}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                // Ubah tombol jadi badge "Sudah Disetujui"
                btn.outerHTML = `<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2 w-100">
                    <i class="ti ti-check me-1"></i>Sudah Disetujui
                </span>`;
                
                // Update badge status TTD di kolom sebelah kiri
                const row = document.getElementById('memo-row-' + id);
                if (row) {
                    row.classList.remove('table-warning');
                    const badges = row.querySelectorAll('.badge.bg-warning');
                    if (badges[slot - 1]) {
                        badges[slot - 1].className = 'badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-2 d-inline-flex align-items-center gap-1 w-100';
                        const icon = badges[slot - 1].querySelector('i');
                        if (icon) icon.className = 'ti ti-check';
                        const statusSpan = badges[slot - 1].querySelector('span:last-child');
                        if (statusSpan) statusSpan.textContent = '✓ Disetujui';
                    }
                }

                if (data.is_final) {
                    alert('✅ Memo berhasil disetujui!\nSemua tanda tangan sudah lengkap. Memo FINAL.');
                } else {
                    alert('✅ Memo berhasil disetujui!');
                }
            } else {
                alert('❌ ' + data.message);
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            }
        })
        .catch(() => {
            alert('Terjadi kesalahan jaringan.');
            btn.innerHTML = originalHtml;
            btn.disabled = false;
        });
    }
</script>
<?= $this->endSection() ?>

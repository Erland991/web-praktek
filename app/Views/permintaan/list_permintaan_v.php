<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<?php 
    $currentUserId = session()->get('id');
    $currentRole = session()->get('role');

    // Count items waiting for this user's approval
    $pendingForMe = 0;
    if (!empty($permintaan_list)) {
        foreach($permintaan_list as $p) {
            if ($p['doc_status'] == 'pending_approval' && !$p['is_approved'] && 
                ($p['approval_user_id'] == $currentUserId || $currentRole === 'Admin')) {
                $pendingForMe++;
            }
        }
    }
?>
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4 bg-white border-start border-5 border-primary d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-1 rounded-pill fw-bold">
                    <i class="ti ti-list me-1"></i> Permintaan Aplikasi
                </span>
                <h3 class="fw-bold text-dark mb-1">Daftar Permintaan Aplikasi Baru</h3>
                <p class="text-muted mb-0">Kelola dan tracking pengajuan aplikasi baru Anda.</p>
            </div>
            <div>
                <a href="<?= base_url('permintaan') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm hover-elevate">
                    <i class="ti ti-plus me-1"></i> Buat Permintaan Baru
                </a>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('sukses')) : ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
            <button type="button" class="btn-close mt-2" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Sukses!</strong> <?= session()->getFlashdata('sukses') ?>
        </div>
    <?php endif; ?>

    <?php if ($pendingForMe > 0): ?>
    <div class="alert border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" style="background: linear-gradient(135deg, #fef3c7, #fde68a); border-left: 5px solid #f59e0b !important;">
        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 44px; height: 44px;">
            <i class="ti ti-bell-ringing text-white fs-4"></i>
        </div>
        <div>
            <h6 class="fw-bold mb-1 text-dark">Ada <?= $pendingForMe ?> Permintaan Menunggu Persetujuan Anda!</h6>
            <p class="mb-0 text-dark opacity-75 small">Klik tombol <strong>"Setujui"</strong> di baris permintaan yang berstatus kuning untuk memberikan persetujuan.</p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tablePermintaan">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-secondary text-uppercase fs-7 tracking-wider rounded-start px-4">Tgl Pengajuan</th>
                            <th class="text-secondary text-uppercase fs-7 tracking-wider">Aplikasi</th>
                            <th class="text-secondary text-uppercase fs-7 tracking-wider">Pemohon</th>
                            <th class="text-secondary text-uppercase fs-7 tracking-wider text-center">Penyetuju</th>
                            <th class="text-secondary text-uppercase fs-7 tracking-wider text-center">Status</th>
                            <th class="text-secondary text-uppercase fs-7 tracking-wider rounded-end text-end px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($permintaan_list)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="ti ti-folder-off fs-1 d-block mb-2 opacity-50"></i>
                                    Belum ada data permintaan aplikasi.
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach($permintaan_list as $row): 
                                $canApprove = !$row['is_approved'] && $row['doc_status'] == 'pending_approval' &&
                                              $row['approval_user_id'] == $currentUserId;
                            ?>
                            <tr class="<?= $canApprove ? 'table-warning-soft' : '' ?>">
                                <td class="px-4 py-3">
                                    <span class="text-dark fw-bold"><?= date('d M Y', strtotime($row['created_at'])) ?></span><br>
                                    <small class="text-muted"><?= date('H:i', strtotime($row['created_at'])) ?></small>
                                </td>
                                <td class="py-3">
                                    <span class="d-block fw-bold text-dark text-wrap" style="word-break: break-word; max-width: 250px;"><?= esc($row['nama_app']) ?></span>
                                    <small class="text-muted d-block mt-1 text-wrap" style="max-width: 250px; word-break: break-word; line-height: 1.4;"><?= esc($row['deskripsi']) ?></small>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                            <span class="fw-bold fs-7"><?= substr($row['nama_disiapkan'] ?: 'U', 0, 1) ?></span>
                                        </div>
                                        <div>
                                            <span class="d-block text-dark fw-semibold"><?= esc($row['nama_disiapkan']) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center py-3">
                                    <?php if($row['nama_setuju']): ?>
                                        <span class="badge bg-light text-dark border px-2 py-1">
                                            <i class="ti ti-user-check text-primary me-1"></i> <?= esc($row['nama_setuju']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted fs-7">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center py-3">
                                    <?php if($row['doc_status'] == 'draft'): ?>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-3 py-1 rounded-pill">Draft</span>
                                    <?php elseif($row['doc_status'] == 'pending_approval'): ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-1 rounded-pill">
                                            <i class="ti ti-clock-hour-4 me-1"></i> Menunggu Persetujuan
                                        </span>
                                    <?php elseif($row['doc_status'] == 'approved'): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill">
                                            <i class="ti ti-check me-1"></i> Disetujui
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end px-4 py-3">
                                    <div class="d-flex gap-1 justify-content-end align-items-center">
                                        <?php if($canApprove): ?>
                                        <button 
                                            onclick="doApprove(<?= $row['id'] ?>, '<?= esc($row['nama_app']) ?>', this)" 
                                            class="btn btn-sm btn-success rounded-pill px-3 fw-bold shadow-sm hover-elevate approve-btn"
                                            data-bs-toggle="tooltip" title="Setujui Permintaan Ini">
                                            <i class="ti ti-check me-1"></i> Setujui
                                        </button>
                                        <?php endif; ?>
                                        <a href="<?= base_url('permintaan/edit/'.$row['id']) ?>" class="btn btn-sm btn-light btn-icon text-primary rounded-circle" data-bs-toggle="tooltip" title="<?= $row['is_approved'] ? 'Lihat Detail' : 'Edit / Detail' ?>">
                                            <i class="ti <?= $row['is_approved'] ? 'ti-eye' : 'ti-edit' ?> fs-5"></i>
                                        </a>
                                        <?php if($row['is_approved']): ?>
                                        <a href="<?= base_url('permintaan/export/'.$row['id']) ?>" target="_blank" class="btn btn-sm btn-light btn-icon text-danger rounded-circle" data-bs-toggle="tooltip" title="Cetak PDF">
                                            <i class="ti ti-file-download fs-5"></i>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .tracking-wider { letter-spacing: 0.05em; }
    .fs-7 { font-size: 0.8rem; }
    
    .table-warning-soft {
        background-color: rgba(251, 191, 36, 0.06) !important;
    }
    
    .hover-elevate {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-elevate:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    }
    
    .btn-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .btn-icon:hover {
        background-color: var(--bs-primary) !important;
        color: white !important;
    }
    .btn-icon.text-danger:hover {
        background-color: var(--bs-danger) !important;
    }
    
    .approve-btn {
        animation: pulse-green 2s infinite;
    }
    @keyframes pulse-green {
        0% { box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.4); }
        70% { box-shadow: 0 0 0 8px rgba(25, 135, 84, 0); }
        100% { box-shadow: 0 0 0 0 rgba(25, 135, 84, 0); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });

    function doApprove(id, namaApp, btn) {
        if (!confirm('Apakah Anda yakin ingin MENYETUJUI permintaan aplikasi "' + namaApp + '"?\n\nSetelah disetujui, aplikasi ini akan otomatis masuk ke Master Aplikasi dan Tanggal Mulai Pengembangan akan dicatat hari ini.')) {
            return;
        }
        
        btn.innerHTML = '<i class="ti ti-loader ti-spin me-1"></i> Memproses...';
        btn.disabled = true;

        fetch(`<?= base_url('permintaan/approve/') ?>${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Update row UI without reload
                const row = btn.closest('tr');
                const actionContainer = btn.closest('.d-flex');
                
                // Remove approve button
                btn.remove();
                
                // Update status badge
                const statusCell = row.querySelector('td:nth-child(5)');
                statusCell.innerHTML = `<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill"><i class="ti ti-check me-1"></i> Disetujui</span>`;
                
                // Remove yellow highlight
                row.classList.remove('table-warning-soft');

                // Update detail icon from ti-edit to ti-eye
                const detailBtn = actionContainer.querySelector('a.btn-icon.text-primary');
                if(detailBtn) {
                    detailBtn.setAttribute('data-bs-original-title', 'Lihat Detail');
                    detailBtn.innerHTML = '<i class="ti ti-eye fs-5"></i>';
                }

                // Append PDF button dynamically
                const pdfBtn = document.createElement('a');
                pdfBtn.href = `<?= base_url('permintaan/export/') ?>${id}`;
                pdfBtn.target = "_blank";
                pdfBtn.className = "btn btn-sm btn-light btn-icon text-danger rounded-circle animate__animated animate__zoomIn";
                pdfBtn.setAttribute("data-bs-toggle", "tooltip");
                pdfBtn.title = "Cetak PDF";
                pdfBtn.innerHTML = '<i class="ti ti-file-download fs-5"></i>';
                actionContainer.appendChild(pdfBtn);

                // Re-init tooltips
                var tooltipTriggerList = [].slice.call(row.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Tampilkan notifikasi
                alert('✅ ' + data.message + '\nTanggal Mulai Pengembangan: ' + data.tgl_mulai);
            } else {
                alert('❌ ' + data.message);
                btn.innerHTML = '<i class="ti ti-check me-1"></i> Setujui';
                btn.disabled = false;
            }
        })
        .catch(err => {
            alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
            btn.innerHTML = '<i class="ti ti-check me-1"></i> Setujui';
            btn.disabled = false;
        });
    }
</script>
<?= $this->endSection() ?>


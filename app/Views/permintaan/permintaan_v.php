<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<?php 
    $is_approved = !empty($permintaan['is_approved']);
    $readonly = $is_approved ? 'readonly' : '';
    $disabled = $is_approved ? 'disabled' : '';
    $doc_status = $permintaan['doc_status'] ?? 'draft';
?>

<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4 bg-white d-flex justify-content-between align-items-center border-start border-5 border-primary">
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-1 rounded-pill fw-bold">
                    <i class="ti ti-file-plus me-1"></i> Form Permintaan
                </span>
                <h3 class="fw-bold text-dark mb-1"><?= !empty($permintaan['id']) ? 'Detail Permintaan Aplikasi' : 'Buat Permintaan Aplikasi Baru' ?></h3>
                <p class="text-muted mb-0">Pengajuan pengembangan aplikasi baru</p>
            </div>
            <div class="text-end">
                <span class="badge <?= $doc_status === 'approved' ? 'bg-success bg-opacity-10 text-success border border-success border-opacity-25' : 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25' ?> px-3 py-2 rounded-pill ms-2">
                    <?= strtoupper(str_replace('_', ' ', $doc_status)) ?>
                </span>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
            <button type="button" class="btn-close mt-2" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Gagal!</strong> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('permintaan/save') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= $permintaan['id'] ?? '' ?>">
        
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-header bg-white border-bottom px-5 py-4">
                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 me-3">
                        <i class="ti ti-info-circle fs-4"></i>
                    </div>
                    Informasi Kebutuhan Aplikasi
                </h5>
            </div>
            <div class="card-body p-5">
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="form-floating mb-3">
                            <input type="text" name="nama_app" class="form-control border-2 bg-light rounded-3" id="nama_app" placeholder="Contoh: Sistem HRIS" value="<?= $permintaan['nama_app'] ?? '' ?>" required <?= $readonly ?>>
                            <label for="nama_app" class="fw-bold text-muted">Nama Aplikasi yang Diusulkan</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <input type="date" name="tgl_target" class="form-control border-2 bg-light rounded-3" id="tgl_target" value="<?= $permintaan['tgl_target'] ?? '' ?>" required <?= $readonly ?>>
                            <label for="tgl_target" class="fw-bold text-muted">Target Waktu Selesai</label>
                        </div>
                    </div>
                </div>
                
                <div class="row g-4 mt-1">
                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <textarea name="latar_belakang" class="form-control border-2 bg-light rounded-3 custom-textarea" id="latar_belakang" placeholder="Mengapa butuh aplikasi ini?" required <?= $readonly ?> style="height: 120px;"><?= $permintaan['latar_belakang'] ?? '' ?></textarea>
                            <label for="latar_belakang" class="fw-bold text-muted">Latar Belakang Permintaan</label>
                        </div>
                    </div>
                </div>
                
                <div class="row g-4 mt-1">
                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <textarea name="deskripsi" class="form-control border-2 bg-light rounded-3 custom-textarea" id="deskripsi" placeholder="Fungsi dan fitur utama yang diharapkan" required <?= $readonly ?> style="height: 120px;"><?= $permintaan['deskripsi'] ?? '' ?></textarea>
                            <label for="deskripsi" class="fw-bold text-muted">Deskripsi Aplikasi & Fitur Utama</label>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mt-1">
                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <textarea name="uraian_tambahan" class="form-control border-2 bg-light rounded-3 custom-textarea" id="uraian_tambahan" placeholder="Catatan tambahan khusus (opsional)" <?= $readonly ?> style="height: 100px;"><?= $permintaan['uraian_tambahan'] ?? '' ?></textarea>
                            <label for="uraian_tambahan" class="fw-bold text-muted">Uraian Permintaan Tambahan / Khusus (Opsional)</label>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mt-1">
                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <textarea name="lampiran" class="form-control border-2 bg-light rounded-3 custom-textarea" id="lampiran" placeholder="Sebutkan lampiran yang ada (Proposal, Alur bisnis, dll)" <?= $readonly ?> style="height: 100px;"><?= $permintaan['lampiran'] ?? '' ?></textarea>
                            <label for="lampiran" class="fw-bold text-muted">Lampiran (Jika Ada)</label>
                            <div class="form-text text-muted ms-2"><i class="ti ti-info-circle"></i> Contoh: Proposal Teknis, Alur Bisnis Eksisting, dsb.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian Tanda Tangan -->
        <h5 class="fw-bold text-dark mt-5 mb-4 ms-2">Pengesahan Dokumen</h5>
        <div class="row g-4 mb-5 justify-content-center">
            <div class="col-md-5">
                <div class="card border border-2 border-primary border-opacity-25 shadow-sm rounded-4 h-100 overflow-hidden bg-white">
                    <div class="position-absolute top-0 start-0 w-100 bg-primary bg-opacity-10" style="height: 5px;"></div>
                    <div class="card-body text-center p-4">
                        <h6 class="fw-bold text-muted mb-3 text-uppercase tracking-wider">Disiapkan Oleh (Pengaju):</h6>
                        
                        <div class="signature-box mx-auto mb-3 d-flex align-items-center justify-content-center flex-column" style="height: 90px;">
                            <div class="digital-stamp bg-success bg-opacity-10 text-success rounded-circle mb-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="ti ti-check fs-2"></i>
                            </div>
                            <span class="text-success small fw-bold tracking-wider">Digitally Signed</span>
                        </div>
                        
                        <input type="text" name="nama_disiapkan" class="form-control text-center fw-bold border-0 bg-transparent fs-5 px-0 mb-1" placeholder="Nama Lengkap" value="<?= $permintaan['nama_disiapkan'] ?? '' ?>" <?= $readonly ?>>
                        <div class="border-top border-2 mx-4 my-2"></div>
                        <input type="text" name="jabatan_disiapkan" class="form-control form-control-sm text-center text-muted border-0 bg-transparent fs-6 px-0" placeholder="Jabatan" value="<?= $permintaan['jabatan_disiapkan'] ?? '' ?>" <?= $readonly ?>>
                    </div>
                </div>
            </div>
            
            <div class="col-md-5">
                <div class="card border border-2 shadow-sm rounded-4 h-100 position-relative overflow-hidden bg-white">
                    <div class="position-absolute top-0 start-0 w-100 bg-secondary bg-opacity-25" style="height: 5px;"></div>
                    <div class="card-body text-center p-4">
                        <h6 class="fw-bold text-muted mb-3 text-uppercase tracking-wider">Disetujui Oleh:</h6>
                        
                        <div class="signature-box mx-auto mb-3 d-flex align-items-center justify-content-center flex-column" style="height: 90px;">
                            <?php 
                                $currentUserId = session()->get('id');
                                $currentRole = session()->get('role');
                                $canApprove = !empty($permintaan['id']) && empty($permintaan['is_approved']) && ($currentUserId == $permintaan['approval_user_id'] || $currentRole === 'Admin');
                            ?>
                            <?php if(!empty($permintaan['is_approved'])): ?>
                                <div class="digital-stamp bg-success bg-opacity-10 text-success rounded-circle mb-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="ti ti-check fs-2"></i>
                                </div>
                                <span class="text-success small fw-bold tracking-wider">APPROVED</span>
                            <?php elseif($canApprove): ?>
                                <button type="button" onclick="approvePermintaan(<?= $permintaan['id'] ?>, this)" class="btn btn-outline-primary rounded-pill px-4 shadow-sm hover-elevate">Approve Sekarang</button>
                            <?php else: ?>
                                <div class="text-muted opacity-50 d-flex flex-column align-items-center">
                                    <i class="ti ti-clock fs-3 mb-1"></i>
                                    <span class="small tracking-wider"><?= empty($permintaan['id']) ? 'Menunggu Simpan' : 'Menunggu Persetujuan' ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if(!$is_approved): ?>
                        <div class="mb-2 text-start px-3">
                            <select name="approval_user_id" id="approval_user_id" class="form-select border-2 bg-light rounded-3" <?= $disabled ?> onchange="syncApprovalName()">
                                <option value="">Pilih Penyetuju...</option>
                                <?php foreach($users as $user): ?>
                                    <option value="<?= $user['id'] ?>" <?= (!empty($permintaan['approval_user_id']) && $permintaan['approval_user_id'] == $user['id']) ? 'selected' : '' ?>><?= $user['nama_lengkap'] ?> (<?= $user['role'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>

                        <input type="text" name="nama_setuju" id="nama_setuju" class="form-control text-center fw-bold border-0 bg-transparent fs-5 px-0 mb-1" placeholder="Nama Penyetuju" value="<?= $permintaan['nama_setuju'] ?? '' ?>" <?= $readonly ?>>
                        <div class="border-top border-2 mx-4 my-2"></div>
                        <input type="text" name="jabatan_setuju" id="jabatan_setuju" class="form-control form-control-sm text-center text-muted border-0 bg-transparent fs-6 px-0" placeholder="Jabatan" value="<?= $permintaan['jabatan_setuju'] ?? '' ?>" <?= $readonly ?>>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card border-0 shadow-lg rounded-4 mb-5 sticky-bottom" style="bottom: 20px; z-index: 100; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <a href="<?= base_url('permintaan/list') ?>" class="btn btn-light border px-4 py-2 fw-bold rounded-pill shadow-sm hover-elevate">
                    <i class="ti ti-arrow-left me-2"></i> Kembali
                </a>
                
                <div class="d-flex gap-3">
                    <?php if(!$is_approved): ?>
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow hover-elevate fs-6">
                        <i class="ti ti-device-floppy me-2"></i> <?= !empty($permintaan['id']) ? 'Simpan Perubahan' : 'Ajukan Permintaan' ?>
                    </button>
                    <?php else: ?>
                        <a href="<?= base_url('permintaan/export/'.$permintaan['id']) ?>" target="_blank" class="btn btn-danger px-4 py-2 fw-bold rounded-pill shadow hover-elevate">
                            <i class="ti ti-file-type-pdf me-2"></i> Cetak PDF Asli
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .tracking-wider { letter-spacing: 0.05em; }
    
    .form-control.border-2, .form-select.border-2 {
        border-color: #e2e8f0;
        transition: all 0.3s ease;
    }
    .form-control.border-2:focus, .form-select.border-2:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.1);
        background-color: #fff !important;
    }
    
    .custom-textarea {
        resize: vertical;
    }
    
    .hover-elevate {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-elevate:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    }
    
    input.bg-transparent:focus {
        background-color: #f8fafc !important;
        border-radius: 8px;
        outline: none;
        box-shadow: inset 0 0 0 2px #3b82f6;
    }

    .signature-box button {
        pointer-events: auto;
        position: relative;
        z-index: 2;
        cursor: pointer;
    }
</style>

<script>
    function syncApprovalName() {
        const select = document.getElementById('approval_user_id');
        const name = document.getElementById('nama_setuju');
        const job = document.getElementById('jabatan_setuju');
        if (!select || !name || !job) return;
        const selected = select.options[select.selectedIndex];
        if (selected && selected.value) {
            const label = selected.textContent.split(' (')[0];
            name.value = label.trim();
            job.value = selected.textContent.includes('(') ? selected.textContent.split('(')[1].replace(')', '').trim() : job.value;
        }
    }

    function approvePermintaan(id, btn) {
        btn.innerHTML = '<i class="ti ti-loader ti-spin"></i> Memproses...';
        btn.disabled = true;

        fetch(`<?= base_url('permintaan/approve/') ?>${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const container = btn.parentElement;
                container.innerHTML = `
                    <div class="digital-stamp bg-success bg-opacity-10 text-success rounded-circle mb-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; transform: scale(0);">
                        <i class="ti ti-check fs-2"></i>
                    </div>
                    <span class="text-success small fw-bold tracking-wider" style="animation: fadeIn 0.5s ease 0.3s forwards; opacity: 0;">APPROVED</span>
                `;
                
                if (!document.getElementById('approveStyles')) {
                    const style = document.createElement('style');
                    style.id = 'approveStyles';
                    style.innerHTML = `
                        @keyframes popIn { 100% { transform: scale(1); } }
                        @keyframes fadeIn { 100% { opacity: 1; } }
                    `;
                    document.head.appendChild(style);
                }

                alert(data.message + '\nTanggal Mulai Pengembangan: ' + data.tgl_mulai);
                setTimeout(() => window.location.reload(), 2000);
            } else {
                alert(data.message);
                btn.innerHTML = 'Approve Sekarang';
                btn.disabled = false;
            }
        })
        .catch(err => {
            alert('Terjadi kesalahan. Silakan coba lagi.');
            btn.innerHTML = 'Approve Sekarang';
            btn.disabled = false;
        });
    }
</script>
<?= $this->endSection() ?>

<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<?php 
    $is_final = !empty($notula['is_final']);
    $readonly = $is_final ? 'readonly' : '';
    $disabled = $is_final ? 'disabled' : '';
    $doc_status = $notula['doc_status'] ?? 'draft';
    $is_revision_requested = !empty($notula['revision_notes']) && !$is_final;
    $attendance = [];
    if (!empty($notula['attendance_list'])) {
        if (is_string($notula['attendance_list'])) {
            $attendance = json_decode($notula['attendance_list'], true) ?: [];
        } elseif (is_array($notula['attendance_list'])) {
            $attendance = $notula['attendance_list'];
        }
    }
    if (empty($attendance)) {
        $attendance = [['name' => session()->get('nama_lengkap'), 'role' => session()->get('role'), 'status' => 'Hadir']];
    }
?>

<div class="container-fluid py-4">
    <!-- Header Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4 bg-white d-flex justify-content-between align-items-center border-start border-5 border-primary">
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-1 rounded-pill fw-bold">
                    <i class="ti ti-edit me-1"></i> E-Dokumen
                </span>
                <h3 class="fw-bold text-dark mb-1"><?= isset($notula) ? 'Edit Notula Rapat' : 'Buat Notula Rapat' ?></h3>
                <p class="text-muted mb-0">Sistem Manajemen Proyek & Dokumentasi Digital</p>
            </div>
            <div class="text-end">
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                    <i class="ti ti-file-text me-1 text-primary"></i> No. Dokumen: <span class="fw-bold"><?= $doc_number ?></span>
                </span>
                <span class="badge <?= $doc_status === 'final' ? 'bg-success bg-opacity-10 text-success border border-success border-opacity-25' : 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25' ?> px-3 py-2 rounded-pill ms-2">
                    <?= strtoupper($doc_status) ?>
                </span>
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill ms-2">
                    Rev: <span class="fw-bold"><?= $revision ?></span>
                </span>
                <?php if($is_revision_requested): ?>
                    <div class="mt-2">
                        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill shadow-sm"><i class="ti ti-alert-circle me-1"></i> Revisi Diminta</span>
                    </div>
                <?php elseif($is_final): ?>
                    <div class="mt-2">
                        <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm"><i class="ti ti-lock me-1"></i> DOKUMEN TERKUNCI</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="bg-danger text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="ti ti-alert-triangle fs-4"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold">Gagal!</h6>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            </div>
            <button type="button" class="btn-close mt-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('notula/save') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= $notula['id'] ?? '' ?>">
        <input type="hidden" name="aplikasi_id" value="<?= $app_id ?>">
        
        <!-- Form Informasi Dasar -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-header bg-white border-bottom px-5 py-4">
                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 me-3">
                        <i class="ti ti-info-circle fs-4"></i>
                    </div>
                    Informasi Rapat
                </h5>
            </div>
            <div class="card-body p-5">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <input type="date" name="tanggal" class="form-control border-2 bg-light rounded-3" id="tanggal" value="<?= $notula['tanggal'] ?? '' ?>" required <?= $readonly ?>>
                            <label for="tanggal" class="fw-bold text-muted">Tanggal Rapat</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" name="tempat" class="form-control border-2 bg-light rounded-3" id="tempat" placeholder="Ruang Rapat / Zoom" value="<?= $notula['tempat'] ?? '' ?>" required <?= $readonly ?>>
                            <label for="tempat" class="fw-bold text-muted">Tempat Pelaksanaan</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-floating mb-3">
                            <input type="text" name="agenda" class="form-control border-2 bg-light rounded-3" id="agenda" placeholder="Tuliskan topik pembahasan" value="<?= $notula['agenda'] ?? '' ?>" required <?= $readonly ?>>
                            <label for="agenda" class="fw-bold text-muted">Agenda Utama</label>
                        </div>
                        <div class="form-floating">
                            <textarea name="peserta" class="form-control border-2 bg-light rounded-3" id="peserta" style="height: 100px" placeholder="Daftar peserta" <?= $readonly ?>><?= $notula['peserta'] ?? '' ?></textarea>
                            <label for="peserta" class="fw-bold text-muted">Daftar Peserta (Pisahkan dengan koma)</label>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <select name="approval_method" id="approval_method" class="form-select border-2 bg-light rounded-3" <?= $disabled ?> onchange="toggleApprovalMode()">
                                <option value="manual" <?= ($notula['approval_method'] ?? 'manual') === 'manual' ? 'selected' : '' ?>>Manual (TTD Manual)</option>
                                <option value="automatic" <?= ($notula['approval_method'] ?? '') === 'automatic' ? 'selected' : '' ?>>Automatic (Dropdown User)</option>
                            </select>
                            <label for="approval_method" class="fw-bold text-muted">Mode Approval</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <select name="doc_status" class="form-select border-2 bg-light rounded-3" <?= $disabled ?> >
                                <option value="draft" <?= ($notula['doc_status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="final" <?= ($notula['doc_status'] ?? '') === 'final' ? 'selected' : '' ?>>Final</option>
                            </select>
                            <label class="fw-bold text-muted">Status Dokumen</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Dinamis Hasil Pembahasan -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-header bg-white border-bottom px-5 py-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-3 me-3">
                        <i class="ti ti-list-check fs-4"></i>
                    </div>
                    Detail Hasil Pembahasan
                </h5>
                <?php if(!$is_final): ?>
                <button type="button" onclick="addRow()" class="btn btn-primary rounded-pill px-4 shadow-sm hover-elevate">
                    <i class="ti ti-plus me-1"></i> Tambah Item Baru
                </button>
                <?php endif; ?>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 border-0" id="tableNotula">
                        <thead class="bg-light border-bottom">
                            <tr>
                                <th class="ps-5 text-muted text-uppercase tracking-wider fs-7" width="100">Item</th>
                                <th class="text-muted text-uppercase tracking-wider fs-7">Rangkuman Pembahasan</th>
                                <th class="text-muted text-uppercase tracking-wider fs-7" width="250">Penanggung Jawab (PIC)</th>
                                <th class="text-muted text-uppercase tracking-wider fs-7" width="200">Target Waktu</th>
                                <?php if(!$is_final): ?>
                                <th class="text-center" width="80"></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody id="notulaBody">
                            <?php 
                            $items = $notula['hasil_pembahasan'] ?? [['item'=>'01', 'hasil'=>'', 'pic'=>'', 'target'=>'']];
                            foreach($items as $idx => $it): 
                            ?>
                            <tr class="border-bottom">
                                <td class="ps-5 py-3">
                                    <input type="text" name="item[]" class="form-control form-control-sm text-center fw-bold text-primary bg-primary bg-opacity-10 border-0 rounded-3" style="width: 50px;" value="<?= $it['item'] ?>" <?= $readonly ?>>
                                </td>
                                <td class="py-3">
                                    <textarea name="hasil[]" class="form-control border-2 bg-light rounded-3 custom-textarea" rows="2" placeholder="Tuliskan keputusan/pembahasan disini..." <?= $readonly ?>><?= $it['hasil'] ?></textarea>
                                </td>
                                <td class="py-3">
                                    <input type="text" name="pic[]" class="form-control border-2 bg-light rounded-3" placeholder="Nama PIC" value="<?= $it['pic'] ?>" <?= $readonly ?>>
                                </td>
                                <td class="py-3">
                                    <input type="date" name="target[]" class="form-control border-2 bg-light rounded-3" value="<?= $it['target'] ?>" <?= $readonly ?>>
                                </td>
                                <?php if(!$is_final): ?>
                                <td class="text-center py-3">
                                    <button type="button" onclick="removeRow(this)" class="btn btn-light text-danger rounded-circle p-2 shadow-sm delete-btn" data-bs-toggle="tooltip" title="Hapus Baris">
                                        <i class="ti ti-trash fs-5"></i>
                                    </button>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Absensi Kehadiran dipindahkan ke modul terpisah -->

        <!-- Bagian Tanda Tangan -->
        <h5 class="fw-bold text-dark mt-5 mb-4 ms-2">Pengesahan Dokumen</h5>
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card border border-2 border-primary border-opacity-25 shadow-sm rounded-4 h-100 overflow-hidden bg-white">
                    <div class="position-absolute top-0 start-0 w-100 bg-primary bg-opacity-10" style="height: 5px;"></div>
                    <div class="card-body text-center p-4">
                        <h6 class="fw-bold text-muted mb-3 text-uppercase tracking-wider">Disiapkan Oleh:</h6>
                        
                        <div class="signature-box mx-auto mb-3 d-flex align-items-center justify-content-center flex-column" style="height: 90px;">
                            <div class="digital-stamp bg-success bg-opacity-10 text-success rounded-circle mb-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="ti ti-check fs-2"></i>
                            </div>
                            <span class="text-success small fw-bold tracking-wider">Digitally Signed</span>
                        </div>
                        
                        <input type="text" name="nama_disiapkan" class="form-control text-center fw-bold border-0 bg-transparent fs-5 px-0 mb-1" placeholder="Nama Lengkap" value="<?= $notula['nama_disiapkan'] ?? session()->get('nama_lengkap') ?>" <?= $readonly ?>>
                        <div class="border-top border-2 mx-4 my-2"></div>
                        <input type="text" name="jabatan_disiapkan" class="form-control form-control-sm text-center text-muted border-0 bg-transparent fs-6 px-0" placeholder="Jabatan" value="<?= $notula['jabatan_disiapkan'] ?? session()->get('role') ?>" <?= $readonly ?>>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border border-2 shadow-sm rounded-4 h-100 position-relative overflow-hidden bg-white">
                    <div class="position-absolute top-0 start-0 w-100 bg-secondary bg-opacity-25" style="height: 5px;"></div>
                    <div class="card-body text-center p-4">
                        <h6 class="fw-bold text-muted mb-3 text-uppercase tracking-wider">Disetujui Oleh (1):</h6>
                        
                        <div class="signature-box mx-auto mb-3 d-flex align-items-center justify-content-center flex-column" style="height: 90px;">
                            <?php if(!empty($notula['is_approved1'])): ?>
                                <div class="digital-stamp bg-success bg-opacity-10 text-success rounded-circle mb-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="ti ti-check fs-2"></i>
                                </div>
                                <span class="text-success small fw-bold tracking-wider">APPROVED</span>
                            <?php elseif(!empty($notula['id'])): ?>
                                <button type="button" onclick="approveNotula(<?= $notula['id'] ?>, 1, this)" class="btn btn-outline-primary rounded-pill px-4 shadow-sm hover-elevate">Approve Sekarang</button>
                            <?php else: ?>
                                <div class="text-muted opacity-50 d-flex flex-column align-items-center">
                                    <i class="ti ti-clock fs-3 mb-1"></i>
                                    <span class="small tracking-wider">Menunggu Simpan</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-2 text-start">
                            <select name="approval_user1_id" id="approval_user1_id" class="form-select border-2 bg-light rounded-3" <?= $disabled ?> onchange="syncApprovalName(1)">
                                <option value="">Pilih user terdaftar / custom</option>
                                <?php foreach($users as $user): ?>
                                    <option value="<?= $user['id'] ?>" <?= (!empty($notula['approval_user1_id']) && $notula['approval_user1_id'] == $user['id']) ? 'selected' : '' ?>><?= $user['nama_lengkap'] ?> (<?= $user['role'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="text" name="nama_setuju1" id="nama_setuju1" class="form-control text-center fw-bold border-0 bg-transparent fs-5 px-0 mb-1" placeholder="Nama Lengkap" value="<?= $notula['nama_setuju1'] ?? '' ?>" <?= $readonly ?>>
                        <div class="border-top border-2 mx-4 my-2"></div>
                        <input type="text" name="jabatan_setuju1" id="jabatan_setuju1" class="form-control form-control-sm text-center text-muted border-0 bg-transparent fs-6 px-0" placeholder="Jabatan" value="<?= $notula['jabatan_setuju1'] ?? '' ?>" <?= $readonly ?>>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border border-2 shadow-sm rounded-4 h-100 position-relative overflow-hidden bg-white">
                    <div class="position-absolute top-0 start-0 w-100 bg-secondary bg-opacity-25" style="height: 5px;"></div>
                    <div class="card-body text-center p-4">
                        <h6 class="fw-bold text-muted mb-3 text-uppercase tracking-wider">Disetujui Oleh (2):</h6>
                        
                        <div class="signature-box mx-auto mb-3 d-flex align-items-center justify-content-center flex-column" style="height: 90px;">
                            <?php if(!empty($notula['is_approved2'])): ?>
                                <div class="digital-stamp bg-success bg-opacity-10 text-success rounded-circle mb-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="ti ti-check fs-2"></i>
                                </div>
                                <span class="text-success small fw-bold tracking-wider">APPROVED</span>
                            <?php elseif(!empty($notula['id'])): ?>
                                <button type="button" onclick="approveNotula(<?= $notula['id'] ?>, 2, this)" class="btn btn-outline-primary rounded-pill px-4 shadow-sm hover-elevate" style="position: relative; z-index: 2;">Approve Sekarang</button>
                            <?php else: ?>
                                <div class="text-muted opacity-50 d-flex flex-column align-items-center">
                                    <i class="ti ti-clock fs-3 mb-1"></i>
                                    <span class="small tracking-wider">Menunggu Simpan</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-2 text-start">
                            <select name="approval_user2_id" id="approval_user2_id" class="form-select border-2 bg-light rounded-3" <?= $disabled ?> onchange="syncApprovalName(2)">
                                <option value="">Pilih user terdaftar / custom</option>
                                <?php foreach($users as $user): ?>
                                    <option value="<?= $user['id'] ?>" <?= (!empty($notula['approval_user2_id']) && $notula['approval_user2_id'] == $user['id']) ? 'selected' : '' ?>><?= $user['nama_lengkap'] ?> (<?= $user['role'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="text" name="nama_setuju2" id="nama_setuju2" class="form-control text-center fw-bold border-0 bg-transparent fs-5 px-0 mb-1" placeholder="Nama Lengkap" value="<?= $notula['nama_setuju2'] ?? '' ?>" <?= $readonly ?>>
                        <div class="border-top border-2 mx-4 my-2"></div>
                        <input type="text" name="jabatan_setuju2" id="jabatan_setuju2" class="form-control form-control-sm text-center text-muted border-0 bg-transparent fs-6 px-0" placeholder="Jabatan" value="<?= $notula['jabatan_setuju2'] ?? '' ?>" <?= $readonly ?>>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($notula['approval_history'])): ?>
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-header bg-white border-bottom px-5 py-4">
                <h5 class="fw-bold text-dark mb-0">Riwayat Approval & Revisi</h5>
            </div>
            <div class="card-body p-5">
                <ul class="list-group list-group-flush">
                    <?php foreach($notula['approval_history'] as $entry): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-start border-0 px-0 py-3">
                            <div>
                                <strong><?= esc($entry['action']) ?></strong> oleh <?= esc($entry['user_name'] ?? 'Sistem') ?>
                                <?php if (!empty($entry['comment'])): ?>
                                    <div class="text-muted small">Catatan: <?= esc($entry['comment']) ?></div>
                                <?php endif; ?>
                            </div>
                            <span class="badge bg-light text-muted rounded-pill fs-7"><?= date('d M Y H:i', strtotime($entry['timestamp'])) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($notula['id']) && ($notula['is_approved1'] || $notula['is_approved2'])): ?>
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-header bg-white border-bottom px-5 py-4">
                <h5 class="fw-bold text-dark mb-0">Permintaan Revisi</h5>
            </div>
            <div class="card-body p-5">
                <form action="<?= base_url('notula/revise/'.$notula['id']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Catatan Revisi</label>
                        <textarea name="revision_comment" class="form-control border-2 bg-light rounded-3" rows="4" placeholder="Tuliskan alasan perubahan atau catatan revisi"><?= $notula['revision_notes'] ?? '' ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning rounded-pill px-5 shadow-sm">Ajukan Revisi</button>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="card border-0 shadow-lg rounded-4 mb-5 sticky-bottom" style="bottom: 20px; z-index: 100; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <a href="<?= base_url('progress') ?>" class="btn btn-light border px-4 py-2 fw-bold rounded-pill shadow-sm hover-elevate">
                    <i class="ti ti-arrow-left me-2"></i> Kembali
                </a>
                
                <div class="d-flex gap-3">
                    <?php if(!$is_final): ?>
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow hover-elevate fs-6">
                        <i class="ti ti-device-floppy me-2"></i> <?= isset($notula) ? 'Simpan Perubahan' : 'Terbitkan Notula Rapat' ?>
                    </button>
                    <?php else: ?>
                        <a href="<?= base_url('notula/print/'.$notula['id']) ?>" target="_blank" class="btn btn-dark px-4 py-2 fw-bold rounded-pill shadow hover-elevate">
                            <i class="ti ti-printer me-2"></i> Cetak Dokumen
                        </a>
                        <a href="<?= base_url('notula/export/'.$notula['id']) ?>" class="btn btn-danger px-4 py-2 fw-bold rounded-pill shadow hover-elevate">
                            <i class="ti ti-file-type-pdf me-2"></i> Unduh PDF Asli
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .tracking-wider { letter-spacing: 0.05em; }
    .fs-7 { font-size: 0.8rem; }
    
    /* Form Styling */
    .form-control.border-2 {
        border-color: #e2e8f0;
        transition: all 0.3s ease;
    }
    .form-control.border-2:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.1);
        background-color: #fff !important;
    }
    
    .custom-textarea {
        resize: vertical;
        min-height: 50px;
    }
    
    /* Hover Effects */
    .hover-elevate {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-elevate:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    }
    
    .delete-btn {
        transition: all 0.2s ease;
    }
    .delete-btn:hover {
        background-color: #fee2e2 !important;
        color: #ef4444 !important;
        transform: scale(1.1);
    }
    
    /* Signature Inputs */
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
    
    /* Glassmorphism utility */
    .backdrop-blur {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
</style>

<script>
    // Initialize tooltips and approval mode state
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        if (typeof toggleApprovalMode === 'function') {
            toggleApprovalMode();
        }
    });

    function addRow() {
        const tbody = document.getElementById('notulaBody');
        const rowCount = tbody.rows.length + 1;
        const row = document.createElement('tr');
        row.className = 'border-bottom';
        row.innerHTML = `
            <td class="ps-5 py-3">
                <input type="text" name="item[]" class="form-control form-control-sm text-center fw-bold text-primary bg-primary bg-opacity-10 border-0 rounded-3" style="width: 50px;" value="${rowCount.toString().padStart(2, '0')}">
            </td>
            <td class="py-3">
                <textarea name="hasil[]" class="form-control border-2 bg-light rounded-3 custom-textarea" rows="2" placeholder="Tuliskan keputusan/pembahasan disini..."></textarea>
            </td>
            <td class="py-3">
                <input type="text" name="pic[]" class="form-control border-2 bg-light rounded-3" placeholder="Nama PIC">
            </td>
            <td class="py-3">
                <input type="date" name="target[]" class="form-control border-2 bg-light rounded-3">
            </td>
            <td class="text-center py-3">
                <button type="button" onclick="removeRow(this)" class="btn btn-light text-danger rounded-circle p-2 shadow-sm delete-btn" data-bs-toggle="tooltip" title="Hapus Baris">
                    <i class="ti ti-trash fs-5"></i>
                </button>
            </td>
        `;
        
        // Hide tooltip for new row before appending to avoid issues, initialize later if needed
        tbody.appendChild(row);
        
        // Re-init tooltip for the new button
        new bootstrap.Tooltip(row.querySelector('[data-bs-toggle="tooltip"]'));
    }

    function removeRow(btn) {
        const row = btn.closest('tr');
        if (document.getElementById('notulaBody').rows.length > 1) {
            // Hide tooltip before removing to prevent dangling tooltips
            const tooltip = bootstrap.Tooltip.getInstance(btn);
            if(tooltip) tooltip.hide();
            
            // Add fade out animation
            row.style.transition = 'opacity 0.3s ease';
            row.style.opacity = '0';
            setTimeout(() => row.remove(), 300);
        } else {
            alert('Minimal harus ada 1 hasil pembahasan!');
        }
    }

    // Fungsi absensi dipindah ke modul terpisah

    function toggleApprovalMode() {
        const method = document.getElementById('approval_method').value;
        const user1 = document.getElementById('approval_user1_id');
        const user2 = document.getElementById('approval_user2_id');
        const name1 = document.getElementById('nama_setuju1');
        const name2 = document.getElementById('nama_setuju2');
        if (!user1 || !user2 || !name1 || !name2) return;

        name1.placeholder = method === 'automatic' ? 'Pilih user terdaftar atau tulis manual' : 'Masukkan nama manual';
        name2.placeholder = method === 'automatic' ? 'Pilih user terdaftar atau tulis manual' : 'Masukkan nama manual';
        user1.closest('.mb-3').style.opacity = method === 'automatic' ? '1' : '0.9';
        user2.closest('.mb-3').style.opacity = method === 'automatic' ? '1' : '0.9';
    }

    function syncApprovalName(side) {
        const select = document.getElementById('approval_user' + side + '_id');
        const name = document.getElementById('nama_setuju' + side);
        const job = document.getElementById('jabatan_setuju' + side);
        if (!select || !name || !job) return;
        const selected = select.options[select.selectedIndex];
        if (selected && selected.value) {
            const label = selected.textContent.split(' (')[0];
            name.value = label.trim();
            job.value = selected.textContent.includes('(') ? selected.textContent.split('(')[1].replace(')', '').trim() : job.value;
        }
    }

    function approveNotula(id, side, btn) {
        btn.innerHTML = '<i class="ti ti-loader ti-spin"></i> Memproses...';
        btn.disabled = true;

        fetch(`<?= base_url('notula/approve/') ?>${id}/${side}`, {
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
                
                // Add keyframes dynamically if not exists
                if (!document.getElementById('approveStyles')) {
                    const style = document.createElement('style');
                    style.id = 'approveStyles';
                    style.innerHTML = `
                        @keyframes popIn { 100% { transform: scale(1); } }
                        @keyframes fadeIn { 100% { opacity: 1; } }
                    `;
                    document.head.appendChild(style);
                }

                if (data.is_final) {
                    setTimeout(() => window.location.reload(), 1500);
                }
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

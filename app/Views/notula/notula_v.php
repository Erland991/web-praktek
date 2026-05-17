<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<?php 
    $is_final = !empty($notula['is_final']);
    $readonly = $is_final ? 'readonly' : '';
    $disabled = $is_final ? 'disabled' : '';
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
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill ms-2">
                    Rev: <span class="fw-bold"><?= $revision ?></span>
                </span>
                <?php if($is_final): ?>
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

        <!-- Bagian Tanda Tangan -->
        <h5 class="fw-bold text-dark mt-5 mb-4 ms-2">Pengesahan Dokumen</h5>
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card border border-2 border-primary border-opacity-25 shadow-sm rounded-4 h-100 position-relative overflow-hidden bg-white">
                    <div class="position-absolute top-0 start-0 w-100 bg-primary bg-opacity-10" style="height: 5px;"></div>
                    <div class="card-body text-center p-5">
                        <h6 class="fw-bold text-muted mb-4 text-uppercase tracking-wider">Disiapkan Oleh:</h6>
                        
                        <div class="signature-box mx-auto mb-4 d-flex align-items-center justify-content-center flex-column" style="height: 100px;">
                            <div class="digital-stamp bg-success bg-opacity-10 text-success rounded-circle p-3 mb-2 shadow-sm">
                                <i class="ti ti-check fs-2"></i>
                            </div>
                            <span class="text-success small fw-bold tracking-wider">Digitally Signed</span>
                        </div>
                        
                        <input type="text" name="nama_disiapkan" class="form-control text-center fw-bold border-0 bg-transparent fs-5 px-0 mb-1" placeholder="Nama Lengkap" value="<?= $notula['nama_disiapkan'] ?? session()->get('nama_lengkap') ?>" <?= $readonly ?>>
                        <div class="border-top border-2 mx-5 my-2"></div>
                        <input type="text" name="jabatan_disiapkan" class="form-control form-control-sm text-center text-muted border-0 bg-transparent fs-6 px-0" placeholder="Jabatan" value="<?= $notula['jabatan_disiapkan'] ?? session()->get('role') ?>" <?= $readonly ?>>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border border-2 shadow-sm rounded-4 h-100 position-relative overflow-hidden bg-white">
                    <div class="position-absolute top-0 start-0 w-100 bg-secondary bg-opacity-25" style="height: 5px;"></div>
                    <div class="card-body text-center p-5">
                        <h6 class="fw-bold text-muted mb-4 text-uppercase tracking-wider">Disetujui Oleh (1):</h6>
                        
                        <div class="signature-box mx-auto mb-4 d-flex align-items-center justify-content-center flex-column" style="height: 100px;">
                            <?php if(!empty($notula['is_approved1'])): ?>
                                <div class="digital-stamp bg-success bg-opacity-10 text-success rounded-circle p-3 mb-2 shadow-sm">
                                    <i class="ti ti-check fs-2"></i>
                                </div>
                                <span class="text-success small fw-bold tracking-wider">APPROVED</span>
                            <?php elseif(!empty($notula['id'])): ?>
                                <a href="<?= base_url('notula/approve/'.$notula['id'].'/1') ?>" class="btn btn-outline-primary rounded-pill px-4 shadow-sm hover-elevate">Approve Sekarang</a>
                            <?php else: ?>
                                <div class="text-muted opacity-50 d-flex flex-column align-items-center">
                                    <i class="ti ti-clock fs-3 mb-1"></i>
                                    <span class="small tracking-wider">Menunggu Simpan</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <input type="text" name="nama_setuju1" class="form-control text-center fw-bold border-0 bg-transparent fs-5 px-0 mb-1" placeholder="Nama Lengkap" value="<?= $notula['nama_setuju1'] ?? '' ?>" <?= $readonly ?>>
                        <div class="border-top border-2 mx-5 my-2"></div>
                        <input type="text" name="jabatan_setuju1" class="form-control form-control-sm text-center text-muted border-0 bg-transparent fs-6 px-0" placeholder="Jabatan" value="<?= $notula['jabatan_setuju1'] ?? '' ?>" <?= $readonly ?>>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border border-2 shadow-sm rounded-4 h-100 position-relative overflow-hidden bg-white">
                    <div class="position-absolute top-0 start-0 w-100 bg-secondary bg-opacity-25" style="height: 5px;"></div>
                    <div class="card-body text-center p-5">
                        <h6 class="fw-bold text-muted mb-4 text-uppercase tracking-wider">Disetujui Oleh (2):</h6>
                        
                        <div class="signature-box mx-auto mb-4 d-flex align-items-center justify-content-center flex-column" style="height: 100px;">
                            <?php if(!empty($notula['is_approved2'])): ?>
                                <div class="digital-stamp bg-success bg-opacity-10 text-success rounded-circle p-3 mb-2 shadow-sm">
                                    <i class="ti ti-check fs-2"></i>
                                </div>
                                <span class="text-success small fw-bold tracking-wider">APPROVED</span>
                            <?php elseif(!empty($notula['id'])): ?>
                                <a href="<?= base_url('notula/approve/'.$notula['id'].'/2') ?>" class="btn btn-outline-primary rounded-pill px-4 shadow-sm hover-elevate">Approve Sekarang</a>
                            <?php else: ?>
                                <div class="text-muted opacity-50 d-flex flex-column align-items-center">
                                    <i class="ti ti-clock fs-3 mb-1"></i>
                                    <span class="small tracking-wider">Menunggu Simpan</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <input type="text" name="nama_setuju2" class="form-control text-center fw-bold border-0 bg-transparent fs-5 px-0 mb-1" placeholder="Nama Lengkap" value="<?= $notula['nama_setuju2'] ?? '' ?>" <?= $readonly ?>>
                        <div class="border-top border-2 mx-5 my-2"></div>
                        <input type="text" name="jabatan_setuju2" class="form-control form-control-sm text-center text-muted border-0 bg-transparent fs-6 px-0" placeholder="Jabatan" value="<?= $notula['jabatan_setuju2'] ?? '' ?>" <?= $readonly ?>>
                    </div>
                </div>
            </div>
        </div>

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
    
    /* Glassmorphism utility */
    .backdrop-blur {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
</style>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
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
</script>
<?= $this->endSection() ?>

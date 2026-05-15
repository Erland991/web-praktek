<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<?php 
    $is_final = isset($notula) && $notula['is_final'];
    $readonly = $is_final ? 'readonly' : '';
    $disabled = $is_final ? 'disabled' : '';
?>

<div class="container-fluid py-4">
    <!-- Header Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
        <div class="card-body p-4 text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1"><?= isset($notula) ? 'Edit Notula Rapat' : 'Buat Notula Rapat' ?></h2>
                    <p class="mb-0 opacity-75">Sistem Manajemen Proyek & Dokumentasi Digital</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-white bg-opacity-20 border border-white border-opacity-25 px-3 py-2 rounded-pill">
                        <i class="ti ti-file-text me-1"></i> No. Dokumen: <?= $doc_number ?>
                    </span>
                    <span class="badge bg-white bg-opacity-20 border border-white border-opacity-25 px-3 py-2 rounded-pill ms-2">
                        Rev: <?= $revision ?>
                    </span>
                    <?php if($is_final): ?>
                        <div class="mt-2">
                            <span class="badge bg-success px-3 py-1 rounded-pill"><i class="ti ti-lock me-1"></i> LOCKED (Final Approved)</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-triangle me-2 fs-5"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('notula/save') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= $notula['id'] ?? '' ?>">
        <input type="hidden" name="aplikasi_id" value="<?= $app_id ?>">
        
        <!-- Form Informasi Dasar -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <h5 class="fw-bold text-primary mb-0">Informasi Rapat</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tanggal Rapat</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= $notula['tanggal'] ?? '' ?>" required <?= $readonly ?>>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tempat</label>
                        <input type="text" name="tempat" class="form-control" placeholder="Ruang Rapat / Zoom" value="<?= $notula['tempat'] ?? '' ?>" required <?= $readonly ?>>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Agenda</label>
                        <input type="text" name="agenda" class="form-control" placeholder="Tuliskan topik pembahasan" value="<?= $notula['agenda'] ?? '' ?>" required <?= $readonly ?>>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Daftar Peserta</label>
                        <textarea name="peserta" class="form-control" rows="2" placeholder="Contoh: Budi (IT), Ani (Ops), Doni (Manajer)" <?= $readonly ?>><?= $notula['peserta'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Dinamis Hasil Pembahasan -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-primary mb-0">Hasil Pembahasan</h5>
                <?php if(!$is_final): ?>
                <button type="button" onclick="addRow()" class="btn btn-sm btn-primary rounded-pill px-3">
                    <i class="ti ti-plus me-1"></i> Tambah Item
                </button>
                <?php endif; ?>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="tableNotula">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" width="80">ITEM</th>
                                <th>HASIL PEMBAHASAN</th>
                                <th width="250">PENANGGUNG JAWAB</th>
                                <th width="200">TARGET WAKTU</th>
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
                            <tr>
                                <td class="ps-4"><input type="text" name="item[]" class="form-control form-control-sm border-0 bg-light" placeholder="01" value="<?= $it['item'] ?>" <?= $readonly ?>></td>
                                <td><textarea name="hasil[]" class="form-control form-control-sm border-0 bg-light" rows="1" placeholder="Rangkuman pembahasan..." <?= $readonly ?>><?= $it['hasil'] ?></textarea></td>
                                <td><input type="text" name="pic[]" class="form-control form-control-sm border-0 bg-light" placeholder="Nama / Jabatan" value="<?= $it['pic'] ?>" <?= $readonly ?>></td>
                                <td><input type="date" name="target[]" class="form-control form-control-sm border-0 bg-light" value="<?= $it['target'] ?>" <?= $readonly ?>></td>
                                <?php if(!$is_final): ?>
                                <td class="text-center">
                                    <button type="button" onclick="removeRow(this)" class="btn btn-link text-danger p-0"><i class="ti ti-trash fs-5"></i></button>
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
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body text-center p-4">
                        <h6 class="fw-bold text-muted mb-4 text-uppercase fs-1 tracking-wider">Disiapkan Oleh:</h6>
                        <div class="my-4 pt-2 border-bottom border-dashed mx-auto" style="width: 150px; height: 80px;">
                            <p class="text-success small fw-bold mt-4"><i class="ti ti-circle-check"></i> Prepared Digitally</p>
                        </div>
                        <input type="text" name="nama_disiapkan" class="form-control form-control-sm text-center fw-bold border-0 bg-light mb-1" placeholder="Nama Lengkap" value="<?= $notula['nama_disiapkan'] ?? session()->get('nama_lengkap') ?>" <?= $readonly ?>>
                        <input type="text" name="jabatan_disiapkan" class="form-control form-control-sm text-center text-muted border-0 bg-light fs-1" placeholder="Jabatan" value="<?= $notula['jabatan_disiapkan'] ?? session()->get('role') ?>" <?= $readonly ?>>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body text-center p-4">
                        <h6 class="fw-bold text-muted mb-4 text-uppercase fs-1 tracking-wider">Disetujui Oleh (1):</h6>
                        <div class="my-4 pt-2 border-bottom border-dashed mx-auto d-flex align-items-center justify-content-center" style="width: 150px; height: 80px;">
                            <?php if(isset($notula) && $notula['is_approved1']): ?>
                                <p class="text-success small fw-bold mb-0"><i class="ti ti-circle-check"></i> APPROVED</p>
                            <?php elseif(isset($notula)): ?>
                                <a href="<?= base_url('notula/approve/'.$notula['id'].'/1') ?>" class="btn btn-sm btn-outline-success rounded-pill">Approve Now</a>
                            <?php else: ?>
                                <p class="text-muted small italic opacity-50 mb-0">Waiting Save</p>
                            <?php endif; ?>
                        </div>
                        <input type="text" name="nama_setuju1" class="form-control form-control-sm text-center fw-bold border-0 bg-light mb-1" placeholder="Nama Lengkap" value="<?= $notula['nama_setuju1'] ?? '' ?>" <?= $readonly ?>>
                        <input type="text" name="jabatan_setuju1" class="form-control form-control-sm text-center text-muted border-0 bg-light fs-1" placeholder="Jabatan" value="<?= $notula['jabatan_setuju1'] ?? '' ?>" <?= $readonly ?>>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body text-center p-4">
                        <h6 class="fw-bold text-muted mb-4 text-uppercase fs-1 tracking-wider">Disetujui Oleh (2):</h6>
                        <div class="my-4 pt-2 border-bottom border-dashed mx-auto d-flex align-items-center justify-content-center" style="width: 150px; height: 80px;">
                            <?php if(isset($notula) && $notula['is_approved2']): ?>
                                <p class="text-success small fw-bold mb-0"><i class="ti ti-circle-check"></i> APPROVED</p>
                            <?php elseif(isset($notula)): ?>
                                <a href="<?= base_url('notula/approve/'.$notula['id'].'/2') ?>" class="btn btn-sm btn-outline-success rounded-pill">Approve Now</a>
                            <?php else: ?>
                                <p class="text-muted small italic opacity-50 mb-0">Waiting Save</p>
                            <?php endif; ?>
                        </div>
                        <input type="text" name="nama_setuju2" class="form-control form-control-sm text-center fw-bold border-0 bg-light mb-1" placeholder="Nama Lengkap" value="<?= $notula['nama_setuju2'] ?? '' ?>" <?= $readonly ?>>
                        <input type="text" name="jabatan_setuju2" class="form-control form-control-sm text-center text-muted border-0 bg-light fs-1" placeholder="Jabatan" value="<?= $notula['jabatan_setuju2'] ?? '' ?>" <?= $readonly ?>>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-lg rounded-4 mb-5" style="background: #f8fafc;">
            <div class="card-body p-3 d-flex justify-content-end gap-2">
                <a href="<?= base_url('progress') ?>" class="btn btn-light px-4 fw-bold">Kembali</a>
                <?php if(!$is_final): ?>
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                    <i class="ti ti-device-floppy me-1"></i> <?= isset($notula) ? 'Perbarui Notula' : 'Simpan Notula Rapat' ?>
                </button>
                <?php else: ?>
                    <a href="<?= base_url('notula/print/'.$notula['id']) ?>" target="_blank" class="btn btn-success px-5 py-2 fw-bold shadow-sm">
                        <i class="ti ti-printer me-1"></i> Cetak Official (Persis Contoh)
                    </a>
                    <a href="<?= base_url('notula/export/'.$notula['id']) ?>" class="btn btn-outline-success px-5 py-2 fw-bold shadow-sm ms-2">
                        <i class="ti ti-download me-1"></i> Download PDF (Server)
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>

<style>
    .border-dashed { border-style: dashed !important; }
    #tableNotula input, #tableNotula textarea { font-size: 0.9rem; }
    #tableNotula textarea { resize: none; }
    @media print {
        .app-header, .left-sidebar, .btn, .card-header button, .card-footer, .alert { display: none !important; }
        .body-wrapper { margin-left: 0 !important; }
        .container-fluid { padding: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
        .bg-primary { background-color: #0d6efd !important; -webkit-print-color-adjust: exact; }
    }
</style>

<script>
    function addRow() {
        const tbody = document.getElementById('notulaBody');
        const rowCount = tbody.rows.length + 1;
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="ps-4"><input type="text" name="item[]" class="form-control form-control-sm border-0 bg-light" value="${rowCount.toString().padStart(2, '0')}"></td>
            <td><textarea name="hasil[]" class="form-control form-control-sm border-0 bg-light" rows="1" placeholder="Rangkuman pembahasan..."></textarea></td>
            <td><input type="text" name="pic[]" class="form-control form-control-sm border-0 bg-light" placeholder="Nama / Jabatan"></td>
            <td><input type="date" name="target[]" class="form-control form-control-sm border-0 bg-light"></td>
            <td class="text-center">
                <button type="button" onclick="removeRow(this)" class="btn btn-link text-danger p-0"><i class="ti ti-trash fs-5"></i></button>
            </td>
        `;
        tbody.appendChild(row);
    }

    function removeRow(btn) {
        const row = btn.closest('tr');
        if (document.getElementById('notulaBody').rows.length > 1) {
            row.remove();
        }
    }
</script>
<?= $this->endSection() ?>

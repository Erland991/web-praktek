<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4 mt-3">
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm bg-white">
            <div class="card-body p-4 position-relative z-1 border-start border-4 border-primary d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-2 fs-2 fw-medium px-3 py-1 rounded-pill"><i class="ti ti-chart-line me-1"></i> SIMPA Operation</span>
                    <h4 class="fw-bold text-dark mb-1">Master Aplikasi & Progres Saya</h4>
                    <p class="mb-0 text-muted" style="max-width: 600px;">Daftar aplikasi yang ditugaskan kepada Anda sebagai Penanggung Jawab. Klik tombol laporan untuk melacak capaian pengerjaan.</p>
                </div>
                <div>
                    <a href="<?= base_url('permintaan/list') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm hover-elevate">
                        <i class="ti ti-file-plus me-1"></i> Form Permintaan Aplikasi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('sukses')) : ?>
    <div class="alert alert-success shadow-sm mb-4 border-0">
        <i class="ti ti-circle-check fs-5 me-2"></i> <?= session()->getFlashdata('sukses') ?>
    </div>
<?php endif; ?>

<div class="card w-100 shadow-sm border-0 rounded-4 mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted fs-3 text-uppercase fw-semibold tracking-wider">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Nama Aplikasi</th>
                        <th>Divisi</th>
                        <th class="text-center">Progres Terakhir</th>
                        <th class="text-center">Status Laporan</th>
                        <th class="text-center px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($apps as $app): ?>
                    <tr>
                        <td class="ps-4"><?= $no++ ?></td>
                        <td>
                            <h6 class="fw-bold mb-0"><?= $app['nama_app'] ?></h6>
                            <small class="text-muted"><?= substr($app['deskripsi'], 0, 50) ?>...</small>
                        </td>
                        <td><?= $app['nama_divisi'] ?></td>
                        <td class="text-center">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <div class="progress flex-grow-1" style="height: 6px; max-width: 100px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $app['last_percent'] ?>%"></div>
                                </div>
                                <span class="fw-bold fs-2"><?= $app['last_percent'] ?>%</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <?php if($app['last_status'] == 2): ?>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-success rounded-circle" style="width:6px;height:6px;"></span> Approved (Final)</span>
                            <?php elseif($app['last_status'] == 1): ?>
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-info rounded-circle" style="width:6px;height:6px;"></span> Approved Kadiv</span>
                            <?php elseif($app['last_status'] == 3): ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-danger rounded-circle" style="width:6px;height:6px;"></span> Rejected Kadiv</span>
                            <?php elseif($app['last_status'] == 4): ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-danger rounded-circle" style="width:6px;height:6px;"></span> Rejected Admin</span>
                            <?php else: ?>
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-warning rounded-circle" style="width:6px;height:6px;"></span> Pending Kadiv</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center px-4">
                            <div class="d-flex gap-2 justify-content-center align-items-center">
                                <button class="btn btn-primary btn-sm fw-bold shadow-sm d-inline-flex align-items-center px-3" onclick='openModalProgress(<?= json_encode($app) ?>)'>
                                    <i class="ti ti-edit me-1"></i> Update Progres
                                </button>
                                <div class="d-flex gap-1 border-start ps-2 ms-1">
                                    <button class="btn btn-sm btn-light border px-2 text-success shadow-sm" data-bs-toggle="tooltip" title="Checklist SDLC" onclick='openModalSDLC(<?= htmlspecialchars(json_encode($app), ENT_QUOTES, "UTF-8") ?>)'>
                                        <i class="ti ti-checklist fs-5"></i>
                                    </button>
                                    <a href="<?= base_url('notula/list/' . $app['id']) ?>" class="btn btn-sm btn-light border px-2 text-primary shadow-sm" data-bs-toggle="tooltip" title="Memo">
                                        <i class="ti ti-notes fs-5"></i>
                                    </a>
                                    <a href="<?= base_url('notula?app_id=' . $app['id'] . '&quick=1') ?>" class="btn btn-sm btn-light border px-2 text-secondary shadow-sm" data-bs-toggle="tooltip" title="Quick MoM">
                                        <i class="ti ti-rocket fs-5"></i>
                                    </a>
                                    <a href="<?= base_url('absensi?app_id=' . $app['id']) ?>" class="btn btn-sm btn-light border px-2 text-info shadow-sm" data-bs-toggle="tooltip" title="Daftar Hadir">
                                        <i class="ti ti-users fs-5"></i>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if(empty($apps)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="ti ti-briefcase-off fs-9 d-block mb-2"></i>
                            Belum ada aplikasi yang ditugaskan kepada Anda sebagai PIC.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Modal Update Progress -->
<div class="modal fade" id="modalProgress" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white p-4">
                <h5 class="modal-title fw-bold">Update Capaian Pengerjaan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formProgress" action="<?= base_url('progress/update') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="aplikasi_id" id="prog_app_id">
                <div class="modal-body p-4 text-dark">
                    <h5 class="fw-bold text-primary mb-4 pb-2 border-bottom" id="prog_app_name">Aplikasi Nama</h5>
                    
                    <div class="row">
                        <!-- Dynamic Module Selection Container -->
                        <div class="col-12 mb-3" id="modul_container" style="display:none;">
                            <label class="form-label fw-bold text-success"><i class="ti ti-puzzle me-1"></i> Modul / Fitur yang Dikerjakan</label>
                            <select name="modul_id" id="prog_modul_id" class="form-select border-2 border-success">
                                <option value="">Pilih Modul...</option>
                            </select>
                            <small class="text-muted d-block mt-1">Pilih modul untuk update progres. Bobot kesulitan akan otomatis diperhitungkan.</small>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label fw-bold">Persentase (%)</label>
                            <div class="input-group border-2">
                                <input type="number" name="persentase" id="prog_percent" class="form-control" min="0" max="100" required>
                                <span class="input-group-text bg-light">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Deskripsi Pekerjaan / Keterangan</label>
                        <textarea name="pesan" class="form-control" rows="4" placeholder="Jelaskan apa saja yang sudah diselesaikan pada tahap ini..." required></textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold">Unggah Bukti Pengerjaan (Opsional)</label>
                        <input type="file" name="lampiran" class="form-control">
                        <small class="text-muted">Format: PDF, Gambar, atau Dokumen pendukung.</small>
                    </div>
                </div>
                <div class="modal-footer p-4 border-top bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btn_submit_progress" class="btn btn-primary px-5 fw-bold shadow">KIRIM LAPORAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal SDLC Checklist -->
<div class="modal fade" id="modalSDLC" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-success text-white p-4">
                <h5 class="modal-title fw-bold"><i class="ti ti-checklist me-2"></i>Checklist Tahapan SDLC (COBIT-19)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formSDLC" action="<?= base_url('progress/updateSdlc') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="aplikasi_id" id="sdlc_app_id">
                <div class="modal-body p-4 text-dark">
                    <h5 class="fw-bold text-success mb-4 pb-2 border-bottom" id="sdlc_app_name">Aplikasi Nama</h5>
                    
                    <style>
                        .cobit-check-btn {
                            background-color: #f8fafc;
                            border: 1px solid #e2e8f0;
                            color: #64748b;
                            transition: all 0.2s ease;
                            min-width: 100px;
                            flex: 1;
                            cursor: pointer;
                        }
                        .cobit-check-btn:hover {
                            background-color: #f1f5f9;
                            border-color: #cbd5e1;
                            transform: translateY(-2px);
                        }
                        .sdlc-check:checked + .cobit-check-btn {
                            background-color: #ecfdf5;
                            border-color: #10b981;
                            color: #059669;
                            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1) !important;
                        }
                        .cobit-check-btn i {
                            transition: transform 0.2s ease;
                        }
                        .sdlc-check:checked + .cobit-check-btn i {
                            transform: scale(1.15);
                        }
                    </style>
                    <p class="text-muted mb-4">Pilih dan centang tahapan SDLC (COBIT-19) yang sudah diselesaikan untuk aplikasi ini.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach($cobit as $c): 
                            $icon = 'ti-file-text';
                            $namaLower = strtolower($c['nama_proses']);
                            if(strpos($namaLower, 'plan') !== false || strpos($namaLower, 'rencana') !== false || strpos($namaLower, 'align') !== false) $icon = 'ti-clipboard-list';
                            elseif(strpos($namaLower, 'build') !== false || strpos($namaLower, 'develop') !== false || strpos($namaLower, 'acquire') !== false) $icon = 'ti-code';
                            elseif(strpos($namaLower, 'test') !== false || strpos($namaLower, 'uji') !== false) $icon = 'ti-bug';
                            elseif(strpos($namaLower, 'deploy') !== false || strpos($namaLower, 'implement') !== false || strpos($namaLower, 'deliver') !== false) $icon = 'ti-rocket';
                            elseif(strpos($namaLower, 'evaluat') !== false || strpos($namaLower, 'monitor') !== false) $icon = 'ti-chart-dots';
                            elseif(strpos($namaLower, 'support') !== false) $icon = 'ti-headset';
                            elseif(strpos($namaLower, 'user') !== false) $icon = 'ti-users';
                        ?>
                            <input type="checkbox" class="btn-check sdlc-check" name="sdlc[]" id="sdlc_chk_<?= $c['id'] ?>" value="<?= $c['id'] ?>">
                            <label class="btn rounded-4 py-3 d-flex flex-column align-items-center justify-content-center shadow-sm cobit-check-btn" for="sdlc_chk_<?= $c['id'] ?>">
                                <i class="ti <?= $icon ?> fs-2 mb-2"></i>
                                <span style="font-size: 0.75rem; font-weight: 600; text-align: center; line-height: 1.2;"><?= $c['nama_proses'] ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer p-4 border-top bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn_submit_sdlc" class="btn btn-success px-5 fw-bold shadow">SIMPAN CHECKLIST</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let progModal = null;
    function openModalProgress(app) {
        document.getElementById('prog_app_id').value = app.id;
        document.getElementById('prog_app_name').innerText = app.nama_app;
        document.getElementById('prog_percent').value = app.last_percent;
        
        // Handle Module Selection
        const modulContainer = document.getElementById('modul_container');
        const modulSelect = document.getElementById('prog_modul_id');
        
        // Bersihkan opsi lama
        modulSelect.innerHTML = '<option value="">Pilih Modul...</option>';
        
        if (app.modules && app.modules.length > 0) {
            modulContainer.style.display = 'block';
            modulSelect.required = true;
            app.modules.forEach(m => {
                const option = document.createElement('option');
                option.value = m.id;
                option.text = m.nama_modul + ' (Bobot: ' + m.bobot_kesulitan + ') - Selesai: ' + m.persentase + '%';
                modulSelect.appendChild(option);
            });
            
            modulSelect.onchange = function() {
                const selectedModul = app.modules.find(x => x.id == this.value);
                if (selectedModul) {
                    document.getElementById('prog_percent').value = selectedModul.persentase;
                } else {
                    document.getElementById('prog_percent').value = 0;
                }
            };
        } else {
            modulContainer.style.display = 'none';
            modulSelect.required = false;
            modulSelect.onchange = null;
        }

        if(!progModal) progModal = new bootstrap.Modal(document.getElementById('modalProgress'));
        progModal.show();
    }

    document.getElementById('formProgress').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('btn_submit_progress');
        const originalText = btn.innerText;
        btn.innerHTML = '<i class="ti ti-loader ti-spin"></i> Memproses...';
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
                progModal.hide();
                alert(data.message || 'Laporan progress berhasil dikirim!');
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

    let sdlcModal = null;
    function openModalSDLC(app) {
        document.getElementById('sdlc_app_id').value = app.id;
        document.getElementById('sdlc_app_name').innerText = app.nama_app;
        
        // Reset all checkboxes
        document.querySelectorAll('.sdlc-check').forEach(chk => chk.checked = false);
        
        // Check previously saved SDLCs
        if (app.sdlc_checklist) {
            try {
                const checkedIds = JSON.parse(app.sdlc_checklist);
                if (Array.isArray(checkedIds)) {
                    checkedIds.forEach(id => {
                        const chk = document.getElementById('sdlc_chk_' + id);
                        if (chk) chk.checked = true;
                    });
                }
            } catch(e) {}
        }
        
        if(!sdlcModal) sdlcModal = new bootstrap.Modal(document.getElementById('modalSDLC'));
        sdlcModal.show();
    }

    document.getElementById('formSDLC').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('btn_submit_sdlc');
        const originalText = btn.innerText;
        btn.innerHTML = '<i class="ti ti-loader ti-spin"></i> Menyimpan...';
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
                sdlcModal.hide();
                alert(data.message || 'Checklist berhasil disimpan!');
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
</script>
<?= $this->endSection() ?>

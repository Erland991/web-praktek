<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4 mt-3">
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle" style="width: 250px; height: 250px; transform: translate(30%, -30%);"></div>
            <div class="card-body p-4 p-xl-5 position-relative z-1">
                <span class="badge bg-white bg-opacity-10 text-white mb-2 fs-2 fw-medium px-3 py-2 rounded-pill border border-white border-opacity-10"><i class="ti ti-chart-line me-1"></i> SIMPA Operation</span>
                <h2 class="fw-bold text-white mb-2">Master Aplikasi & Progres Saya</h2>
                <p class="mb-0 fs-4 text-white-50" style="max-width: 600px;">Daftar aplikasi yang ditugaskan kepada Anda sebagai Penanggung Jawab. Klik tombol laporan untuk melacak capaian pengerjaan.</p>
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
            <table class="table table-hover align-middle mb-0 text-nowrap">
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
                            <?php if($app['last_status'] == 1): ?>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-success rounded-circle" style="width:6px;height:6px;"></span> Approved</span>
                            <?php elseif($app['last_status'] == 2): ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-danger rounded-circle" style="width:6px;height:6px;"></span> Rejected</span>
                            <?php else: ?>
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="bg-warning rounded-circle" style="width:6px;height:6px;"></span> Pending Review</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center px-4">
                            <button class="btn btn-primary btn-sm fw-bold px-3 shadow-sm d-inline-flex align-items-center" onclick='openModalProgress(<?= json_encode($app) ?>)'>
                                <i class="ti ti-edit me-1"></i> Update Progres
                            </button>
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
            <form action="<?= base_url('progress/update') ?>" method="POST" enctype="multipart/form-data">
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

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Tahapan SDLC (COBIT-19)</label>
                            <select name="cobit_id" class="form-select border-2" required>
                                <option value="">Pilih Tahapan...</option>
                                <?php foreach($cobit as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= $c['nama_proses'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
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
                    <button type="submit" class="btn btn-primary px-5 fw-bold shadow">KIRIM LAPORAN</button>
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
</script>
<?= $this->endSection() ?>

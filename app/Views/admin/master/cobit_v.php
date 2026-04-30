<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4 mt-3">
    <div class="col-12" data-aos="fade-down">
        <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle" style="width: 250px; height: 250px; transform: translate(30%, -30%);"></div>
            <div class="card-body p-4 p-xl-5 position-relative z-1 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <span class="badge bg-white bg-opacity-10 text-white mb-2 fs-2 fw-medium px-3 py-2 rounded-pill border border-white border-opacity-10"><i class="ti ti-shield-check me-1"></i> SIMPA Master Data</span>
                    <h2 class="fw-bold text-white mb-2">Master Instrumen COBIT-19</h2>
                    <p class="mb-0 fs-4 text-white-50" style="max-width: 600px;">Instrumen asesmen audit untuk pemenuhan standar tata kelola IT perusahaan.</p>
                </div>
                <?php if (session()->get('role') == 'Admin') : ?>
                <div>
                    <button type="button" class="btn btn-light text-primary fw-bold d-inline-flex align-items-center shadow-sm px-4 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#modalCobit">
                        <i class="ti ti-plus fs-5 me-2"></i> Tambah Instrumen
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-4 mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="table-light text-muted fs-3 text-uppercase fw-semibold tracking-wider">
                    <tr>
                        <th class="ps-4 py-3 border-bottom-0">Domain</th>
                        <th class="py-3 border-bottom-0">Kode & Nama Proses</th>
                        <th class="py-3 border-bottom-0">Tujuan Audit</th>
                        <?php if (session()->get('role') == 'Admin') : ?>
                        <th class="px-4 py-3 border-bottom-0 text-center">Aksi Lanjutan</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($cobit)): ?>
                        <tr><td colspan="4" class="text-center py-5 text-muted">Belum ada data instrumen COBIT yang terdaftar.</td></tr>
                    <?php endif; ?>
                    <?php foreach($cobit as $c): ?>
                    <tr>
                        <td class="border-bottom-0 ps-4">
                            <span class="badge bg-dark fw-bold px-3 py-2 shadow-sm rounded-pill font-monospace"><i class="ti ti-hash me-1 text-white-50"></i><?= $c['domain'] ?></span>
                        </td>
                        <td class="border-bottom-0">
                            <div class="bg-light-primary rounded-2 px-2 py-1 d-inline-block text-primary fw-bold font-monospace mb-1 border border-primary border-opacity-10"><?= $c['kode_proses'] ?></div>
                            <p class="mb-0 fs-3 fw-semibold text-dark"><?= $c['nama_proses'] ?></p>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fs-3 text-muted" style="max-width:350px; white-space:normal; line-height: 1.4;"><?= $c['tujuan_audit'] ?></p>
                        </td>
                        <?php if (session()->get('role') == 'Admin') : ?>
                        <td class="border-bottom-0 text-end px-4">
                            <a href="<?= base_url('admin/cobit/delete/'.$c['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus instrumen audit ini secara permanen?')" class="btn btn-sm btn-light text-danger hover-danger px-2 border shadow-sm" data-bs-toggle="tooltip" title="Hapus Permanen">
                                <i class="ti ti-trash fs-4"></i>
                            </a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Modal Tambah Cobit -->
<div class="modal fade" id="modalCobit" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-dark text-white p-4">
                <h5 class="modal-title fw-bold">Tambah Instrumen Audit IT</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/cobit/save') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Domain COBIT</label>
                            <select name="domain" class="form-select" required>
                                <option value="EDM">EDM (Evaluate, Direct, Monitor)</option>
                                <option value="APO">APO (Align, Plan, Organize)</option>
                                <option value="BAI">BAI (Build, Acquire, Implement)</option>
                                <option value="DSS">DSS (Deliver, Service, Support)</option>
                                <option value="MEA">MEA (Monitor, Evaluate, Assess)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kode Proses</label>
                            <input type="text" name="kode_proses" class="form-control" placeholder="Contoh: DSS01" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nama Proses</label>
                            <input type="text" name="nama_proses" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Tujuan Audit / Assessment</label>
                            <textarea name="tujuan_audit" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-dark px-4 fw-bold shadow-sm">SIMPAN INSTRUMEN</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

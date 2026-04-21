<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4 mt-3">
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle" style="width: 250px; height: 250px; transform: translate(30%, -30%);"></div>
            <div class="card-body p-4 p-xl-5 position-relative z-1 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <span class="badge bg-white bg-opacity-10 text-white mb-2 fs-2 fw-medium px-3 py-2 rounded-pill border border-white border-opacity-10"><i class="ti ti-server me-1"></i> SIMPA Master Data</span>
                    <h2 class="fw-bold text-white mb-2">Master Register Aplikasi</h2>
                    <p class="mb-0 fs-4 text-white-50" style="max-width: 600px;">Daftar seluruh aplikasi resmi yang dikelola dan dimonitor oleh SIMPA PT Surveyor Indonesia.</p>
                </div>
                <?php if (session()->get('role') == 'Admin') : ?>
                <div>
                    <button type="button" class="btn btn-light text-primary fw-bold d-inline-flex align-items-center shadow-sm px-4 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="ti ti-plus fs-5 me-2"></i> Register Aplikasi
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="table-light text-muted fs-3 text-uppercase fw-semibold tracking-wider">
                    <tr>
                        <th class="border-bottom-0">Nama Aplikasi</th>
                        <th class="border-bottom-0">PIC (User)</th>
                        <th class="border-bottom-0">Divisi</th>
                        <th class="border-bottom-0 text-center">Status</th>
                        <th class="border-bottom-0 text-center">Target</th>
                        <?php if (session()->get('role') == 'Admin') : ?>
                        <th class="border-bottom-0 text-center">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($apps as $app): ?>
                    <tr>
                        <td class="border-bottom-0 ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light-primary rounded-2 p-2 me-3 text-primary">
                                    <i class="ti ti-apps fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark"><?= $app['nama_app'] ?></h6>
                                    <small class="text-muted d-block mt-1"><?= $app['deskripsi'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td class="border-bottom-0">
                            <div class="d-flex align-items-center gap-2">
                                <?php if($app['pic_name']): ?>
                                    <div class="avatar-sm d-flex align-items-center justify-content-center rounded-circle bg-light-info text-info border border-info border-opacity-10 fw-bold" style="width: 32px; height: 32px;">
                                        <?= substr(strtoupper(esc($app['pic_name'])), 0, 1) ?>
                                    </div>
                                    <span class="fs-3 fw-medium text-dark"><?= esc($app['pic_name']) ?></span>
                                <?php else: ?>
                                    <div class="avatar-sm d-flex align-items-center justify-content-center rounded-circle bg-light-danger text-danger border border-danger border-opacity-10 fw-bold" style="width: 32px; height: 32px;"><i class="ti ti-user-off"></i></div>
                                    <span class="text-danger italic fs-3 fw-medium">Unassigned</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="border-bottom-0">
                            <span class="badge bg-light text-dark border px-2 py-1 rounded-pill shadow-none fst-normal"><?= $app['nama_divisi'] ?? '-' ?></span>
                        </td>
                        <td class="border-bottom-0 text-center">
                            <?php 
                                $statusClass = 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25';
                                $dotColor = 'bg-primary';
                                if ($app['status'] == 'Production') { $statusClass = 'bg-success bg-opacity-10 text-success border border-success border-opacity-25'; $dotColor = 'bg-success'; }
                                if ($app['status'] == 'Development') { $statusClass = 'bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25'; $dotColor = 'bg-warning'; }
                            ?>
                            <span class="badge <?= $statusClass ?> px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center"><span class="<?= $dotColor ?> rounded-circle" style="width:6px;height:6px;"></span> <?= $app['status'] ?></span>
                        </td>
                        <td class="border-bottom-0 text-center">
                            <p class="mb-0 fs-2 fw-semibold text-muted"><i class="ti ti-calendar me-1"></i> <?= $app['tgl_target'] ? date('d M Y', strtotime($app['tgl_target'])) : '-' ?></p>
                        </td>
                        <?php if (session()->get('role') == 'Admin') : ?>
                        <td class="border-bottom-0 text-center px-4">
                            <div class="d-flex gap-1 justify-content-center">
                                <button type="button" class="btn btn-sm btn-light text-success hover-success px-2" data-bs-toggle="tooltip" title="Catat Go-Live" onclick="showReleaseModal(<?= $app['id'] ?>, '<?= $app['nama_app'] ?>')">
                                    <i class="ti ti-rocket fs-4"></i>
                                </button>
                                <a href="<?= base_url('admin/app-master/delete/'.$app['id']) ?>" onclick="return confirm('Hapus data master aplikasi ini?')" class="btn btn-sm btn-light text-danger hover-danger px-2" data-bs-toggle="tooltip" title="Hapus Data">
                                    <i class="ti ti-trash fs-4"></i>
                                </a>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white p-4">
                <h5 class="modal-title fw-bold">Register Aplikasi Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/app-master/save') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Nama Aplikasi</label>
                            <input type="text" name="nama_app" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">PIC User</label>
                            <select name="pic_id" class="form-select">
                                <option value="">Pilih User</option>
                                <?php foreach($list_pic as $p): ?>
                                    <option value="<?= $p['id'] ?>"><?= $p['nama_lengkap'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Divisi Pemilik</label>
                            <select name="divisi_id" class="form-select">
                                <option value="">Pilih Divisi</option>
                                <?php foreach($list_divisi as $d): ?>
                                    <option value="<?= $d['id'] ?>"><?= $d['nama_divisi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Status Awal</label>
                            <select name="status" class="form-select">
                                <option value="Development">Development</option>
                                <option value="Production">Production</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tgl Mulai</label>
                            <input type="date" name="tgl_mulai" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tgl Target</label>
                            <input type="date" name="tgl_target" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">SIMPAN REGISTER</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Release / Go-Live -->
<div class="modal fade" id="modalRelease" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-success text-white p-4">
                <h5 class="modal-title fw-bold">Catat Data Implementasi (Go-Live)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/app-master/release') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="aplikasi_id" id="rel_app_id">
                <div class="modal-body p-4">
                    <h6 class="fw-bold mb-3" id="rel_app_name">Aplikasi</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Rilis</label>
                            <input type="date" name="tgl_rilis" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Lingkungan</label>
                            <select name="lingkungan" class="form-select">
                                <option value="Production">Production (Real Use)</option>
                                <option value="Staging">Staging (Trial)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">URL Akses / Server</label>
                            <input type="text" name="url_akses" class="form-control" placeholder="https://app.surveyor.co.id">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Changelog / Fitur Utama</label>
                            <textarea name="changelog" class="form-control" rows="3" placeholder="Ringkasan fitur yang dirilis..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Petugas IT Bertugas</label>
                            <input type="text" name="petugas_it" class="form-control" placeholder="Nama tim IT">
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-3 bg-light">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success px-4 fw-bold shadow-sm">SIMPAN DATA GO-LIVE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showReleaseModal(id, name) {
        document.getElementById('rel_app_id').value = id;
        document.getElementById('rel_app_name').innerText = 'Aplikasi: ' + name;
        new bootstrap.Modal(document.getElementById('modalRelease')).show();
    }
</script>
<?= $this->endSection() ?>

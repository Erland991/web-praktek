<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4 mt-3">
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle" style="width: 250px; height: 250px; transform: translate(30%, -30%);"></div>
            <div class="card-body p-4 p-xl-5 position-relative z-1 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <span class="badge bg-white bg-opacity-10 text-white mb-2 fs-2 fw-medium px-3 py-2 rounded-pill border border-white border-opacity-10"><i class="ti ti-target me-1"></i> SIMPA Master Data</span>
                    <h2 class="fw-bold text-white mb-2">Master KPI Perusahaan</h2>
                    <p class="mb-0 fs-4 text-white-50" style="max-width: 600px;">Kelola dan pantau Key Performance Indicator operasional per divisi Surveyor Indonesia.</p>
                </div>
                <div>
                    <button type="button" class="btn btn-light text-primary fw-bold d-inline-flex align-items-center shadow-sm px-4 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#modalAddKpi">
                        <i class="ti ti-plus fs-5 me-2"></i> Tambah KPI
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body p-0">
                <?php if (session()->getFlashdata('sukses')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('sukses') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-nowrap">
                        <thead class="table-light text-muted fs-3 text-uppercase fw-semibold tracking-wider">
                            <tr>
                                <th class="ps-4 py-3 border-bottom-0 w-10">No</th>
                                <th class="py-3 border-bottom-0">Nama KPI</th>
                                <th class="py-3 border-bottom-0">Target</th>
                                <th class="py-3 border-bottom-0">Satuan</th>
                                <th class="py-3 border-bottom-0">Tahun</th>
                                <th class="py-3 border-bottom-0">Divisi</th>
                                <th class="px-4 py-3 border-bottom-0 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($kpi as $k) : ?>
                            <tr>
                                <td class="border-bottom-0 ps-4 text-muted fw-semibold"><?= $no++ ?></td>
                                <td class="border-bottom-0 fw-bold text-dark"><?= $k['nama_kpi'] ?></td>
                                <td class="border-bottom-0 fw-semibold text-primary"><?= number_format($k['target'], 0) ?></td>
                                <td class="border-bottom-0"><span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 rounded-pill shadow-none fst-normal fw-medium"><?= $k['satuan'] ?></span></td>
                                <td class="border-bottom-0 text-muted"><?= $k['tahun'] ?></td>
                                <td class="border-bottom-0 fs-3"><?= $k['nama_divisi'] ?? '-' ?></td>
                                <td class="border-bottom-0 text-center px-4">
                                    <a href="<?= base_url('admin/kpi/delete/'.$k['id']) ?>" class="btn btn-sm btn-light text-danger hover-danger px-2 border" data-bs-toggle="tooltip" title="Hapus Permanen" onclick="return confirm('Hapus KPI ini secara permanen?')">
                                        <i class="ti ti-trash fs-4"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<!-- Modal Add KPI -->
<div class="modal fade" id="modalAddKpi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('admin/kpi/save') ?>" method="POST" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Target KPI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama KPI</label>
                    <input type="text" name="nama_kpi" class="form-control" placeholder="Contoh: Ketersediaan Layanan" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Target</label>
                        <input type="number" step="0.01" name="target" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Satuan</label>
                        <input type="text" name="satuan" class="form-control" placeholder="%, Hari, Unit, dll" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tahun</label>
                        <select name="tahun" class="form-select" required>
                            <?php for($y=date('Y'); $y>=2020; $y--) : ?>
                                <option value="<?= $y ?>"><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Divisi Terkait</label>
                        <select name="divisi_id" class="form-select" required>
                            <option value="">Pilih Divisi</option>
                            <?php foreach ($divisi as $d) : ?>
                                <option value="<?= $d['id'] ?>"><?= $d['nama_divisi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4">Simpan KPI</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4 mt-3">
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle" style="width: 250px; height: 250px; transform: translate(30%, -30%);"></div>
            <div class="card-body p-4 p-xl-5 position-relative z-1 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <span class="badge bg-white bg-opacity-10 text-white mb-2 fs-2 fw-medium px-3 py-2 rounded-pill border border-white border-opacity-10"><i class="ti ti-sitemap me-1"></i> SIMPA Master Data</span>
                    <h2 class="fw-bold text-white mb-2">Manajemen Divisi</h2>
                    <p class="mb-0 fs-4 text-white-50" style="max-width: 600px;">Konfigurasi struktur organisasi dan departemen operasional (IT/Non-IT) PT Surveyor Indonesia.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 border-top border-4 border-success rounded-3">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold text-dark mb-4"><i class="ti ti-plus me-2 text-success"></i>Tambah Divisi</h5>
                <form action="<?= base_url('master/divisi/save') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Divisi</label>
                        <input type="text" name="kode_divisi" class="form-control" placeholder="Contoh: IT" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nama Divisi</label>
                        <input type="text" name="nama_divisi" class="form-control" placeholder="Contoh: Teknologi Informasi" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-3 fw-bold text-uppercase shadow-sm">Simpan Divisi</button>
                </form>
            </div>
        </div>
    </div>

<div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-nowrap">
                        <thead class="table-light text-muted fs-3 text-uppercase fw-semibold tracking-wider">
                            <tr>
                                <th class="ps-4 py-3 border-bottom-0">Kode Departemen</th>
                                <th class="py-3 border-bottom-0">Nama Lengkap Divisi</th>
                                <th class="px-4 py-3 border-bottom-0 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($divisi as $d): ?>
                            <tr>
                                <td class="border-bottom-0 ps-4">
                                    <div class="badge bg-light-primary text-primary border border-primary border-opacity-25 font-monospace fs-3 px-3 py-1 rounded-pill mt-1 text-uppercase"><?= $d['kode_divisi'] ?></div>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-bold text-dark fs-4"><?= $d['nama_divisi'] ?></p>
                                </td>
                                <td class="border-bottom-0 text-end px-4">
                                    <a href="<?= base_url('master/divisi/delete/'.$d['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus divisi ini?')" class="btn btn-sm btn-light text-danger hover-danger px-2 shadow-sm border" data-bs-toggle="tooltip" title="Hapus Permanen">
                                        <i class="ti ti-trash fs-4"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($divisi)): ?>
                                <tr>
                                    <td colspan="3" class="text-center py-5">
                                        <i class="ti ti-building-off text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                                        <p class="text-muted fw-semibold mb-0">Belum ada data divisi tersedia.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h4 class="mb-1 fw-bold border-start border-primary border-4 ps-3">Manajemen Divisi</h4>
        <p class="text-muted ms-3 mb-0 mt-1 fs-3 italic">Konfigurasi struktur organisasi perusahaan.</p>
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
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle table-hover">
                        <thead class="text-dark fs-4 bg-light">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Kode</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Nama Divisi</h6>
                                </th>
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($divisi as $d): ?>
                            <tr>
                                <td class="border-bottom-0">
                                    <h6 class="fw-bold mb-0 text-primary font-monospace text-uppercase"><?= $d['kode_divisi'] ?></h6>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal text-dark"><?= $d['nama_divisi'] ?></p>
                                </td>
                                <td class="border-bottom-0 text-center">
                                    <a href="<?= base_url('master/divisi/delete/'.$d['id']) ?>" onclick="return confirm('Hapus divisi ini?')" class="btn btn-sm btn-outline-danger shadow-sm" title="Hapus">
                                        <i class="ti ti-trash"></i>
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
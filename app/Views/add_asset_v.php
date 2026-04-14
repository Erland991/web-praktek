<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row pt-3">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm border-0 border-top border-4 border-primary rounded-3">
            <div class="card-body p-4">
                <h4 class="card-title fw-bold text-dark mb-4"><i class="ti ti-square-plus me-2 text-primary"></i>Tambah Data Aset Digital</h4>
                
                <form action="<?= base_url('dashboard/save') ?>" method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nama Aset</label>
                        <input type="text" name="nama_aset" class="form-control" placeholder="Contoh: Server Jakarta" required>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="Software">Software</option>
                                <option value="Hardware">Hardware</option>
                                <option value="Server">Server</option>
                                <option value="Data">Data</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select">
                                <option value="Aktif">Aktif</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Non-Aktif">Non-Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">PIC (Penanggung Jawab)</label>
                        <input type="text" name="pic" class="form-control" placeholder="Nama Penanggung Jawab" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">Simpan Data</button>
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-light px-4 fw-semibold border">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
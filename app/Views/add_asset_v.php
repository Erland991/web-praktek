<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row pt-3">
    <div class="col-lg-8 mx-auto">
        <div class="hero-card shadow-lg mb-4 text-center" style="padding: 1.5rem !important;">
            <h4 class="mb-0 fs-6 fw-bold">Register Aset Baru</h4>
        </div>
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                
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

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Deskripsi Aset</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Jelaskan fungsi atau detail aset secara singkat..."></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm text-uppercase" style="letter-spacing: 1px;">Simpan Data</button>
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-light px-4 fw-bold border text-uppercase" style="letter-spacing: 1px;">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
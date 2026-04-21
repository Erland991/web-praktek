<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4 mt-3">
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm" style="background: linear-gradient(135deg, #065f46 0%, #10b981 100%);">
            <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle" style="width: 250px; height: 250px; transform: translate(30%, -30%);"></div>
            <div class="card-body p-4 p-xl-5 position-relative z-1 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <span class="badge bg-white bg-opacity-20 text-white mb-2 fs-2 fw-medium px-3 py-2 rounded-pill border border-white border-opacity-10"><i class="ti ti-folder me-1"></i> SIMPA Vault</span>
                    <h2 class="fw-bold text-white mb-2">Pusat Dokumen Proyek</h2>
                    <p class="mb-0 fs-4 text-white-50" style="max-width: 600px;">Cari dan unduh seluruh berkas pendukung progress aplikasi (Laporan, Bukti Implementasi, dll) secara terpusat.</p>
                </div>
                <div class="d-none d-md-block opacity-25">
                    <i class="ti ti-files text-white" style="font-size: 5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-4 mb-4 p-3 bg-white">
    <form action="" method="GET" class="row g-2 align-items-center">
        <div class="col-md-10">
            <div class="input-group input-group-lg rounded-3 shadow-none border">
                <span class="input-group-text bg-white border-0 text-muted"><i class="ti ti-search fs-5"></i></span>
                <input type="text" name="q" value="<?= $q ?? '' ?>" class="form-control border-0 ps-0 shadow-none bg-white" placeholder="Cari nama aplikasi atau keterangan dokumen yang dilampirkan...">
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-3 d-flex align-items-center justify-content-center h-100 border-2">CARI BERKAS</button>
        </div>
    </form>
</div>

<div class="row">
    <?php if(empty($documents)): ?>
        <div class="col-12 text-center py-5">
            <div class="bg-white p-5 rounded-4 shadow-sm italic text-muted border">
                Tidak ada dokumen yang ditemukan sesuai kriteria pencarian Anda.
            </div>
        </div>
    <?php endif; ?>

    <?php foreach($documents as $doc): ?>
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card h-100 border-0 shadow-sm text-center p-3 document-card">
            <div class="bg-light-primary rounded-3 py-4 mb-3">
                <i class="ti ti-file-text fs-9 text-primary"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1 text-truncate" title="<?= $doc['nama_app'] ?>"><?= $doc['nama_app'] ?></h6>
            <p class="text-muted fs-1 mb-3">Oleh: <?= $doc['pic_name'] ?></p>
            <p class="fs-2 text-dark mb-3 doc-desc" style="height: 40px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                <?= $doc['pesan_update'] ?>
            </p>
            <a href="<?= base_url('uploads/progress/'.$doc['file_lampiran']) ?>" class="btn btn-primary btn-sm w-100 fw-bold" target="_blank">
                <i class="ti ti-download me-1"></i> DOWNLOAD
            </a>
            <small class="text-muted fs-1 mt-2"><?= date('d/m/Y', strtotime($doc['tgl_update'])) ?></small>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<script>
    document.querySelector('input[name="q"]').addEventListener('input', function(e) {
        const keyword = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.document-card');
        
        cards.forEach(card => {
            const title = card.querySelector('h6').innerText.toLowerCase();
            const desc = card.querySelector('.doc-desc').innerText.toLowerCase();
            
            if (title.includes(keyword) || desc.includes(keyword)) {
                card.closest('.col-md-6').style.display = 'block';
            } else {
                card.closest('.col-md-6').style.display = 'none';
            }
        });
    });
</script>
<?= $this->endSection() ?>

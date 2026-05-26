<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <!-- Header Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4 bg-white d-flex justify-content-between align-items-center border-start border-5 border-primary">
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-1 rounded-pill fw-bold">
                    <i class="ti ti-users me-1"></i> Daftar Hadir
                </span>
                <h3 class="fw-bold text-dark mb-1"><?= isset($absensi['id']) ? 'Edit Daftar Hadir' : 'Buat Daftar Hadir' ?></h3>
                <p class="text-muted mb-0">Dokumen FP-MR10-01 Rev.02</p>
            </div>
            <div class="text-end">
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                    <i class="ti ti-file-text me-1 text-primary"></i> FP-MR10-01
                </span>
            </div>
        </div>
    </div>

    <form action="<?= base_url('absensi/save') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= $absensi['id'] ?? '' ?>">
        <input type="hidden" name="aplikasi_id" value="<?= $app_id ?>">
        
        <!-- Form Informasi Dasar -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-header bg-white border-bottom px-5 py-4">
                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 me-3">
                        <i class="ti ti-info-circle fs-4"></i>
                    </div>
                    Informasi Kegiatan
                </h5>
            </div>
            <div class="card-body p-5">
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <input type="text" name="acara" class="form-control border-2 bg-light rounded-3" id="acara" placeholder="Acara" value="<?= $absensi['acara'] ?? '' ?>" required>
                            <label for="acara" class="fw-bold text-muted">ACARA</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <input type="date" name="tanggal" class="form-control border-2 bg-light rounded-3" id="tanggal" value="<?= $absensi['tanggal'] ?? '' ?>" required>
                            <label for="tanggal" class="fw-bold text-muted">HARI/TANGGAL</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <input type="text" name="waktu" class="form-control border-2 bg-light rounded-3" id="waktu" placeholder="Waktu" value="<?= $absensi['waktu'] ?? '' ?>" required>
                            <label for="waktu" class="fw-bold text-muted">WAKTU</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <input type="text" name="tempat" class="form-control border-2 bg-light rounded-3" id="tempat" placeholder="Tempat" value="<?= $absensi['tempat'] ?? '' ?>" required>
                            <label for="tempat" class="fw-bold text-muted">TEMPAT</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Peserta -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-header bg-white border-bottom px-5 py-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 text-info p-2 rounded-3 me-3">
                        <i class="ti ti-users fs-4"></i>
                    </div>
                    Daftar Peserta Hadir
                </h5>
                <button type="button" class="btn btn-sm btn-outline-primary fw-bold rounded-pill px-3 py-2" onclick="addPeserta()">
                    <i class="ti ti-plus me-1"></i> Tambah Peserta
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="pesertaTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="5%">No.</th>
                                <th width="25%">NAMA</th>
                                <th width="25%">JABATAN - UNIT KERJA</th>
                                <th width="20%">HP/ext</th>
                                <th width="20%">EMAIL</th>
                                <th class="text-center" width="5%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="pesertaBody">
                            <?php if(!empty($absensi['peserta'])): ?>
                                <?php foreach($absensi['peserta'] as $index => $p): ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted row-number"><?= $index + 1 ?></td>
                                    <td><input type="text" name="peserta_nama[]" class="form-control form-control-sm border-2 rounded-3" value="<?= $p['nama'] ?? '' ?>" required></td>
                                    <td><input type="text" name="peserta_jabatan[]" class="form-control form-control-sm border-2 rounded-3" value="<?= $p['jabatan'] ?? '' ?>" required></td>
                                    <td><input type="text" name="peserta_hp[]" class="form-control form-control-sm border-2 rounded-3" value="<?= $p['hp'] ?? '' ?>"></td>
                                    <td><input type="email" name="peserta_email[]" class="form-control form-control-sm border-2 rounded-3" value="<?= $p['email'] ?? '' ?>"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-light-danger text-danger border-0 rounded-circle" onclick="removePeserta(this)" style="width:30px; height:30px; padding:0;">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted row-number">1</td>
                                    <td><input type="text" name="peserta_nama[]" class="form-control form-control-sm border-2 rounded-3" required></td>
                                    <td><input type="text" name="peserta_jabatan[]" class="form-control form-control-sm border-2 rounded-3" required></td>
                                    <td><input type="text" name="peserta_hp[]" class="form-control form-control-sm border-2 rounded-3"></td>
                                    <td><input type="email" name="peserta_email[]" class="form-control form-control-sm border-2 rounded-3"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-light-danger text-danger border-0 rounded-circle" onclick="removePeserta(this)" style="width:30px; height:30px; padding:0;">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 mb-5">
            <a href="<?= base_url('absensi/list') ?>" class="btn btn-light border-2 fw-bold px-4 rounded-pill">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary fw-bold px-5 rounded-pill shadow-sm" id="btnSubmit">
                <i class="ti ti-device-floppy me-2"></i> SIMPAN DAFTAR HADIR
            </button>
        </div>
    </form>
</div>

<script>
    function updateRowNumbers() {
        const rows = document.querySelectorAll('#pesertaBody tr');
        rows.forEach((row, index) => {
            row.querySelector('.row-number').innerText = index + 1;
        });
    }

    function addPeserta() {
        const tbody = document.getElementById('pesertaBody');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-center fw-bold text-muted row-number"></td>
            <td><input type="text" name="peserta_nama[]" class="form-control form-control-sm border-2 rounded-3" required></td>
            <td><input type="text" name="peserta_jabatan[]" class="form-control form-control-sm border-2 rounded-3" required></td>
            <td><input type="text" name="peserta_hp[]" class="form-control form-control-sm border-2 rounded-3"></td>
            <td><input type="email" name="peserta_email[]" class="form-control form-control-sm border-2 rounded-3"></td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-light-danger text-danger border-0 rounded-circle" onclick="removePeserta(this)" style="width:30px; height:30px; padding:0;">
                    <i class="ti ti-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
        updateRowNumbers();
    }

    function removePeserta(button) {
        const tbody = document.getElementById('pesertaBody');
        if (tbody.children.length > 1) {
            button.closest('tr').remove();
            updateRowNumbers();
        } else {
            alert('Minimal harus ada 1 peserta!');
        }
    }
</script>

<?= $this->endSection() ?>

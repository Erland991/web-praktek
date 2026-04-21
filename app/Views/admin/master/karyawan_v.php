<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4 mt-3">
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden position-relative shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle" style="width: 250px; height: 250px; transform: translate(30%, -30%);"></div>
            <div class="card-body p-4 p-xl-5 position-relative z-1 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <span class="badge bg-white bg-opacity-10 text-white mb-2 fs-2 fw-medium px-3 py-2 rounded-pill border border-white border-opacity-10"><i class="ti ti-users me-1"></i> SIMPA Master Data</span>
                    <h2 class="fw-bold text-white mb-2">Manajemen Karyawan</h2>
                    <p class="mb-0 fs-4 text-white-50" style="max-width: 600px;">Kelola daftar personil, hak akses sistem (RBAC), dan pembagian divisi secara terpusat.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="<?= base_url('master/karyawan/export') . '?' . http_build_query(['keyword' => $keyword ?? '']) ?>" class="btn btn-outline-light text-white fw-bold d-inline-flex align-items-center shadow-sm px-4 py-2 rounded-3" target="_blank" style="background: rgba(220,53,69,0.2);">
                        <i class="ti ti-file-type-pdf fs-5 me-2 text-danger"></i> Cetak PDF
                    </a>
                    <?php if (session()->get('role') == 'Admin') : ?>
                    <button type="button" class="btn btn-light text-primary fw-bold d-inline-flex align-items-center shadow-sm px-4 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="ti ti-user-plus fs-5 me-2"></i> Tambah Karyawan
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body p-3">
                <form action="<?= base_url('master/karyawan') ?>" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group input-group-sm rounded-3 shadow-none border">
                            <span class="input-group-text bg-white border-0 text-muted"><i class="ti ti-search fs-5"></i></span>
                            <input type="text" name="keyword" class="form-control border-0 ps-0 shadow-none py-2" placeholder="Cari nama, NIP, atau username..." value="<?= $keyword ?? '' ?>">
                        </div>
                    </div>
                    <div class="col-md-auto d-flex gap-2 mt-3 mt-md-0">
                        <button type="submit" class="btn btn-primary px-4 rounded-3 d-flex align-items-center fw-medium">
                            <i class="ti ti-filter me-1"></i> Cari
                        </button>
                        <a href="<?= base_url('master/karyawan') ?>" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('sukses')) : ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="ti ti-circle-check fs-5 me-2"></i>
        <?= session()->getFlashdata('sukses') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="ti ti-alert-triangle fs-5 me-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="table-light text-muted fs-3 text-uppercase fw-semibold tracking-wider">
                    <tr>
                        <th class="ps-4 py-3 border-bottom-0 w-10">No</th>
                        <th class="py-3 border-bottom-0">NIP & Nama</th>
                        <th class="py-3 border-bottom-0">Username Akses</th>
                        <th class="py-3 border-bottom-0 text-center">Role Akses</th>
                        <th class="py-3 border-bottom-0 text-center">Penempatan Divisi</th>
                        <?php if (session()->get('role') == 'Admin') : ?>
                        <th class="px-4 py-3 border-bottom-0 text-center">Aksi Lanjutan</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($karyawan as $k) : ?>
                    <tr>
                        <td class="border-bottom-0 ps-4 text-center">
                            <span class="text-muted fw-semibold"><?= str_pad($no++, 2, '0', STR_PAD_LEFT) ?></span>
                        </td>
                        <td class="border-bottom-0">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm d-flex align-items-center justify-content-center rounded-circle bg-light-primary text-primary border border-primary border-opacity-10 fw-bold me-3" style="width: 40px; height: 40px;">
                                    <?= substr(strtoupper(esc($k['nama_lengkap'])), 0, 1) ?>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark"><?= $k['nama_lengkap'] ?></h6>
                                    <small class="text-muted d-block mt-1 font-monospace">ID: <?= $k['nip'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-normal"><?= $k['username'] ?></p>
                        </td>
                        <td class="border-bottom-0 text-center">
                            <?php 
                                $badgeClass = 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25';
                                if ($k['role'] == 'Admin') $badgeClass = 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25';
                                elseif ($k['role'] == 'Viewer') $badgeClass = 'bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25';
                            ?>
                            <span class="badge <?= $badgeClass ?> px-3 py-1 rounded-pill fw-semibold d-inline-flex gap-1 align-items-center">
                                <?= $k['role'] ?>
                            </span>
                        </td>
                        <td class="border-bottom-0 text-center">
                            <?php if (!empty($k['divisi'])) : ?>
                                <span class="badge bg-light text-dark border border-secondary border-opacity-25 px-2 py-1 rounded-pill shadow-none fst-normal fw-medium"><?= $k['divisi'] ?></span>
                            <?php else : ?>
                                <span class="badge bg-light-secondary text-muted border border-secondary border-opacity-25 px-2 py-1 rounded-pill shadow-none fst-italic">Belum diatur</span>
                            <?php endif; ?>
                        </td>
                        <?php if (session()->get('role') == 'Admin') : ?>
                        <td class="border-bottom-0 text-end px-4">
                            <div class="d-flex gap-1 justify-content-end">
                                <button type="button" onclick='editKaryawan(<?= json_encode($k) ?>)' class="btn btn-sm btn-light text-primary hover-primary px-2" data-bs-toggle="tooltip" title="Edit Data Karyawan">
                                    <i class="ti ti-pencil fs-4"></i>
                                </button>
                                <a href="<?= base_url('master/karyawan/delete/'.$k['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini secara permanen?')" class="btn btn-sm btn-light text-danger hover-danger px-2" data-bs-toggle="tooltip" title="Hapus Permanen">
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
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white p-4">
                <h5 class="modal-title fw-bold text-uppercase tracking-wider fs-3" id="modalTambahLabel">Karyawan Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('master/karyawan/save') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIP</label>
                            <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="User">User</option>
                                <option value="Admin">Admin</option>
                                <option value="Viewer">Viewer (Read-Only)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Divisi</label>
                            <select name="divisi" class="form-select" required>
                                <option value="">Pilih Divisi</option>
                                <?php foreach($list_divisi as $d): ?>
                                    <option value="<?= $d['nama_divisi'] ?>"><?= $d['nama_divisi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold text-uppercase">Simpan Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-secondary text-white p-4">
                <h5 class="modal-title fw-bold text-uppercase tracking-wider fs-3" id="modalEditLabel">Edit Karyawan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIP</label>
                            <input type="text" name="nip" id="edit_nip" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text" name="username" id="edit_username" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Role</label>
                            <select name="role" id="edit_role" class="form-select">
                                <option value="User">User</option>
                                <option value="Admin">Admin</option>
                                <option value="Viewer">Viewer (Read-Only)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Divisi</label>
                            <select name="divisi" id="edit_divisi" class="form-select">
                                <?php foreach($list_divisi as $d): ?>
                                    <option value="<?= $d['nama_divisi'] ?>"><?= $d['nama_divisi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="p-3 rounded-3 bg-light-warning border border-warning shadow-sm">
                                <label class="form-label fw-bold text-warning text-uppercase mb-1 fs-1">Ganti Password</label>
                                <p class="text-muted fs-2 mb-2 italic">Kosongkan jika tidak ingin mengubah password.</p>
                                <input type="password" name="password" class="form-control" placeholder="Password Baru">
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-secondary w-100 py-3 fw-bold text-uppercase">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editKaryawan(data) {
        const modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
        document.getElementById('formEdit').action = '<?= base_url('master/karyawan/update') ?>/' + data.id;
        document.getElementById('edit_nama').value = data.nama_lengkap;
        document.getElementById('edit_nip').value = data.nip;
        document.getElementById('edit_username').value = data.username;
        document.getElementById('edit_role').value = data.role;
        document.getElementById('edit_divisi').value = data.divisi;
        modalEdit.show();
    }
</script>
<?= $this->endSection() ?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h4 class="mb-1 fw-bold border-start border-primary border-4 ps-3">Manajemen Karyawan</h4>
        <p class="text-muted ms-3 mb-0 mt-1 fs-3 italic">Daftar personil dan hak akses sistem monitoring.</p>
    </div>
    <div class="col-md-4 text-end mt-3 mt-md-0">
        <button type="button" class="btn btn-primary d-inline-flex align-items-center shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="ti ti-user-plus fs-5 me-2"></i> Tambah Karyawan
        </button>
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

<div class="card w-100 shadow-sm border-0">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle table-hover">
                <thead class="text-dark fs-4 bg-light">
                    <tr>
                        <th class="border-bottom-0 w-10">
                            <h6 class="fw-semibold mb-0 text-center">No</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">NIP & Nama</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Username</h6>
                        </th>
                        <th class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">Role</h6>
                        </th>
                        <th class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">Divisi</h6>
                        </th>
                        <th class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">Aksi</h6>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($karyawan as $k) : ?>
                    <tr>
                        <td class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0 text-muted"><?= str_pad($no++, 2, '0', STR_PAD_LEFT) ?></h6>
                        </td>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1 text-primary"><?= $k['nama_lengkap'] ?></h6>
                            <span class="fw-bold font-monospace text-muted fs-2 text-uppercase"><?= $k['nip'] ?></span>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-normal"><?= $k['username'] ?></p>
                        </td>
                        <td class="border-bottom-0 text-center">
                            <span class="badge <?= $k['role'] == 'Admin' ? 'bg-light-secondary text-secondary' : 'bg-light-primary text-primary' ?> fw-semibold px-3 py-2 rounded-pill">
                                <?= $k['role'] ?>
                            </span>
                        </td>
                        <td class="border-bottom-0 text-center">
                            <?php if (!empty($k['divisi'])) : ?>
                                <span class="badge bg-light text-dark border fw-medium px-3 py-2"><?= $k['divisi'] ?></span>
                            <?php else : ?>
                                <span class="text-muted fs-2 italic">Belum diatur</span>
                            <?php endif; ?>
                        </td>
                        <td class="border-bottom-0 text-center">
                            <button type="button" onclick='editKaryawan(<?= json_encode($k) ?>)' class="btn btn-sm btn-outline-primary shadow-sm" title="Edit">
                                <i class="ti ti-edit"></i>
                            </button>
                            <a href="<?= base_url('master/karyawan/delete/'.$k['id']) ?>" onclick="return confirm('Hapus karyawan ini?')" class="btn btn-sm btn-outline-danger shadow-sm ms-1" title="Hapus">
                                <i class="ti ti-trash"></i>
                            </a>
                        </td>
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
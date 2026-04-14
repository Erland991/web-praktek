<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h4 class="mb-1 fw-bold border-start border-primary border-4 ps-3">Monitoring Progres Aplikasi</h4>
        <p class="text-muted ms-3 mb-0 mt-1 fs-3">Selamat datang kembali di portal manajemen aset teknologi informasi.</p>
    </div>
    <div class="col-md-4 text-end mt-3 mt-md-0">
        <?php if (session()->get('role') == 'Admin') : ?>
            <a href="<?= base_url('dashboard/add') ?>" class="btn btn-primary d-inline-flex align-items-center shadow-sm">
                <i class="ti ti-plus fs-5 me-2"></i> Tambah Aset Baru
            </a>
        <?php endif; ?>
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
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="card-title fw-semibold mb-0"><i class="fas fa-database text-primary me-2"></i>Daftar Inventaris Aplikasi</h5>
        <span class="badge bg-light-primary text-primary px-3 py-2 fw-semibold rounded-pill">Total: <?= count($semua_aset) ?> Aset</span>
    </div>
    
    <div class="table-responsive">
      <table class="table text-nowrap mb-0 align-middle table-hover">
        <thead class="text-dark fs-4 bg-light">
          <tr>
            <th class="border-bottom-0 w-10">
              <h6 class="fw-semibold mb-0 text-center">No</h6>
            </th>
            <th class="border-bottom-0">
              <h6 class="fw-semibold mb-0">Detail Aplikasi</h6>
            </th>
            <th class="border-bottom-0">
              <h6 class="fw-semibold mb-0 text-center">Kategori</h6>
            </th>
            <th class="border-bottom-0">
              <h6 class="fw-semibold mb-0">PIC</h6>
            </th>
            <th class="border-bottom-0 text-center">
              <h6 class="fw-semibold mb-0">Status</h6>
            </th>
            <?php if (session()->get('role') == 'Admin') : ?>
            <th class="border-bottom-0 text-center">
              <h6 class="fw-semibold mb-0">Aksi</h6>
            </th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($semua_aset as $a) : ?>
            <tr>
              <td class="border-bottom-0 text-center"><h6 class="fw-semibold mb-0"><?= str_pad($no++, 2, '0', STR_PAD_LEFT) ?></h6></td>
              <td class="border-bottom-0">
                  <h6 class="fw-semibold mb-1 text-primary"><?= $a['nama_aset'] ?></h6>
                  <span class="fw-normal text-muted fs-3">Asset-ID: #<?= $a['id'] ?></span>                          
              </td>
              <td class="border-bottom-0 text-center">
                <span class="badge bg-light text-dark rounded-3 fw-semibold border border-secondary px-2 py-1"><?= $a['kategori'] ?></span>
              </td>
              <td class="border-bottom-0">
                <div class="d-flex align-items-center gap-2">
                    <span class="round-8 bg-primary rounded-circle d-inline-block"></span>
                    <p class="mb-0 fw-normal"><?= $a['pic'] ?></p>
                </div>
              </td>
              <td class="border-bottom-0 text-center">
                <?php if ($a['status'] == 'Aktif') : ?>
                    <span class="badge bg-light-success text-success fw-semibold"><i class="ti ti-circle-filled fs-2 me-1"></i>Online</span>
                <?php else : ?>
                    <span class="badge bg-light-warning text-warning fw-semibold"><i class="ti ti-circle-filled fs-2 me-1"></i>Maintenance</span>
                <?php endif; ?>
              </td>
              <?php if (session()->get('role') == 'Admin') : ?>
              <td class="border-bottom-0 text-center">
                <a href="<?= base_url('dashboard/edit/' . $a['id']) ?>" class="btn btn-sm btn-outline-primary shadow-sm" data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit"></i></a>
                <a href="<?= base_url('dashboard/delete/' . $a['id']) ?>" onclick="return confirm('Hapus aset aplikasi ini?')" class="btn btn-sm btn-outline-danger shadow-sm ms-1" data-bs-toggle="tooltip" title="Hapus"><i class="ti ti-trash"></i></a>
              </td>
              <?php endif; ?>
            </tr> 
            <?php endforeach; ?>
            
            <?php if (empty($semua_aset)) : ?>
            <tr>
                <td colspan="6" class="text-center py-5">
                    <i class="ti ti-folder-off text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                    <p class="text-muted fw-semibold mb-0">Data inventaris masih kosong.</p>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
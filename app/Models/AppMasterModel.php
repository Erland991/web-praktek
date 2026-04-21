<?php

namespace App\Models;

use CodeIgniter\Model;

class AppMasterModel extends Model
{
    protected $table            = 'aplikasi_master';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_app', 'pic_id', 'divisi_id', 'status', 'deskripsi', 'tgl_mulai', 'tgl_target', 'versi_current', 'created_at', 'updated_at'];
    protected $useTimestamps    = true;
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class CobitModel extends Model
{
    protected $table            = 'master_cobit_19';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['domain', 'kode_proses', 'nama_proses', 'deskripsi', 'tujuan_audit', 'created_at'];
    protected $useTimestamps    = false;
}

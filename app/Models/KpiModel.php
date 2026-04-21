<?php

namespace App\Models;

use CodeIgniter\Model;

class KpiModel extends Model
{
    protected $table            = 'master_kpi';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_kpi', 'target', 'satuan', 'tahun', 'divisi_id', 'created_at'];
    protected $useTimestamps    = false;
}

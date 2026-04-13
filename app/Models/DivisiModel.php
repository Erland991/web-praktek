<?php

namespace App\Models;

use CodeIgniter\Model;

class DivisiModel extends Model
{
    protected $table      = 'divisi'; // Sesuaikan dengan nama tabel di database kamu
    protected $primaryKey = 'id';
    // PENTING: nama_divisi harus ada di sini
    protected $allowedFields = ['nama_divisi', 'kode_divisi'];
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetModel extends Model
{
    protected $table            = 'aset'; // Nama tabel di database
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Kolom yang boleh diisi saat Tambah/Edit Aset
    protected $allowedFields    = ['nama_aset', 'kategori', 'status', 'pic', 'deskripsi'];

    // Aktifkan pencatatan waktu otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validasi agar data aset PT Surveyor Indonesia tetap rapi
    protected $validationRules = [
        'nama_aset' => 'required|min_length[3]',
        'kategori'  => 'required',
        'status'    => 'required',
        'pic'       => 'required'
    ];

    protected $validationMessages = [
        'nama_aset' => [
            'required' => 'Nama aplikasi/aset harus diisi.',
            'min_length' => 'Nama aset minimal 3 karakter.'
        ]
    ];
}
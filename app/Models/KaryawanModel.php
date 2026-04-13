<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{
    // 1. Sesuaikan nama tabel (tadi di migration kita buat 'karyawan')
    protected $table            = 'karyawan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // 2. WAJIB DIISI: Kolom yang boleh diinsert/update
    protected $allowedFields    = ['nik', 'nama', 'divisi_id', 'jabatan'];

    // 3. Aktifkan Timestamps karena di migration kita buat created_at & updated_at
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // 4. Tambahkan validasi dasar supaya data karyawan PT Surveyor Indonesia valid
    protected $validationRules = [
        'nik'       => 'required|is_unique[karyawan.nik,id,{id}]|min_length[5]',
        'nama'      => 'required|min_length[3]',
        'divisi_id' => 'required|is_natural_no_zero',
        'jabatan'   => 'required'
    ];

    protected $validationMessages = [
        'nik' => [
            'is_unique' => 'NIK ini sudah terdaftar di sistem.',
            'required'  => 'NIK wajib diisi.'
        ]
    ];
}
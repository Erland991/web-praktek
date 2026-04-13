<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Nama tabel di database kamu
    protected $table            = 'users'; 
    
    // Primary key tabel
    protected $primaryKey       = 'id';
    
    // Pastikan ID otomatis bertambah
    protected $useAutoIncrement = true;
    
    // Hasil query akan berupa array
    protected $returnType       = 'array';
    
    /**
     * allowedFields: Daftar kolom yang diizinkan untuk diisi.
     * PENTING: Jika kolom 'divisi' tidak ada di sini, data divisi tidak akan masuk ke DB.
     */
    protected $allowedFields = [
        'nip', 
        'nama_lengkap', 
        'username', 
        'password', 
        'role', 
        'divisi'
    ];

    /**
     * Timestamps: Jika di tabelmu ada kolom created_at dan updated_at, 
     * ubah menjadi true. Jika tidak ada, biarkan false agar tidak error.
     */
    protected $useTimestamps = false; 
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Validation Rules: 
     * Saya kosongkan dulu supaya data PASTI MASUK. 
     * Setelah sistem jalan, baru kita isi lagi untuk keamanan.
     */
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = true;
}
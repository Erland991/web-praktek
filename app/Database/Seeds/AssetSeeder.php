<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AssetSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_aset' => 'SIMPA - Project Management',
                'kategori'  => 'Web Application',
                'status'    => 'Production',
                'pic'       => 'Administrator SI',
                'deskripsi' => 'Aplikasi Utama Manajemen Proyek PT Surveyor Indonesia.',
            ],
            [
                'nama_aset' => 'E-Office SI',
                'kategori'  => 'Enterprise System',
                'status'    => 'Maintenance',
                'pic'       => 'User Project',
                'deskripsi' => 'Sistem administrasi perkantoran elektronik.',
            ],
            [
                'nama_aset' => 'Asset Tracker Mobile',
                'kategori'  => 'Mobile App',
                'status'    => 'Development',
                'pic'       => 'Teknologi Informasi',
                'deskripsi' => 'Aplikasi pelacakan aset berbasis Android/iOS.',
            ],
        ];

        $this->db->table('aset')->insertBatch($data);
    }
}

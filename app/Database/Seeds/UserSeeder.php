<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nip'          => '123456',
                'nama_lengkap' => 'Administrator SI',
                'username'     => 'admin',
                'password'     => password_hash('admin123', PASSWORD_DEFAULT),
                'role'         => 'Admin',
                'divisi'       => 'Teknologi Informasi',
            ],
            [
                'nip'          => '654321',
                'nama_lengkap' => 'User Project',
                'username'     => 'user',
                'password'     => password_hash('user123', PASSWORD_DEFAULT),
                'role'         => 'User',
                'divisi'       => 'Infrastruktur',
            ],
        ];

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}

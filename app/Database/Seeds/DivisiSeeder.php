<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DivisiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['kode_divisi' => 'MO',  'nama_divisi' => 'Mineral & Batubara'],
            ['kode_divisi' => 'OG',  'nama_divisi' => 'Minyak & Gas Bumi'],
            ['kode_divisi' => 'PI',  'nama_divisi' => 'Infrastruktur'],
            ['kode_divisi' => 'IK',  'nama_divisi' => 'Institusi & Kelembagaan'],
            ['kode_divisi' => 'LIG', 'nama_divisi' => 'Lingkungan'],
            ['kode_divisi' => 'TI',  'nama_divisi' => 'Teknologi Informasi'],
            ['kode_divisi' => 'SDM', 'nama_divisi' => 'Sumber Daya Manusia'],
            ['kode_divisi' => 'KEU', 'nama_divisi' => 'Keuangan'],
        ];

        foreach ($data as $d) {
            $this->db->table('divisi')->insert($d);
        }
    }
}
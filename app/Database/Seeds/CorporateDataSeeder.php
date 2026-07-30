<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CorporateDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Divisi PT Surveyor Indonesia
        $this->db->table('divisi')->emptyTable();
        $divisiData = [
            ['kode_divisi' => 'DTI', 'nama_divisi' => 'Teknologi Informasi'],
            ['kode_divisi' => 'DAK', 'nama_divisi' => 'Akuntansi & Keuangan'],
            ['kode_divisi' => 'SDM', 'nama_divisi' => 'Sumber Daya Manusia'],
            ['kode_divisi' => 'DPB', 'nama_divisi' => 'Pengembangan Bisnis'],
            ['kode_divisi' => 'DOP', 'nama_divisi' => 'Operasi'],
            ['kode_divisi' => 'SEC', 'nama_divisi' => 'Sekretariat Perusahaan'],
            ['kode_divisi' => 'HUK', 'nama_divisi' => 'Hukum (Legal)'],
            ['kode_divisi' => 'PENG', 'nama_divisi' => 'Pengadaan (Procurement)']
        ];
        $this->db->table('divisi')->insertBatch($divisiData);

        // Fetch divisi to get correct IDs
        $divisi = $this->db->table('divisi')->get()->getResultArray();
        $ti_id = 1; $sdm_id = 3; $peng_id = 8; $sec_id = 6; $dop_id = 5; $dak_id = 2; $dpb_id = 4;
        foreach($divisi as $d) {
            if($d['kode_divisi'] == 'DTI') $ti_id = $d['id'];
            if($d['kode_divisi'] == 'SDM') $sdm_id = $d['id'];
            if($d['kode_divisi'] == 'PENG') $peng_id = $d['id'];
            if($d['kode_divisi'] == 'SEC') $sec_id = $d['id'];
            if($d['kode_divisi'] == 'DOP') $dop_id = $d['id'];
            if($d['kode_divisi'] == 'DAK') $dak_id = $d['id'];
            if($d['kode_divisi'] == 'DPB') $dpb_id = $d['id'];
        }

        // 2. Seed Users (instead of karyawan) - DO NOT EMPTY TABLE
        $userData = [
            ['nip' => 'SI10001', 'nama_lengkap' => 'Budi Santoso', 'username' => 'budi', 'password' => password_hash('budi123', PASSWORD_BCRYPT), 'role' => 'User', 'divisi' => 'Teknologi Informasi', 'photo' => null],
            ['nip' => 'SI10002', 'nama_lengkap' => 'Siti Aminah', 'username' => 'siti', 'password' => password_hash('siti123', PASSWORD_BCRYPT), 'role' => 'User', 'divisi' => 'Teknologi Informasi', 'photo' => null],
        ];
        
        // Cek if Budi already exists
        $cekBudi = $this->db->table('users')->where('username', 'budi')->countAllResults();
        if ($cekBudi == 0) {
            $this->db->table('users')->insertBatch($userData);
        }
        
        $users = $this->db->table('users')->get()->getResultArray();
        $user_id_1 = null; $user_id_2 = null;
        if(count($users) > 0) {
            $user_id_1 = $users[0]['id']; // Fallback to first user
            $user_id_2 = count($users) > 1 ? $users[1]['id'] : $user_id_1;
            foreach($users as $u) {
                if($u['username'] == 'budi') $user_id_1 = $u['id'];
                if($u['username'] == 'siti') $user_id_2 = $u['id'];
            }
        }

        // 3. Seed KPI
        $this->db->table('master_kpi')->emptyTable();
        $kpiData = [
            ['nama_kpi' => 'Uptime Server & Aplikasi Utama', 'target' => '99.9', 'satuan' => '%', 'tahun' => '2026', 'divisi_id' => $ti_id, 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kpi' => 'Kecepatan Penanganan Tiket IT (SLA)', 'target' => '90', 'satuan' => '%', 'tahun' => '2026', 'divisi_id' => $ti_id, 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kpi' => 'Penyelesaian Proyek IT Tepat Waktu', 'target' => '85', 'satuan' => '%', 'tahun' => '2026', 'divisi_id' => $ti_id, 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kpi' => 'Tingkat Ketersediaan Backup Data', 'target' => '100', 'satuan' => '%', 'tahun' => '2026', 'divisi_id' => $ti_id, 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kpi' => 'Tingkat Keamanan Siber (Security Score)', 'target' => '95', 'satuan' => 'Poin', 'tahun' => '2026', 'divisi_id' => $ti_id, 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kpi' => 'Tingkat Kepuasan Layanan IT', 'target' => '4.5', 'satuan' => 'Skala 5', 'tahun' => '2026', 'divisi_id' => $ti_id, 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kpi' => 'Pencapaian Pendapatan Divisi', 'target' => '100', 'satuan' => '%', 'tahun' => '2026', 'divisi_id' => $dop_id, 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('master_kpi')->insertBatch($kpiData);

        // 4. Seed Aplikasi Master
        $this->db->table('aplikasi_master')->emptyTable();
        $appMasterData = [
            ['nama_app' => 'SIMPA', 'pic_id' => $user_id_1, 'divisi_id' => $ti_id, 'status' => 'Production', 'deskripsi' => 'Sistem Informasi Manajemen Proyek Aplikasi PT Surveyor Indonesia', 'tgl_mulai' => '2025-01-01', 'tgl_target' => '2026-07-31', 'versi_current' => '1.0.0', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_app' => 'HCIS (Human Capital)', 'pic_id' => $user_id_2, 'divisi_id' => $sdm_id, 'status' => 'Production', 'deskripsi' => 'Human Capital Information System untuk rekrutmen dan penggajian', 'tgl_mulai' => '2024-05-10', 'tgl_target' => '2025-12-31', 'versi_current' => '2.1.4', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_app' => 'E-Procurement Surveyor', 'pic_id' => $user_id_1, 'divisi_id' => $peng_id, 'status' => 'Development', 'deskripsi' => 'Aplikasi tender dan pengadaan barang/jasa perusahaan', 'tgl_mulai' => '2026-01-15', 'tgl_target' => '2026-10-30', 'versi_current' => '0.5.0', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_app' => 'Nadine (Naskah Dinas Elektronik)', 'pic_id' => $user_id_2, 'divisi_id' => $sec_id, 'status' => 'Production', 'deskripsi' => 'Aplikasi persuratan digital terpusat BUMN', 'tgl_mulai' => '2023-08-20', 'tgl_target' => '2024-01-01', 'versi_current' => '3.0.1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_app' => 'M-Survey Mobile', 'pic_id' => $user_id_1, 'divisi_id' => $dop_id, 'status' => 'Development', 'deskripsi' => 'Aplikasi mobile untuk surveyor lapangan terintegrasi GPS', 'tgl_mulai' => '2026-03-01', 'tgl_target' => '2026-12-15', 'versi_current' => '0.8.2', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_app' => 'SIMKeu Terpadu', 'pic_id' => $user_id_2, 'divisi_id' => $dak_id, 'status' => 'Maintenance', 'deskripsi' => 'Sistem Informasi Keuangan dan Akuntansi', 'tgl_mulai' => '2022-01-01', 'tgl_target' => '2022-12-31', 'versi_current' => '5.2.0', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_app' => 'Aplikasi Pemasaran SFA', 'pic_id' => null, 'divisi_id' => $dpb_id, 'status' => 'Development', 'deskripsi' => 'Sales Force Automation untuk Divisi Pengembangan Bisnis', 'tgl_mulai' => '2026-05-01', 'tgl_target' => '2027-01-01', 'versi_current' => '0.1.0', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        ];
        $this->db->table('aplikasi_master')->insertBatch($appMasterData);
        
        $simpa_id = 1;
        $app_master = $this->db->table('aplikasi_master')->get()->getResultArray();
        foreach($app_master as $a) {
            if($a['nama_app'] == 'SIMPA') $simpa_id = $a['id'];
        }

        // 5. Seed Aset (Dashboard Cards)
        $this->db->table('aset')->emptyTable();
        $asetData = [
            // Keuangan (5)
            ['nama_aset' => 'SIMKeu Terpadu', 'kategori' => 'Aplikasi Keuangan', 'status' => 'Aktif', 'pic' => 'Siti Aminah', 'deskripsi' => 'Sistem Informasi Keuangan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_aset' => 'e-Billing System', 'kategori' => 'Aplikasi Keuangan', 'status' => 'Aktif', 'pic' => 'Budi Santoso', 'deskripsi' => 'Sistem Penagihan Elektronik', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_aset' => 'Tax Management', 'kategori' => 'Aplikasi Keuangan', 'status' => 'Maintenance', 'pic' => 'Siti Aminah', 'deskripsi' => 'Manajemen Pajak Perusahaan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_aset' => 'Payroll System', 'kategori' => 'Aplikasi Keuangan', 'status' => 'Aktif', 'pic' => 'Siti Aminah', 'deskripsi' => 'Sistem Penggajian Karyawan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_aset' => 'Budgeting App', 'kategori' => 'Aplikasi Keuangan', 'status' => 'Development', 'pic' => 'Budi Santoso', 'deskripsi' => 'Aplikasi Penyusunan Anggaran', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

            // Manajemen (4)
            ['nama_aset' => 'SIMPA', 'kategori' => 'Aplikasi Manajemen', 'status' => 'Aktif', 'pic' => 'Budi Santoso', 'deskripsi' => 'Manajemen Proyek Aplikasi', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_aset' => 'Risk Management', 'kategori' => 'Aplikasi Manajemen', 'status' => 'Aktif', 'pic' => 'Siti Aminah', 'deskripsi' => 'Sistem Manajemen Risiko', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_aset' => 'Asset Tracker', 'kategori' => 'Aplikasi Manajemen', 'status' => 'Maintenance', 'pic' => 'Budi Santoso', 'deskripsi' => 'Pelacakan Aset Fisik', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_aset' => 'Document Controller', 'kategori' => 'Aplikasi Manajemen', 'status' => 'Aktif', 'pic' => 'Siti Aminah', 'deskripsi' => 'Pengendali Dokumen Mutu', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

            // Mobile (3)
            ['nama_aset' => 'M-Survey', 'kategori' => 'Aplikasi Mobile', 'status' => 'Maintenance', 'pic' => 'Budi Santoso', 'deskripsi' => 'Mobile Field Survey', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_aset' => 'MySurveyor App', 'kategori' => 'Aplikasi Mobile', 'status' => 'Aktif', 'pic' => 'Siti Aminah', 'deskripsi' => 'Aplikasi Employee Self Service', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_aset' => 'Sales Force Mobile', 'kategori' => 'Aplikasi Mobile', 'status' => 'Development', 'pic' => 'Budi Santoso', 'deskripsi' => 'Aplikasi Tenaga Penjualan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

            // Pengadaan (2)
            ['nama_aset' => 'E-Procurement Surveyor', 'kategori' => 'Aplikasi Pengadaan', 'status' => 'Maintenance', 'pic' => 'Budi Santoso', 'deskripsi' => 'Sistem Lelang / Tender', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama_aset' => 'Vendor Management', 'kategori' => 'Aplikasi Pengadaan', 'status' => 'Aktif', 'pic' => 'Siti Aminah', 'deskripsi' => 'Manajemen Data Vendor', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

            // Perkantoran (1)
            ['nama_aset' => 'Nadine', 'kategori' => 'Aplikasi Perkantoran', 'status' => 'Aktif', 'pic' => 'Siti Aminah', 'deskripsi' => 'Naskah Dinas Elektronik', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
        ];
        $this->db->table('aset')->insertBatch($asetData);

        // 6. Seed Modul for SIMPA so the progress bar works
        if($this->db->tableExists('aplikasi_modul')) {
            $this->db->table('aplikasi_modul')->emptyTable();
            $modulData = [
                ['aplikasi_id' => $simpa_id, 'nama_modul' => 'Autentikasi & Otorisasi', 'bobot_kesulitan' => 10, 'persentase' => 100, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                ['aplikasi_id' => $simpa_id, 'nama_modul' => 'Dashboard Executive', 'bobot_kesulitan' => 20, 'persentase' => 100, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                ['aplikasi_id' => $simpa_id, 'nama_modul' => 'Master Data Management', 'bobot_kesulitan' => 30, 'persentase' => 100, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
                ['aplikasi_id' => $simpa_id, 'nama_modul' => 'Integrasi API Client', 'bobot_kesulitan' => 40, 'persentase' => 50, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]
            ];
            $this->db->table('aplikasi_modul')->insertBatch($modulData);
        }
        
        echo "Corporate Data (PT Surveyor Indonesia) seeded successfully!";
    }
}

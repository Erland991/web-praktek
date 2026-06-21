<?php

namespace App\Controllers;

class DatabaseSetup extends BaseController
{
    private $db;
    private $errors = [];

    /**
     * Helper: safely check if table exists
     */
    private function tableOk(string $table): bool
    {
        try {
            return $this->db->tableExists($table);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Helper: safely check if a column exists in a table
     */
    private function colOk(string $col, string $table): bool
    {
        try {
            if (!$this->tableOk($table)) return false;
            return $this->db->fieldExists($col, $table);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Helper: safely run a SQL query, log errors instead of throwing
     */
    private function run(string $sql, string $label = ''): bool
    {
        try {
            $this->db->simpleQuery($sql);
            return true;
        } catch (\Exception $e) {
            $msg = $label ? "$label: " . $e->getMessage() : $e->getMessage();
            $this->errors[] = $msg;
            echo "<li style='color:orange;'>⚠️ Dilewati: $msg</li>";
            return false;
        }
    }

    /**
     * Helper: safely add a column to a table if it doesn't exist
     */
    private function addCol(string $table, string $col, string $definition): void
    {
        if (!$this->tableOk($table)) return;
        if ($this->colOk($col, $table)) return;
        if ($this->run("ALTER TABLE {$table} ADD {$col} {$definition}", "addCol $table.$col")) {
            echo "<li>🛡️ Auto-Fix: Kolom <b>{$col}</b> ditambahkan ke <b>{$table}</b>.</li>";
        }
    }

    public function index()
    {
        $this->db = \Config\Database::connect();

        echo "<div style='font-family: sans-serif; padding: 40px;'>";
        echo "<h2>🔧 Sinkronisasi Database (Direct SQL Mode)</h2><hr><ul style='line-height: 2;'>";

        // ================================================================
        // STEP 0: Deteksi & Reset tabel yang corrupt ("doesn't exist in engine")
        // ================================================================
        $tables_to_check = [
            'aplikasi_master', 'aset', 'master_cobit_19', 'implementasi_data',
            'progres_log', 'system_logs', 'master_kpi', 'absensi_kehadiran',
            'users', 'divisi', 'aplikasi_modul', 'notula_rapat'
        ];
        foreach ($tables_to_check as $tbl) {
            try {
                $this->db->simpleQuery("SELECT 1 FROM {$tbl} LIMIT 1");
            } catch (\Exception $e) {
                if (strpos($e->getMessage(), "doesn't exist in engine") !== false) {
                    try {
                        $this->db->simpleQuery("DROP TABLE IF EXISTS {$tbl}");
                        echo "<li>⚠️ Tabel <b>{$tbl}</b> terdeteksi corrupt dan telah di-reset.</li>";
                    } catch (\Exception $e2) {}
                }
                // Jika tabel hanya belum ada, biarkan CREATE TABLE di bawah yang membuatnya
            }
        }

        // ================================================================
        // A. Tabel divisi
        // ================================================================
        if (!$this->tableOk('divisi')) {
            if ($this->run("CREATE TABLE divisi (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                kode_divisi VARCHAR(20) NULL,
                nama_divisi VARCHAR(255) NOT NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4", "Create divisi")) {
                try {
                    $this->db->table('divisi')->insertBatch([
                        ['kode_divisi' => 'IT',  'nama_divisi' => 'Teknologi Informasi'],
                        ['kode_divisi' => 'UM',  'nama_divisi' => 'Umum'],
                        ['kode_divisi' => 'HR',  'nama_divisi' => 'Sumber Daya Manusia'],
                        ['kode_divisi' => 'FIN', 'nama_divisi' => 'Keuangan'],
                        ['kode_divisi' => 'OPS', 'nama_divisi' => 'Operasional'],
                    ]);
                } catch (\Exception $e) {}
                echo "<li>✅ Tabel <b>divisi</b> dibuat.</li>";
            }
        }
        $this->addCol('divisi', 'kode_divisi', "VARCHAR(20) NULL AFTER id");

        // ================================================================
        // B. Tabel users
        // ================================================================
        if (!$this->tableOk('users')) {
            if ($this->run("CREATE TABLE users (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nip VARCHAR(50) NULL,
                nama_lengkap VARCHAR(255) NOT NULL,
                jenis_kelamin ENUM('L','P') DEFAULT 'L',
                username VARCHAR(100) NOT NULL,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(50) NOT NULL,
                divisi VARCHAR(100) NULL,
                divisi_id INT(11) NULL,
                photo VARCHAR(255) DEFAULT 'default.png',
                created_at DATETIME NULL,
                updated_at DATETIME NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4", "Create users")) {
                try {
                    $this->db->table('users')->insert([
                        'nip'          => '11111',
                        'nama_lengkap' => 'Administrator',
                        'username'     => 'admin',
                        'password'     => password_hash('admin123', PASSWORD_DEFAULT),
                        'role'         => 'Admin',
                        'divisi'       => 'Teknologi Informasi',
                        'created_at'   => date('Y-m-d H:i:s'),
                    ]);
                } catch (\Exception $e) {}
                echo "<li>✅ Tabel <b>users</b> dibuat. Default login: admin / admin123</li>";
            }
        }
        // Tambah kolom users yang mungkin kurang
        $this->addCol('users', 'jenis_kelamin', "ENUM('L','P') DEFAULT 'L' AFTER nama_lengkap");
        $this->addCol('users', 'divisi_id',     "INT(11) NULL");
        $this->addCol('users', 'nip',           "VARCHAR(50) NULL");
        $this->addCol('users', 'photo',         "VARCHAR(255) DEFAULT 'default.png'");
        $this->addCol('users', 'created_at',    "DATETIME NULL");
        $this->addCol('users', 'updated_at',    "DATETIME NULL");

        // ================================================================
        // C. Tabel aplikasi_modul
        // ================================================================
        if (!$this->tableOk('aplikasi_modul')) {
            $this->run("CREATE TABLE aplikasi_modul (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                aplikasi_id INT(11) UNSIGNED NOT NULL,
                nama_modul VARCHAR(255) NOT NULL,
                bobot_kesulitan INT(11) DEFAULT 1,
                persentase INT(11) DEFAULT 0,
                status ENUM('Pending','In Progress','Done') DEFAULT 'Pending',
                tgl_mulai DATE NULL,
                tgl_target DATE NULL,
                created_at DATETIME NULL,
                updated_at DATETIME NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4", "Create aplikasi_modul");
            echo "<li>✅ Tabel <b>aplikasi_modul</b> dibuat.</li>";
        }
        $this->addCol('aplikasi_modul', 'created_at', "DATETIME NULL");
        $this->addCol('aplikasi_modul', 'updated_at', "DATETIME NULL");

        // ================================================================
        // D. Tabel notula_rapat
        // ================================================================
        if (!$this->tableOk('notula_rapat')) {
            $this->run("CREATE TABLE notula_rapat (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                aplikasi_id INT(11) UNSIGNED NULL,
                user_id INT(11) UNSIGNED NOT NULL,
                no_dokumen VARCHAR(100) NULL,
                revisi VARCHAR(50) NULL,
                tgl_revisi DATE NULL,
                tanggal DATE NOT NULL,
                tempat VARCHAR(255) NOT NULL,
                agenda VARCHAR(255) NULL,
                peserta TEXT NULL,
                hasil_pembahasan TEXT NULL,
                nama_disiapkan VARCHAR(100) NULL,
                jabatan_disiapkan VARCHAR(100) NULL,
                nama_setuju1 VARCHAR(100) NULL,
                jabatan_setuju1 VARCHAR(100) NULL,
                is_approved1 TINYINT(1) DEFAULT 0,
                nama_setuju2 VARCHAR(100) NULL,
                jabatan_setuju2 VARCHAR(100) NULL,
                is_approved2 TINYINT(1) DEFAULT 0,
                is_final TINYINT(1) DEFAULT 0,
                attendance_list TEXT NULL,
                approval_method VARCHAR(20) DEFAULT 'manual',
                approval_user1_id INT(11) UNSIGNED NULL,
                approval_user2_id INT(11) UNSIGNED NULL,
                doc_status VARCHAR(20) DEFAULT 'draft',
                revision_notes TEXT NULL,
                approval_history TEXT NULL,
                parent_id INT(11) UNSIGNED NULL,
                status ENUM('Draft','Final') DEFAULT 'Draft',
                is_approved TINYINT(1) DEFAULT 0,
                approved_by INT(11) NULL,
                approved_at DATETIME NULL,
                pembahasan JSON NULL,
                created_at DATETIME NULL,
                updated_at DATETIME NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4", "Create notula_rapat");
            echo "<li>✅ Tabel <b>notula_rapat</b> dibuat.</li>";
        }
        // Auto-fix semua kolom notula_rapat yang mungkin hilang
        $notula_cols = [
            'agenda'            => "VARCHAR(255) NULL",
            'peserta'           => "TEXT NULL",
            'hasil_pembahasan'  => "TEXT NULL",
            'nama_disiapkan'    => "VARCHAR(100) NULL",
            'jabatan_disiapkan' => "VARCHAR(100) NULL",
            'nama_setuju1'      => "VARCHAR(100) NULL",
            'jabatan_setuju1'   => "VARCHAR(100) NULL",
            'is_approved1'      => "TINYINT(1) DEFAULT 0",
            'nama_setuju2'      => "VARCHAR(100) NULL",
            'jabatan_setuju2'   => "VARCHAR(100) NULL",
            'is_approved2'      => "TINYINT(1) DEFAULT 0",
            'is_final'          => "TINYINT(1) DEFAULT 0",
            'attendance_list'   => "TEXT NULL",
            'approval_method'   => "VARCHAR(20) DEFAULT 'manual'",
            'approval_user1_id' => "INT(11) UNSIGNED NULL",
            'approval_user2_id' => "INT(11) UNSIGNED NULL",
            'doc_status'        => "VARCHAR(20) DEFAULT 'draft'",
            'revision_notes'    => "TEXT NULL",
            'approval_history'  => "TEXT NULL",
            'parent_id'         => "INT(11) UNSIGNED NULL",
            'created_at'        => "DATETIME NULL",
            'updated_at'        => "DATETIME NULL",
        ];
        foreach ($notula_cols as $col => $def) {
            $this->addCol('notula_rapat', $col, $def);
        }

        // ================================================================
        // 1. Tabel aplikasi_master
        // ================================================================
        if (!$this->tableOk('aplikasi_master')) {
            $this->run("CREATE TABLE aplikasi_master (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nama_app VARCHAR(255) NULL,
                pic_id INT(11) NULL,
                divisi_id INT(11) NULL,
                status ENUM('Development','Production','Maintenance') DEFAULT 'Development',
                deskripsi TEXT NULL,
                tgl_mulai DATE NULL,
                tgl_target DATE NULL,
                versi_current VARCHAR(50) NULL,
                created_at DATETIME NULL,
                updated_at DATETIME NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4", "Create aplikasi_master");
            echo "<li>✅ Tabel <b>aplikasi_master</b> dibuat.</li>";
        }
        $app_cols = [
            'deskripsi'      => "TEXT NULL",
            'tgl_mulai'      => "DATE NULL",
            'tgl_target'     => "DATE NULL",
            'versi_current'  => "VARCHAR(50) NULL",
            'sdlc_checklist' => "TEXT NULL",
            'created_at'     => "DATETIME NULL",
            'updated_at'     => "DATETIME NULL",
        ];
        foreach ($app_cols as $col => $def) {
            $this->addCol('aplikasi_master', $col, $def);
        }

        // ================================================================
        // 1.5. Tabel permintaan_aplikasi
        // ================================================================
        if (!$this->tableOk('permintaan_aplikasi')) {
            $this->run("CREATE TABLE permintaan_aplikasi (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nama_app VARCHAR(255) NULL,
                deskripsi TEXT NULL,
                latar_belakang TEXT NULL,
                tgl_target DATE NULL,
                user_id INT(11) UNSIGNED NOT NULL,
                nama_disiapkan VARCHAR(100) NULL,
                jabatan_disiapkan VARCHAR(100) NULL,
                tgl_disiapkan DATETIME NULL,
                approval_user_id INT(11) UNSIGNED NULL,
                nama_setuju VARCHAR(100) NULL,
                jabatan_setuju VARCHAR(100) NULL,
                tgl_setuju DATETIME NULL,
                is_approved TINYINT(1) DEFAULT 0,
                doc_status VARCHAR(20) DEFAULT 'draft',
                tgl_mulai_pengembangan DATE NULL,
                aplikasi_id INT(11) NULL,
                created_at DATETIME NULL,
                updated_at DATETIME NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4", "Create permintaan_aplikasi");
            echo "<li>✅ Tabel <b>permintaan_aplikasi</b> dibuat.</li>";
        }
        $permintaan_cols = [
            'nama_app'               => "VARCHAR(255) NULL",
            'deskripsi'              => "TEXT NULL",
            'latar_belakang'         => "TEXT NULL",
            'tgl_target'             => "DATE NULL",
            'user_id'                => "INT(11) UNSIGNED NOT NULL",
            'nama_disiapkan'         => "VARCHAR(100) NULL",
            'jabatan_disiapkan'      => "VARCHAR(100) NULL",
            'tgl_disiapkan'          => "DATETIME NULL",
            'approval_user_id'       => "INT(11) UNSIGNED NULL",
            'nama_setuju'            => "VARCHAR(100) NULL",
            'jabatan_setuju'         => "VARCHAR(100) NULL",
            'tgl_setuju'             => "DATETIME NULL",
            'is_approved'            => "TINYINT(1) DEFAULT 0",
            'doc_status'             => "VARCHAR(20) DEFAULT 'draft'",
            'tgl_mulai_pengembangan' => "DATE NULL",
            'aplikasi_id'            => "INT(11) NULL",
            'created_at'             => "DATETIME NULL",
            'updated_at'             => "DATETIME NULL",
        ];
        foreach ($permintaan_cols as $col => $def) {
            $this->addCol('permintaan_aplikasi', $col, $def);
        }

        // ================================================================
        // 2. Tabel master_cobit_19
        // ================================================================
        if (!$this->tableOk('master_cobit_19')) {
            $this->run("CREATE TABLE master_cobit_19 (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                domain VARCHAR(100) DEFAULT 'SDLC',
                kode_proses VARCHAR(10) NULL,
                nama_proses VARCHAR(255),
                deskripsi TEXT NULL,
                tujuan_audit TEXT NULL,
                created_at DATETIME NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4", "Create master_cobit_19");
            echo "<li>✅ Tabel <b>master_cobit_19</b> dibuat.</li>";
        }
        // Seed COBIT jika kosong
        try {
            if ($this->db->table('master_cobit_19')->countAllResults() == 0) {
                $cobit = [
                    ['C1','Permintaan Pengembangan'],['C2','Persetujuan Pengembangan'],
                    ['C3','Perencanaan Proyek'],['C4','Perencanaan Kebutuhan'],
                    ['C5','Analisis Desain'],['C6','Quality Assurance Testing'],
                    ['C7','User Acceptance Testing (UAT)'],['C8','Serah Terima Aplikasi'],
                ];
                foreach ($cobit as [$kode, $nama]) {
                    $this->db->table('master_cobit_19')->insert([
                        'kode_proses' => $kode, 'nama_proses' => $nama,
                        'domain' => 'SDLC Monitoring', 'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
                echo "<li>🌱 Data Master COBIT-19 (8 Poin) berhasil di-seed.</li>";
            }
        } catch (\Exception $e) {}

        // ================================================================
        // 3. Tabel implementasi_data
        // ================================================================
        if (!$this->tableOk('implementasi_data')) {
            $this->run("CREATE TABLE implementasi_data (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                aplikasi_id INT(11),
                tgl_rilis DATE,
                lingkungan ENUM('Staging','Production') DEFAULT 'Production',
                changelog TEXT NULL,
                url_akses VARCHAR(255) NULL,
                petugas_it VARCHAR(100) NULL,
                created_at DATETIME NULL,
                updated_at DATETIME NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4", "Create implementasi_data");
            echo "<li>✅ Tabel <b>implementasi_data</b> dibuat.</li>";
        }

        // ================================================================
        // 4. Tabel progres_log
        // ================================================================
        if (!$this->tableOk('progres_log')) {
            $this->run("CREATE TABLE progres_log (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                aplikasi_id INT(11),
                user_id INT(11),
                modul_id INT(11) NULL,
                cobit_id INT(11) NULL,
                pesan_update TEXT,
                persentase INT(11),
                file_lampiran VARCHAR(255) NULL,
                komentar_admin TEXT NULL,
                tgl_update DATETIME,
                is_approved TINYINT(1) DEFAULT 0,
                created_at DATETIME NULL,
                updated_at DATETIME NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4", "Create progres_log");
            echo "<li>✅ Tabel <b>progres_log</b> dibuat.</li>";
        }
        $prog_cols = [
            'modul_id'      => "INT(11) NULL",
            'cobit_id'      => "INT(11) NULL",
            'file_lampiran' => "VARCHAR(255) NULL",
            'komentar_admin'=> "TEXT NULL",
            'created_at'    => "DATETIME NULL",
            'updated_at'    => "DATETIME NULL",
        ];
        foreach ($prog_cols as $col => $def) {
            $this->addCol('progres_log', $col, $def);
        }

        // ================================================================
        // 5. Tabel system_logs
        // ================================================================
        if (!$this->tableOk('system_logs')) {
            $this->run("CREATE TABLE system_logs (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT(11) NULL,
                username VARCHAR(100),
                aksi VARCHAR(255),
                keterangan TEXT NULL,
                ip_address VARCHAR(50) NULL,
                user_agent VARCHAR(255) NULL,
                created_at DATETIME NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4", "Create system_logs");
            echo "<li>✅ Tabel <b>system_logs</b> dibuat.</li>";
        }

        // ================================================================
        // 6. Tabel master_kpi
        // ================================================================
        if (!$this->tableOk('master_kpi')) {
            $this->run("CREATE TABLE master_kpi (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nama_kpi VARCHAR(255),
                target DECIMAL(10,2),
                satuan VARCHAR(50),
                tahun YEAR,
                divisi_id INT(11) NULL,
                created_at DATETIME NULL,
                updated_at DATETIME NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4", "Create master_kpi");
            echo "<li>✅ Tabel <b>master_kpi</b> dibuat.</li>";
        }

        // ================================================================
        // 7. Tabel absensi_kehadiran
        // ================================================================
        if (!$this->tableOk('absensi_kehadiran')) {
            $this->run("CREATE TABLE absensi_kehadiran (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                aplikasi_id INT(11) UNSIGNED NULL,
                user_id INT(11) UNSIGNED NOT NULL,
                acara VARCHAR(255) NOT NULL,
                tanggal DATE NOT NULL,
                waktu VARCHAR(100) NOT NULL,
                tempat VARCHAR(255) NOT NULL,
                peserta JSON NULL,
                created_at DATETIME NULL,
                updated_at DATETIME NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4", "Create absensi_kehadiran");
            echo "<li>✅ Tabel <b>absensi_kehadiran</b> dibuat.</li>";
        }

        // ================================================================
        // 8. Tabel aset (hanya buat jika belum ada, TIDAK drop jika sudah ada)
        // ================================================================
        if (!$this->tableOk('aset')) {
            $this->run("CREATE TABLE aset (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nama_aset VARCHAR(255) NOT NULL,
                kategori VARCHAR(100) NOT NULL,
                status VARCHAR(50) NOT NULL,
                pic VARCHAR(150) NOT NULL,
                deskripsi TEXT NULL,
                created_at DATETIME NULL,
                updated_at DATETIME NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4", "Create aset");
            echo "<li>✅ Tabel <b>aset</b> dibuat.</li>";
        }
        $this->addCol('aset', 'created_at', "DATETIME NULL");
        $this->addCol('aset', 'updated_at', "DATETIME NULL");

        // ================================================================
        // 9. Seeding data awal jika aplikasi_master kosong
        // ================================================================
        try {
            $checkApp = $this->db->table('aplikasi_master')->countAllResults();
            if ($checkApp == 0) {
                $picUser = $this->db->table('users')->where('username', 'admin')->get()->getRowArray();
                $picId   = $picUser['id'] ?? 1;
                $divisiRow = $this->db->table('divisi')->where('kode_divisi', 'IT')->get()->getRowArray();
                $divisiId  = $divisiRow['id'] ?? 1;

                $this->db->table('aplikasi_master')->insert([
                    'nama_app'      => 'SIMPA Enterprise',
                    'pic_id'        => $picId,
                    'divisi_id'     => $divisiId,
                    'status'        => 'Development',
                    'deskripsi'     => 'Sistem Informasi Manajemen Proyek Aplikasi PT Surveyor Indonesia',
                    'tgl_mulai'     => '2026-04-01',
                    'tgl_target'    => '2026-07-31',
                    'versi_current' => 'v1.0-alpha',
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
                echo "<li>🌱 Aplikasi Master <b>SIMPA Enterprise</b> berhasil di-seed.</li>";
            }
        } catch (\Exception $e) {
            echo "<li style='color:orange;'>⚠️ Seeding dilewati: " . $e->getMessage() . "</li>";
        }

        // ================================================================
        // FINAL: Tampilkan ringkasan
        // ================================================================
        $hasError = !empty($this->errors);
        echo "</ul><br>";
        if ($hasError) {
            echo "<div style='color:orange; font-weight:bold;'>⚠️ Selesai dengan " . count($this->errors) . " peringatan (non-fatal). Sistem tetap bisa digunakan.</div>";
        } else {
            echo "<div style='color:green; font-weight:bold;'>🎉 SELESAI! Semua tabel dan kolom sudah lengkap dan sinkron.</div>";
        }
        echo "<br><a href='" . base_url('dashboard') . "' style='padding: 10px 20px; background: #0d6efd; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;'>MASUK KE DASHBOARD</a>";
        echo "</div>";
    }
}

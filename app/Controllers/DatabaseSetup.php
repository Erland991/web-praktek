<?php

namespace App\Controllers;

class DatabaseSetup extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        echo "<div style='font-family: sans-serif; padding: 40px;'>";
        echo "<h2>🔧 Sinkronisasi Database (Direct SQL Mode)</h2><hr><ul style='line-height: 2;'>";

        try {
            // 1. Tabel aplikasi_master
            if (!$db->tableExists('aplikasi_master')) {
                $db->simpleQuery("CREATE TABLE aplikasi_master (
                    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    nama_app VARCHAR(255) NULL,
                    pic_id INT(11) NULL,
                    divisi_id INT(11) NULL,
                    status ENUM('Development','Production','Maintenance') DEFAULT 'Development'
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                echo "<li>✅ Tabel <b>aplikasi_master</b> dibuat.</li>";
            }

            // Tambah kolom ke aplikasi_master jika belum ada
            $cols_app = [
                'deskripsi' => "ALTER TABLE aplikasi_master ADD deskripsi TEXT NULL",
                'tgl_mulai' => "ALTER TABLE aplikasi_master ADD tgl_mulai DATE NULL",
                'tgl_target' => "ALTER TABLE aplikasi_master ADD tgl_target DATE NULL",
                'versi_current' => "ALTER TABLE aplikasi_master ADD versi_current VARCHAR(50) NULL",
                'created_at' => "ALTER TABLE aplikasi_master ADD created_at DATETIME NULL",
                'updated_at' => "ALTER TABLE aplikasi_master ADD updated_at DATETIME NULL"
            ];

            foreach($cols_app as $col => $sql) {
                if (!$db->fieldExists($col, 'aplikasi_master')) {
                    $db->simpleQuery($sql);
                    echo "<li>➕ Kolom <b>$col</b> ditambahkan ke aplikasi_master.</li>";
                }
            }

            // 2. Tabel Master COBIT-19
            if (!$db->tableExists('master_cobit_19')) {
                $db->simpleQuery("CREATE TABLE master_cobit_19 (
                    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    domain VARCHAR(100) DEFAULT 'SDLC',
                    kode_proses VARCHAR(10) NULL,
                    nama_proses VARCHAR(255),
                    deskripsi TEXT NULL,
                    tujuan_audit TEXT NULL,
                    created_at DATETIME NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                echo "<li>✅ Tabel <b>master_cobit_19</b> dibuat.</li>";
            }

            // Seed Master COBIT if empty
            $checkCobit = $db->table('master_cobit_19')->countAllResults();
            if ($checkCobit == 0) {
                $cobitPoints = [
                    ['nama_proses' => 'Permintaan Pengembangan', 'kode_proses' => 'C1'],
                    ['nama_proses' => 'Persetujuan Pengembangan', 'kode_proses' => 'C2'],
                    ['nama_proses' => 'Perencanaan Proyek', 'kode_proses' => 'C3'],
                    ['nama_proses' => 'Perencanaan Kebutuhan', 'kode_proses' => 'C4'],
                    ['nama_proses' => 'Analisis Desain', 'kode_proses' => 'C5'],
                    ['nama_proses' => 'Quality Assurance Testing', 'kode_proses' => 'C6'],
                    ['nama_proses' => 'User Acceptance Testing (UAT)', 'kode_proses' => 'C7'],
                    ['nama_proses' => 'Serah Terima Aplikasi', 'kode_proses' => 'C8'],
                ];
                foreach ($cobitPoints as $p) {
                    $db->table('master_cobit_19')->insert([
                        'nama_proses' => $p['nama_proses'],
                        'kode_proses' => $p['kode_proses'],
                        'domain'      => 'SDLC Monitoring',
                        'created_at'  => date('Y-m-d H:i:s')
                    ]);
                }
                echo "<li>🌱 Data Master COBIT-19 (8 Poin) berhasil di-seed.</li>";
            }

            // 3. Tabel Implementasi Data
            if (!$db->tableExists('implementasi_data')) {
                $db->simpleQuery("CREATE TABLE implementasi_data (
                    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    aplikasi_id INT(11),
                    tgl_rilis DATE,
                    lingkungan ENUM('Staging', 'Production') DEFAULT 'Production',
                    changelog TEXT NULL,
                    url_akses VARCHAR(255) NULL,
                    petugas_it VARCHAR(100) NULL,
                    created_at DATETIME NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                echo "<li>✅ Tabel <b>implementasi_data</b> dibuat.</li>";
            }

            // 4. Tabel Progres Log & Kolom Baru
            if (!$db->tableExists('progres_log')) {
                $db->simpleQuery("CREATE TABLE progres_log (
                    id INT(11) AUTO_INCREMENT PRIMARY KEY,
                    aplikasi_id INT(11),
                    user_id INT(11),
                    pesan_update TEXT,
                    persentase INT(11),
                    tgl_update DATETIME,
                    is_approved TINYINT(1) DEFAULT 0
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                echo "<li>✅ Tabel <b>progres_log</b> dibuat.</li>";
            }

            $cols_prog = [
                'file_lampiran' => "ALTER TABLE progres_log ADD file_lampiran VARCHAR(255) NULL",
                'komentar_admin' => "ALTER TABLE progres_log ADD komentar_admin TEXT NULL",
                'cobit_id'       => "ALTER TABLE progres_log ADD cobit_id INT(11) NULL",
                'updated_at'    => "ALTER TABLE progres_log ADD updated_at DATETIME NULL"
            ];

            foreach($cols_prog as $col => $sql) {
                if (!$db->fieldExists($col, 'progres_log')) {
                    $db->simpleQuery($sql);
                    echo "<li>➕ Kolom <b>$col</b> ditambahkan ke progres_log.</li>";
                }
            }

            // 5. Tabel Logs
            if (!$db->tableExists('system_logs')) {
                $db->simpleQuery("CREATE TABLE system_logs (
                    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    user_id INT(11) NULL,
                    username VARCHAR(100),
                    aksi VARCHAR(255),
                    keterangan TEXT NULL,
                    ip_address VARCHAR(50) NULL,
                    user_agent VARCHAR(255) NULL,
                    created_at DATETIME NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                echo "<li>✅ Tabel <b>system_logs</b> dibuat.</li>";
            }

            // 6. Tabel Master KPI
            if (!$db->tableExists('master_kpi')) {
                $db->simpleQuery("CREATE TABLE master_kpi (
                    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    nama_kpi VARCHAR(255),
                    target DECIMAL(10,2),
                    satuan VARCHAR(50),
                    tahun YEAR,
                    divisi_id INT(11) NULL,
                    created_at DATETIME NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                echo "<li>✅ Tabel <b>master_kpi</b> dibuat.</li>";
            }

            // 7. Tambah kolom jenis_kelamin ke users jika belum ada
            if (!$db->fieldExists('jenis_kelamin', 'users')) {
                $db->simpleQuery("ALTER TABLE users ADD jenis_kelamin ENUM('L','P') DEFAULT 'L' AFTER nama_lengkap");
                echo "<li>➕ Kolom <b>jenis_kelamin</b> ditambahkan ke users.</li>";
            }

            echo "</ul><br><div style='color: green; font-weight: bold;'>🎉 SELESAI! Database Anda sekarang sudah mendukung fitur-fitur baru.</div>";
            echo "<br><a href='".base_url('dashboard')."' style='padding: 10px 20px; background: #0d6efd; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;'>MASUK KE DASHBOARD</a>";

        } catch (\Exception $e) {
            echo "</ul><div style='color: red; padding: 20px; border: 1px solid red;'>";
            echo "<b>Gagal:</b> " . $e->getMessage();
            echo "</div>";
        }
        echo "</div>";
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSystemExtensions extends Migration
{
    public function up()
    {
        // 1. Tambah Kolom ke aplikasi_master (Jika belum lengkap)
        // Kita asumsikan tabel aplikasi_master sudah ada dari SQL dump, tapi kita lengkapi fungsinya
        $fields = [
            'deskripsi'      => ['type' => 'TEXT', 'null' => true],
            'tgl_mulai'      => ['type' => 'DATE', 'null' => true],
            'tgl_target'     => ['type' => 'DATE', 'null' => true],
            'versi_current'  => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ];
        foreach ($fields as $column => $attributes) {
            if (!$this->db->fieldExists($column, 'aplikasi_master')) {
                $this->forge->addColumn('aplikasi_master', [$column => $attributes]);
            }
        }

        // 2. Tabel Master COBIT-19 Form
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'domain'         => ['type' => 'VARCHAR', 'constraint' => 10, 'comment' => 'EDM, APO, BAI, DSS, MEA'],
            'kode_proses'    => ['type' => 'VARCHAR', 'constraint' => 10],
            'nama_proses'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi'      => ['type' => 'TEXT', 'null' => true],
            'tujuan_audit'   => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('master_cobit_19', true);

        // 3. Tabel Detail Implementasi (Request 2)
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'aplikasi_id'    => ['type' => 'INT', 'constraint' => 11],
            'tgl_rilis'      => ['type' => 'DATE'],
            'lingkungan'     => ['type' => 'ENUM', 'constraint' => ['Staging', 'Production'], 'default' => 'Production'],
            'changelog'      => ['type' => 'TEXT', 'null' => true],
            'url_akses'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'petugas_it'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('implementasi_data', true);

        // 4. Perbaikan progres_log (Tambah Lampiran & Approval)
        $fields_progress = [
            'file_lampiran'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'komentar_admin' => ['type' => 'TEXT', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ];
        foreach ($fields_progress as $column => $attributes) {
            if (!$this->db->fieldExists($column, 'progres_log')) {
                $this->forge->addColumn('progres_log', [$column => $attributes]);
            }
        }

        // 5. Tabel Log History (Request 3)
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'        => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'username'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'aksi'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'keterangan'     => ['type' => 'TEXT', 'null' => true],
            'ip_address'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'user_agent'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('system_logs', true);
    }

    public function down()
    {
        $this->forge->dropTable('system_logs');
        $this->forge->dropTable('implementasi_data');
        $this->forge->dropTable('master_cobit_19');
        $this->forge->dropColumn('aplikasi_master', ['deskripsi', 'tgl_mulai', 'tgl_target', 'versi_current', 'created_at', 'updated_at']);
        $this->forge->dropColumn('progres_log', ['file_lampiran', 'komentar_admin', 'updated_at']);
    }
}

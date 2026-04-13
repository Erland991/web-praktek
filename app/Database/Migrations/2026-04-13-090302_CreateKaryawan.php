<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKaryawan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nik' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'divisi_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        // Menambahkan Foreign Key agar karyawan terhubung ke tabel divisi
        $this->forge->addForeignKey('divisi_id', 'divisi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('karyawan');
    }

    public function down()
    {
        $this->forge->dropTable('karyawan');
    }
}
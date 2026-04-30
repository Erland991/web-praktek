<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAplikasiModul extends Migration
{
    public function up()
    {
        // Tabel Modul Aplikasi (Fitur per Aplikasi dengan Bobot)
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'aplikasi_id'    => ['type' => 'INT', 'constraint' => 11],
            'nama_modul'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'bobot_kesulitan'=> ['type' => 'INT', 'constraint' => 3, 'default' => 10, 'comment' => 'Weight 1-100'],
            'persentase'     => ['type' => 'INT', 'constraint' => 3, 'default' => 0],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('aplikasi_modul');

        // Menambahkan modul_id ke progres_log agar bisa track modul mana yang diupdate
        $fields = [
            'modul_id' => ['type' => 'INT', 'constraint' => 11, 'null' => true, 'after' => 'aplikasi_id']
        ];
        $this->forge->addColumn('progres_log', $fields);
    }

    public function down()
    {
        $this->forge->dropTable('aplikasi_modul');
        $this->forge->dropColumn('progres_log', 'modul_id');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAset extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_aset'   => ['type' => 'VARCHAR', 'constraint' => '255'],
            'kategori'    => ['type' => 'VARCHAR', 'constraint' => '100'],
            'status'      => ['type' => 'VARCHAR', 'constraint' => '50'],
            'pic'         => ['type' => 'VARCHAR', 'constraint' => '100'],
            'deskripsi'   => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('aset');
    }

    public function down()
    {
        $this->forge->dropTable('aset');
    }
}
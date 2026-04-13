<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDivisi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_divisi' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'kode_divisi' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('divisi');
    }

    public function down()
    {
        $this->forge->dropTable('divisi');
    }
}
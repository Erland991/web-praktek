<?php
// create_notula_table.php
require 'system/bootstrap.php';
$db = \Config\Database::connect();
$forge = \Config\Database::forge();

$fields = [
    'id' => [
        'type'           => 'INT',
        'constraint'     => 11,
        'unsigned'       => true,
        'auto_increment' => true,
    ],
    'aplikasi_id' => [
        'type'       => 'INT',
        'constraint' => 11,
        'unsigned'   => true,
        'null'       => true,
    ],
    'user_id' => [
        'type'       => 'INT',
        'constraint' => 11,
        'unsigned'   => true,
    ],
    'tanggal' => [
        'type' => 'DATE',
    ],
    'tempat' => [
        'type'       => 'VARCHAR',
        'constraint' => '255',
    ],
    'agenda' => [
        'type'       => 'VARCHAR',
        'constraint' => '255',
    ],
    'peserta' => [
        'type' => 'TEXT',
    ],
    'hasil_pembahasan' => [
        'type' => 'JSON', // CI4 will treat it as text if JSON is not supported by DB, but modern DBs support it
    ],
    'nama_disiapkan' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
    'jabatan_disiapkan' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
    'nama_setuju1' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
    'jabatan_setuju1' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
    'is_approved1' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
    'nama_setuju2' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
    'jabatan_setuju2' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
    'is_approved2' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
    'is_final' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
    'created_at' => [
        'type' => 'DATETIME',
        'null' => true,
    ],
];

$forge->addField($fields);
$forge->addKey('id', true);
try {
    $forge->createTable('notula_rapat', true);
    echo "Table 'notula_rapat' created successfully!";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

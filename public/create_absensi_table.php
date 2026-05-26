<?php
// create_absensi_table.php
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
    'acara' => [
        'type'       => 'VARCHAR',
        'constraint' => '255',
    ],
    'tanggal' => [
        'type' => 'DATE',
    ],
    'waktu' => [
        'type'       => 'VARCHAR',
        'constraint' => '100',
    ],
    'tempat' => [
        'type'       => 'VARCHAR',
        'constraint' => '255',
    ],
    'peserta' => [
        'type' => 'JSON', // JSON to store array of {nama, jabatan, hp_ext, email}
    ],
    'created_at' => [
        'type' => 'DATETIME',
        'null' => true,
    ],
    'updated_at' => [
        'type' => 'DATETIME',
        'null' => true,
    ]
];

$forge->addField($fields);
$forge->addKey('id', true);
try {
    $forge->createTable('absensi_kehadiran', true);
    echo "Table 'absensi_kehadiran' created successfully!";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

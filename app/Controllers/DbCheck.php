<?php

namespace App\Controllers;

use Config\Database;

class DbCheck extends BaseController
{
    public function addPhotoColumn()
    {
        $db = Database::connect();
        $forge = \Config\Database::forge();

        $fields = [
            'photo' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'default' => 'default.png',
                'after' => 'divisi'
            ],
        ];

        try {
            $forge->addColumn('users', $fields);
            echo "Column 'photo' added successfully!";
        } catch (\Exception $e) {
            echo "Error or column already exists: " . $e->getMessage();
        }
    }
}

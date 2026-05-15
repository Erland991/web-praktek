<?php
// fix_db.php
require 'system/bootstrap.php';
$db = \Config\Database::connect();
try {
    $db->query("ALTER TABLE users ADD COLUMN photo VARCHAR(255) DEFAULT 'default.png' AFTER divisi");
    echo "Column 'photo' added successfully!";
} catch (\Exception $e) {
    echo "Error or column already exists: " . $e->getMessage();
}

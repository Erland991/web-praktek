<?php
$db = new mysqli('localhost', 'root', '', 'db_monitoring_aset'); // using actual DB name
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if columns exist, if not add them
$result = $db->query("SHOW COLUMNS FROM permintaan_aplikasi LIKE 'uraian_tambahan'");
if ($result->num_rows == 0) {
    $db->query("ALTER TABLE permintaan_aplikasi ADD uraian_tambahan TEXT NULL");
    echo "Added uraian_tambahan. ";
}

$result = $db->query("SHOW COLUMNS FROM permintaan_aplikasi LIKE 'lampiran'");
if ($result->num_rows == 0) {
    $db->query("ALTER TABLE permintaan_aplikasi ADD lampiran TEXT NULL");
    echo "Added lampiran. ";
}

echo "Done.";
$db->close();

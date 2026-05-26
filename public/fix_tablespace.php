<?php
$dir = 'C:\\xampp\\mysql\\data\\db_monitoring_aset\\';
if (is_dir($dir)) {
    echo "Directory exists!\n";
    $files = scandir($dir);
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) == 'ibd') {
            echo "Found: $file\n";
            unlink($dir . $file);
            echo "Deleted: $file\n";
        }
    }
} else {
    echo "Directory not found.\n";
}

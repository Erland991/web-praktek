<?php
$dir = 'C:\\xampp\\mysql\\data\\db_monitoring_aset\\';
$files = glob($dir . 'karyawan.*');
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
        echo "Berhasil menghapus: " . basename($file) . "\n";
    }
}
echo "Selesai.";

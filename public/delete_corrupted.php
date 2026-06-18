<?php
$dir = 'C:\\xampp\\mysql\\data\\db_monitoring_aset\\';

// Daftar tabel yang sudah tidak dipakai dan corrupt
$corrupted_tables = ['migrations', 'roles'];

echo "<h3>Membersihkan tabel corrupt...</h3><ul>";

foreach ($corrupted_tables as $table) {
    $files = glob($dir . $table . '.*');
    if (empty($files)) {
        echo "<li>File untuk tabel <b>$table</b> tidak ditemukan (sudah bersih).</li>";
    } else {
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
                echo "<li>Berhasil menghapus: " . basename($file) . "</li>";
            }
        }
    }
}
echo "</ul><b>Selesai! Silakan restart MySQL di XAMPP lalu buka ulang phpMyAdmin.</b>";

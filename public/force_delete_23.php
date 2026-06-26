<?php
$db = new mysqli('localhost', 'root', '', 'db_monitoring_aset');
if ($db->connect_error) {
    die('Koneksi gagal: ' . $db->connect_error);
}

// Hapus semua yang pic_id NULL, 0, atau user-nya sudah tidak ada
$result = $db->query("
    SELECT am.id, am.nama_app, am.pic_id, u.nama_lengkap
    FROM aplikasi_master am
    LEFT JOIN users u ON u.id = am.pic_id
    WHERE am.pic_id IS NULL OR am.pic_id = 0 OR u.id IS NULL
");

echo "<h3 style='font-family:sans-serif;'>Daftar yang akan dihapus:</h3><ul style='font-family:sans-serif;'>";
$ids = [];
while ($row = $result->fetch_assoc()) {
    echo "<li>ID: {$row['id']} → {$row['nama_app']} (pic_id: ".($row['pic_id'] ?? 'NULL').")</li>";
    $ids[] = $row['id'];
}
echo "</ul>";

if (!empty($ids)) {
    $idList = implode(',', $ids);
    $db->query("DELETE FROM aplikasi_master WHERE id IN ($idList)");
    echo "<p style='font-family:sans-serif; color:green;'>✅ Berhasil dihapus {$db->affected_rows} baris!</p>";
} else {
    echo "<p style='font-family:sans-serif; color:orange;'>Tidak ada yang perlu dihapus.</p>";
}
$db->close();

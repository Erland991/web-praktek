<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require FCPATH . '../system/bootstrap.php';

$db = \Config\Database::connect();
$res = $db->table('aset')->insert([
    'nama_aset' => 'Test Data Category',
    'kategori'  => 'Data',
    'status'    => 'Aktif',
    'pic'       => 'Siti Aminah',
    'deskripsi' => 'test'
]);

echo json_encode([
    'result' => $res,
    'error' => $db->error()
]);

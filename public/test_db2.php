<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require FCPATH . '../system/bootstrap.php';

$db = \Config\Database::connect();
$res = $db->table('aset')->get()->getResultArray();
echo json_encode($res);

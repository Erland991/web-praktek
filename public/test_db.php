<?php
require 'index.php';
$db = \Config\Database::connect();
$res = $db->table('aset')->get()->getResultArray();
echo json_encode($res);

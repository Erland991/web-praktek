<?php
$ch = curl_init('http://localhost:8080/dashboard/save');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'nama_aset' => 'Test Aset Data',
    'kategori'  => 'Data',
    'status'    => 'Aktif',
    'pic'       => 'Kevin',
    'deskripsi' => 'This is a test'
]);
$response = curl_exec($ch);
echo "HTTP Status: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";
echo $response;

<?php

namespace App\Controllers;

class TestController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $q = $db->query("DESCRIBE aset");
        echo json_encode($q->getResultArray());
    }
    
    public function data()
    {
        $db = \Config\Database::connect();
        $q = $db->table('aset')->get();
        echo json_encode($q->getResultArray());
    }

    public function insert_data()
    {
        $model = new \App\Models\AssetModel();
        $res = $model->save([
            'nama_aset' => 'Test Data Cat',
            'kategori'  => 'Data',
            'status'    => 'Aktif',
            'pic'       => 'Kevin',
            'deskripsi' => 'test'
        ]);
        echo json_encode(['success' => $res, 'errors' => $model->errors()]);
    }

    public function test_master()
    {
        $db = \Config\Database::connect();
        $q = $db->table('aplikasi_master')->get();
        echo json_encode($q->getResultArray());
    }
}

<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KpiModel;
use App\Models\LogModel;

class Kpi extends BaseController
{
    public function index()
    {
        if (session()->get('role') != 'Admin') return redirect()->to('/dashboard');

        $model = new KpiModel();
        $db = \Config\Database::connect();
        
        $data['kpi'] = $db->table('master_kpi')
                          ->select('master_kpi.*, divisi.nama_divisi')
                          ->join('divisi', 'divisi.id = master_kpi.divisi_id', 'left')
                          ->get()->getResultArray();
                          
        $data['divisi'] = $db->table('divisi')->get()->getResultArray();
        
        return view('admin/master/kpi_v', $data);
    }

    public function save()
    {
        if (session()->get('role') != 'Admin') return redirect()->back();

        $model = new KpiModel();
        $data = [
            'nama_kpi'   => $this->request->getPost('nama_kpi'),
            'target'     => $this->request->getPost('target'),
            'satuan'     => $this->request->getPost('satuan'),
            'tahun'      => $this->request->getPost('tahun'),
            'divisi_id'  => $this->request->getPost('divisi_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $model->save($data);
        (new LogModel())->record('TAMBAH KPI', 'Menambahkan KPI: ' . $data['nama_kpi']);

        return redirect()->back()->with('sukses', 'Master KPI berhasil ditambahkan.');
    }

    public function delete($id)
    {
        if (session()->get('role') != 'Admin') return redirect()->back();
        
        $model = new KpiModel();
        $kpi = $model->find($id);
        
        $model->delete($id);
        (new LogModel())->record('HAPUS KPI', 'Menghapus KPI: ' . ($kpi['nama_kpi'] ?? $id));

        return redirect()->back()->with('sukses', 'KPI berhasil dihapus.');
    }
}

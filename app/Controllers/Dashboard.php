<?php

namespace App\Controllers;

use App\Models\AssetModel;

class Dashboard extends BaseController
{
    // 1. Menampilkan Halaman Utama
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new AssetModel();
        $data['semua_aset'] = $model->findAll();
        $data['total_aset'] = $model->countAll();

        return view('dashboard_v', $data);
    }

    // 2. Form Tambah Aset
    public function add()
    {
        if (!session()->get('logged_in')) return redirect()->to('/');
        return view('add_asset_v');
    }

    // 3. Simpan Aset Baru
    public function save()
    {
        $model = new AssetModel();
        $model->save([
            'nama_aset' => $this->request->getPost('nama_aset'),
            'kategori'  => $this->request->getPost('kategori'),
            'status'    => $this->request->getPost('status'),
            'pic'       => $this->request->getPost('pic'),
        ]);
        return redirect()->to('/dashboard');
    }

    // 4. Form Edit Aset
    public function edit($id)
    {
        if (!session()->get('logged_in')) return redirect()->to('/');
        
        $model = new AssetModel();
        $data['aset'] = $model->find($id);
        
        return view('edit_asset_v', $data);
    }

    // 5. Update Data Aset
    public function update($id)
    {
        $model = new AssetModel();
        $model->update($id, [
            'nama_aset' => $this->request->getPost('nama_aset'),
            'kategori'  => $this->request->getPost('kategori'),
            'status'    => $this->request->getPost('status'),
            'pic'       => $this->request->getPost('pic'),
        ]);
        return redirect()->to('/dashboard');
    }

    // 6. Hapus Aset
    public function delete($id)
    {
        $model = new AssetModel();
        $model->delete($id);
        return redirect()->to('/dashboard');
    }
}
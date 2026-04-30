<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AppMasterModel;
use App\Models\UserModel;
use App\Models\DivisiModel;
use App\Models\LogModel;
use App\Models\AssetModel;

class AppMaster extends BaseController
{
    public function index()
    {
        $model = new AppMasterModel();
        
        // Join with users and divisi for display
        $data['apps'] = $model->select('aplikasi_master.*, users.nama_lengkap as pic_name, divisi.nama_divisi')
                              ->join('users', 'users.id = aplikasi_master.pic_id', 'left')
                              ->join('divisi', 'divisi.id = aplikasi_master.divisi_id', 'left')
                              ->findAll();

        $data['list_pic'] = (new UserModel())->findAll();
        $data['list_divisi'] = (new DivisiModel())->findAll();
        $data['list_aset'] = (new AssetModel())->findAll(); // Untuk auto-fill dari Dashboard

        return view('admin/master/app_master_v', $data);
    }

    public function save()
    {
        $model = new AppMasterModel();
        $data = [
            'nama_app'    => $this->request->getPost('nama_app'),
            'pic_id'      => $this->request->getPost('pic_id'),
            'divisi_id'   => $this->request->getPost('divisi_id'),
            'status'      => $this->request->getPost('status'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'tgl_mulai'   => $this->request->getPost('tgl_mulai'),
            'tgl_target'  => $this->request->getPost('tgl_target'),
        ];

        if ($model->save($data)) {
            (new LogModel())->record('TAMBAH MASTER APP', 'Menambahkan aplikasi master: ' . $data['nama_app']);
            return redirect()->back()->with('sukses', 'Aplikasi Master Berhasil Ditambah');
        }
        return redirect()->back()->with('error', 'Gagal menambah data');
    }

    public function delete($id)
    {
        $model = new AppMasterModel();
        $model->delete($id);
        (new LogModel())->record('HAPUS MASTER APP', 'Menghapus aplikasi master id: ' . $id);
        return redirect()->back()->with('sukses', 'Aplikasi berhasil dihapus');
    }

    public function release()
    {
        $db = \Config\Database::connect();
        $data = [
            'aplikasi_id' => $this->request->getPost('aplikasi_id'),
            'tgl_rilis'   => $this->request->getPost('tgl_rilis'),
            'lingkungan'  => $this->request->getPost('lingkungan'), // Staging/Production
            'changelog'   => $this->request->getPost('changelog'),
            'url_akses'   => $this->request->getPost('url_akses'),
            'petugas_it'  => $this->request->getPost('petugas_it'),
            'created_at'  => date('Y-m-d H:i:s')
        ];

        $db->table('implementasi_data')->insert($data);
        (new LogModel())->record('RELEASE APP', 'Mencatat rilis aplikasi ID: ' . $data['aplikasi_id']);

        return redirect()->back()->with('sukses', 'Data Implementasi (Go-Live) berhasil dicatat.');
    }

    public function get_modules($app_id)
    {
        $db = \Config\Database::connect();
        $modules = $db->table('aplikasi_modul')->where('aplikasi_id', $app_id)->get()->getResultArray();
        return $this->response->setJSON($modules);
    }

    public function save_module()
    {
        $db = \Config\Database::connect();
        $data = [
            'aplikasi_id'    => $this->request->getPost('aplikasi_id'),
            'nama_modul'     => $this->request->getPost('nama_modul'),
            'bobot_kesulitan'=> $this->request->getPost('bobot_kesulitan'),
            'persentase'     => 0,
            'updated_at'     => date('Y-m-d H:i:s')
        ];

        $db->table('aplikasi_modul')->insert($data);
        return redirect()->back()->with('sukses', 'Modul berhasil ditambahkan.');
    }

    public function delete_module($id)
    {
        $db = \Config\Database::connect();
        $db->table('aplikasi_modul')->where('id', $id)->delete();
        return redirect()->back()->with('sukses', 'Modul berhasil dihapus.');
    }
}

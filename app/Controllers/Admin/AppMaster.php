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
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Aplikasi Master Berhasil Ditambah']);
            }
            return redirect()->back()->with('sukses', 'Aplikasi Master Berhasil Ditambah');
        }
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menambah data']);
        }
        return redirect()->back()->with('error', 'Gagal menambah data');
    }

    public function update($id)
    {
        $model = new AppMasterModel();
        $data = [
            'nama_app'   => $this->request->getPost('nama_app'),
            'pic_id'     => $this->request->getPost('pic_id') ?: null,
            'divisi_id'  => $this->request->getPost('divisi_id') ?: null,
            'status'     => $this->request->getPost('status'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'tgl_mulai'  => $this->request->getPost('tgl_mulai') ?: null,
            'tgl_target' => $this->request->getPost('tgl_target') ?: null,
        ];

        if ($model->update($id, $data)) {
            (new LogModel())->record('EDIT MASTER APP', 'Mengubah aplikasi master id: ' . $id);
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Aplikasi berhasil diperbarui!']);
            }
            return redirect()->back()->with('sukses', 'Aplikasi berhasil diperbarui!');
        }
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui data.']);
        }
        return redirect()->back()->with('error', 'Gagal memperbarui data.');
    }

    public function delete($id)
    {
        $model = new AppMasterModel();
        $app = $model->find($id);
        if ($app) {
            $alasan = $this->request->getPost('alasan');
            
            // Insert notification
            $db = \Config\Database::connect();
            if ($db->tableExists('notifikasi') && !empty($alasan)) {
                $db->table('notifikasi')->insert([
                    'user_id' => $app['pic_id'] ?? 0,
                    'judul' => 'Penghapusan Aplikasi Master',
                    'pesan' => 'Aplikasi "' . $app['nama_app'] . '" telah dihapus oleh Admin/PM. Alasan: ' . $alasan,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

            $model->delete($id);
            (new LogModel())->record('HAPUS MASTER APP', 'Menghapus aplikasi master id: ' . $id . ' Alasan: ' . ($alasan ?: 'Tanpa alasan'));
        }
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Aplikasi berhasil dihapus & User telah diberitahu!']);
        }
        return redirect()->back()->with('sukses', 'Aplikasi berhasil dihapus & User telah diberitahu!');
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

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Implementasi (Go-Live) berhasil dicatat.']);
        }
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
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Modul berhasil ditambahkan.']);
        }
        return redirect()->back()->with('sukses', 'Modul berhasil ditambahkan.');
    }

    public function delete_module($id)
    {
        $db = \Config\Database::connect();
        $db->table('aplikasi_modul')->where('id', $id)->delete();
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Modul berhasil dihapus.']);
        }
        return redirect()->back()->with('sukses', 'Modul berhasil dihapus.');
    }
}

<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DivisiModel;
use App\Models\UserModel;

class Master extends BaseController
{
    // --- KELOLA DIVISI ---
    public function divisi()
    {
        $model = new DivisiModel();
        $data['divisi'] = $model->findAll();
        return view('admin/master/divisi_v', $data);
    }

    public function saveDivisi()
    {
        $model = new DivisiModel();
        $model->save([
            'nama_divisi' => $this->request->getPost('nama_divisi'),
            'kode_divisi' => $this->request->getPost('kode_divisi'),
        ]);
        return redirect()->to('/master/divisi')->with('sukses', 'Divisi berhasil ditambah');
    }

    public function deleteDivisi($id)
    {
        $model = new DivisiModel();
        $model->delete($id);
        return redirect()->to('/master/divisi')->with('sukses', 'Divisi berhasil dihapus');
    }

    // --- KELOLA KARYAWAN ---
    public function karyawan()
    {
        $userModel = new UserModel(); 
        $divisiModel = new DivisiModel();

        $data['karyawan'] = $userModel->findAll();
        $data['list_divisi'] = $divisiModel->findAll(); 

        return view('admin/master/karyawan_v', $data);
    }

    public function saveKaryawan()
    {
        $model = new UserModel();
        
        $data = [
            'nip'          => $this->request->getPost('nip'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash('admin123', PASSWORD_DEFAULT), // Pakai hash biar aman
            'role'         => $this->request->getPost('role'),
            'divisi'       => $this->request->getPost('divisi'),
        ];

        if ($model->save($data)) {
            return redirect()->to('/master/karyawan')->with('sukses', 'Data Karyawan Berhasil Disimpan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
        }
    }

    // PENEMPATAN UPDATE HARUS DI LUAR SAVE (BERDIRI SENDIRI)
    public function updateKaryawan($id)
    {
        $model = new UserModel();

        $data = [
            'nip'          => $this->request->getPost('nip'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'role'         => $this->request->getPost('role'),
            'divisi'       => $this->request->getPost('divisi'),
        ];

        // Jika password diisi di form edit, baru di-hash dan diupdate
        $pass = $this->request->getPost('password');
        if (!empty($pass)) {
            $data['password'] = password_hash($pass, PASSWORD_DEFAULT);
        }

        if ($model->update($id, $data)) {
            return redirect()->to(base_url('master/karyawan'))->with('sukses', 'Data Berhasil Diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui data.');
        }
    }

    public function deleteKaryawan($id)
    {
        $model = new UserModel();
        $model->delete($id);
        return redirect()->to('/master/karyawan')->with('sukses', 'Karyawan berhasil dihapus');
    }
}
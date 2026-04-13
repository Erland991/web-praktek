<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        if (session()->get('role') !== 'Admin') {
            return redirect()->to('/dashboard');
        }

        $model = new UserModel();
        $data['semua_user'] = $model->findAll();
        return view('user/index_v', $data);
    }

    public function add()
    {
        return view('user/add_v');
    }

    public function save()
    {
        $model = new UserModel();
        $model->save([
            'nip'          => $this->request->getPost('nip'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'password'     => 'admin123', // Default password (bisa diganti nanti)
            'role'         => $this->request->getPost('role'),
            'divisi'       => $this->request->getPost('divisi'),
        ]);
        return redirect()->to('/user')->with('sukses', 'Karyawan Berhasil Ditambah!');
    }

    public function delete($id)
    {
        $model = new UserModel();
        $model->delete($id);
        return redirect()->to('/user')->with('sukses', 'User berhasil dihapus');
    }
}
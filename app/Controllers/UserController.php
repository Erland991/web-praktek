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
        
        $filePhoto = $this->request->getFile('photo');
        if ($filePhoto->getError() == 4) {
            $namaPhoto = 'default.png';
        } else {
            $namaPhoto = $filePhoto->getRandomName();
            $filePhoto->move('uploads/profile', $namaPhoto);
        }

        $model->save([
            'nip'          => $this->request->getPost('nip'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'password'     => 'admin123', // Default password
            'role'         => $this->request->getPost('role'),
            'divisi'       => $this->request->getPost('divisi'),
            'photo'        => $namaPhoto,
        ]);
        return redirect()->to('/user')->with('sukses', 'Karyawan Berhasil Ditambah!');
    }

    public function detail($id)
    {
        $model = new UserModel();
        $user = $model->find($id);
        return $this->response->setJSON($user);
    }

    public function delete($id)
    {
        $model = new UserModel();
        $user = $model->find($id);
        
        // Hapus foto jika bukan default
        if ($user['photo'] != 'default.png') {
            if (file_exists('uploads/profile/' . $user['photo'])) {
                unlink('uploads/profile/' . $user['photo']);
            }
        }

        $model->delete($id);
        return redirect()->to('/user')->with('sukses', 'User berhasil dihapus');
    }
}
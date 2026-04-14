<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        // Pastikan nama file sesuai dengan yang kamu simpan di Views
        return view('login_v'); 
    }

    public function login()
    {
        $session = session();
        $model   = new \App\Models\UserModel();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $role_pilihan = $this->request->getPost('role_akses'); 
        
        $user = $model->where('username', $username)->first();

        if ($user) {
            // Cek Kesesuaian Role (Case Insensitive)
            if (strcasecmp($user['role'], $role_pilihan) !== 0) {
                return redirect()->back()->with('error', "Akun tidak terdaftar sebagai $role_pilihan");
            }

            // Verifikasi Password (Mendukung Hash & Plain Text untuk migrasi)
            if (password_verify($password, $user['password']) || $password == $user['password']) {
                $session->set([
                    'id'           => $user['id'],
                    'username'     => $user['username'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'role'         => $user['role'],
                    'logged_in'    => true,
                ]);

                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()->with('error', 'Password Salah');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak ditemukan');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
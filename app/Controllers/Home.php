<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Jika sudah login, langsung lempar ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('login_v'); 
    }

    public function login()
    {
        $session  = session();
        $model    = new \App\Models\UserModel();
        
        // Mengambil input dari form login_v.php
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $role_pilihan = $this->request->getPost('role_akses'); // Ini dari radio button

        $user = $model->where('username', $username)->first();

        if ($user) {
            // CEK 1: Apakah Role yang dipilih di form sesuai dengan Role di Database?
            if ($user['role'] !== $role_pilihan) {
                return redirect()->back()->with('error', "Maaf, akun ini tidak terdaftar sebagai $role_pilihan");
            }

            // CEK 2: Password (Bypass sementara dengan admin123)
            if ($password == 'admin123') { 
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
<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login_action()
    {
        $session = session();
        $model = new UserModel();

        $user = $this->request->getPost('username');
        $pass = $this->request->getPost('password');
        $dataUser = $model->where('username', $user)->first();

        if ($dataUser) {

            if ($pass === $dataUser['password']) {
                $session->set([
                    'username' => $dataUser['username'],
                    'role'     => $dataUser['role'],
                    'logged_in'=> TRUE
                ]);

                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()->with('error', 'Password Salah!');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak terdaftar!');
        }
    }

    // Fungsi logout harus berdiri sendiri di sini (di luar login_action)
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
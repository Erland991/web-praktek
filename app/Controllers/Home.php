<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('landing_v'); 
    }

    public function loginPage()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        
        $data['recaptcha_site_key'] = getenv('RECAPTCHA_SITE_KEY') ?: 'GANTI_DENGAN_SITE_KEY_KAMU';
        
        return view('login_v', $data); 
    }

    public function login()
    {
        $session = session();
        $model   = new \App\Models\UserModel();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $captcha  = $this->request->getPost('g-recaptcha-response');
        
        // Validasi reCAPTCHA ke Server Google
        if (empty($captcha)) {
            return redirect()->back()->with('error', 'Silakan centang "Saya bukan robot" terlebih dahulu!');
        }
        
        $secretKey = getenv('RECAPTCHA_SECRET_KEY');
        $verifyUrl = "https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captcha}";
        $verifyResponse = file_get_contents($verifyUrl);
        $responseData = json_decode($verifyResponse);
        
        if (!$responseData->success) {
            return redirect()->back()->with('error', 'Verifikasi Keamanan Gagal. Silakan coba lagi.');
        }
        
        $user = $model->where('username', $username)->first();

        if ($user) {

            // Verifikasi Password (Mendukung Hash & Plain Text untuk migrasi)
            if (password_verify($password, $user['password']) || $password == $user['password']) {
                $session->set([
                    'id'           => $user['id'],
                    'username'     => $user['username'],
                    'nama_lengkap'  => $user['nama_lengkap'],
                    'jenis_kelamin' => $user['jenis_kelamin'] ?? 'L',
                    'role'          => $user['role'],
                    'photo'         => $user['photo'] ?? 'default.png',
                    'logged_in'     => true,
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

    public function test_db()
    {
        $db = \Config\Database::connect();
        $q = $db->table("aset")->get();
        echo json_encode($q->getResultArray());
    }
}
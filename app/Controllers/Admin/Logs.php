<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LogModel;

class Logs extends BaseController
{
    public function index()
    {
        if (session()->get('role') != 'Admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses Dibatasi');
        }

        $model = new LogModel();
        $data['logs'] = $model->orderBy('created_at', 'DESC')->findAll(100); // Limit 100 logs

        return view('admin/logs_v', $data);
    }

    public function delete($id)
    {
        if (session()->get('role') != 'Admin') return redirect()->to('/dashboard');
        
        $model = new LogModel();
        $model->delete($id);
        
        return redirect()->to('/admin/logs')->with('sukses', 'Log berhasil dihapus!');
    }

    public function clear()
    {
        if (session()->get('role') != 'Admin') return redirect()->to('/dashboard');
        
        // Truncate table
        $db = \Config\Database::connect();
        $db->table('system_logs')->truncate();
        
        return redirect()->to('/admin/logs')->with('sukses', 'Semua log aktivitas berhasil dibersihkan!');
    }
}

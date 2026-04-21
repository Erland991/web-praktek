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
}

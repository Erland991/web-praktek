<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LogModel;

class Approval extends BaseController
{
    public function index()
    {
        if (session()->get('role') != 'Admin') return redirect()->to('/dashboard');

        $db = \Config\Database::connect();
        
        // Ambil progress yang is_approved = 0 (Pending)
        $data['pending'] = $db->table('progres_log')
                             ->select('progres_log.*, aplikasi_master.nama_app, users.nama_lengkap as pic_name')
                             ->join('aplikasi_master', 'aplikasi_master.id = progres_log.aplikasi_id')
                             ->join('users', 'users.id = progres_log.user_id')
                             ->where('is_approved', 0)
                             ->orderBy('tgl_update', 'DESC')
                             ->get()->getResultArray();

        return view('admin/approval_v', $data);
    }

    public function action($id, $status)
    {
        $db = \Config\Database::connect();
        $komentar = $this->request->getPost('komentar');

        $db->table('progres_log')
           ->where('id', $id)
           ->update([
               'is_approved'    => $status, // 1: Approve, 2: Reject
               'komentar_admin' => $komentar,
               'updated_at'     => date('Y-m-d H:i:s')
           ]);

        $statusText = ($status == 1) ? 'APPROVE' : 'REJECT';
        (new LogModel())->record($statusText . ' PROGRESS', 'Admin meninjau progress ID: ' . $id);

        return redirect()->back()->with('sukses', 'Status progress berhasil diperbarui.');
    }
}

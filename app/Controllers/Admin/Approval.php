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
        
        // Tahap 1: Menunggu Persetujuan Kepala Divisi
        $data['pending_stage1'] = $db->table('progres_log')
                                     ->select('progres_log.*, aplikasi_master.nama_app, users.nama_lengkap as pic_name, users.divisi as pic_divisi, master_cobit_19.nama_proses as tahapan')
                                     ->join('aplikasi_master', 'aplikasi_master.id = progres_log.aplikasi_id', 'left')
                                     ->join('users', 'users.id = progres_log.user_id', 'left')
                                     ->join('master_cobit_19', 'master_cobit_19.id = progres_log.cobit_id', 'left')
                                     ->where('is_approved', 0)
                                     ->orderBy('tgl_update', 'DESC')
                                     ->get()->getResultArray();

        // Tahap 2: Menunggu Persetujuan IT Admin / PMO
        $data['pending_stage2'] = $db->table('progres_log')
                                     ->select('progres_log.*, aplikasi_master.nama_app, users.nama_lengkap as pic_name, users.divisi as pic_divisi, master_cobit_19.nama_proses as tahapan')
                                     ->join('aplikasi_master', 'aplikasi_master.id = progres_log.aplikasi_id', 'left')
                                     ->join('users', 'users.id = progres_log.user_id', 'left')
                                     ->join('master_cobit_19', 'master_cobit_19.id = progres_log.cobit_id', 'left')
                                     ->where('is_approved', 1)
                                     ->orderBy('tgl_update', 'DESC')
                                     ->get()->getResultArray();

        // Riwayat Persetujuan
        $data['history'] = $db->table('progres_log')
                              ->select('progres_log.*, aplikasi_master.nama_app, users.nama_lengkap as pic_name, users.divisi as pic_divisi, master_cobit_19.nama_proses as tahapan')
                              ->join('aplikasi_master', 'aplikasi_master.id = progres_log.aplikasi_id', 'left')
                              ->join('users', 'users.id = progres_log.user_id', 'left')
                              ->join('master_cobit_19', 'master_cobit_19.id = progres_log.cobit_id', 'left')
                              ->whereIn('is_approved', [2, 3, 4])
                              ->orderBy('updated_at', 'DESC')
                              ->get()->getResultArray();

        return view('admin/approval_v', $data);
    }

    public function action($id, $status)
    {
        if (session()->get('role') != 'Admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $db = \Config\Database::connect();
        $komentar = $this->request->getPost('komentar');

        $db->table('progres_log')
           ->where('id', $id)
           ->update([
               'is_approved'    => $status, // 1: Kadiv Approve, 2: Final Approve, 3: Kadiv Reject, 4: Admin Reject
               'komentar_admin' => $komentar,
               'updated_at'     => date('Y-m-d H:i:s')
           ]);

        $statusText = '';
        if ($status == 1) $statusText = 'APPROVE KADIV (TAHAP 1)';
        elseif ($status == 2) $statusText = 'APPROVE FINAL (TAHAP 2)';
        elseif ($status == 3) $statusText = 'REJECT KADIV (TAHAP 1)';
        elseif ($status == 4) $statusText = 'REJECT FINAL (TAHAP 2)';

        (new LogModel())->record($statusText, 'Meninjau progres log ID: ' . $id . '. Catatan: ' . $komentar);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Status progress berhasil diperbarui ke: ' . $statusText
            ]);
        }

        return redirect()->back()->with('sukses', 'Status progress berhasil diperbarui.');
    }
}

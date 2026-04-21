<?php

namespace App\Controllers;

use App\Models\AppMasterModel;
use App\Models\LogModel;

class Progress extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) return redirect()->to('/');

        $model = new AppMasterModel();
        $db = \Config\Database::connect();
        
        // Ambil aplikasi yang ditugaskan ke user ini
        $builder = $model->select('aplikasi_master.*, divisi.nama_divisi')
                         ->join('divisi', 'divisi.id = aplikasi_master.divisi_id', 'left');
        
        if (session()->get('role') == 'User') {
            $builder->where('pic_id', session()->get('id'));
        }

        $apps = $builder->findAll();

        // Ambil history progress terakhir untuk masing-masing app
        foreach ($apps as &$app) {
            $lastProgress = $db->table('progres_log')
                               ->where('aplikasi_id', $app['id'])
                               ->orderBy('tgl_update', 'DESC')
                               ->get()->getRowArray();
            $app['last_percent'] = $lastProgress['persentase'] ?? 0;
            $app['last_status']  = $lastProgress['is_approved'] ?? 0; // 0: Pending, 1: Approved, 2: Rejected
        }

        $cobitPoints = $db->table('master_cobit_19')->get()->getResultArray();
        
        return view('user/progress_v', [
            'apps' => $apps,
            'cobit' => $cobitPoints
        ]);
    }

    public function update()
    {
        $db = \Config\Database::connect();
        $aplikasi_id = $this->request->getPost('aplikasi_id');
        $persentase  = $this->request->getPost('persentase');
        $pesan       = $this->request->getPost('pesan');

        // Handle File Upload
        $file = $this->request->getFile('lampiran');
        $fileName = null;
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/progress', $fileName);
        }

        $db->table('progres_log')->insert([
            'aplikasi_id'   => $aplikasi_id,
            'user_id'       => session()->get('id'),
            'cobit_id'      => $this->request->getPost('cobit_id'),
            'pesan_update'  => $pesan,
            'persentase'    => $persentase,
            'file_lampiran' => $fileName,
            'tgl_update'    => date('Y-m-d H:i:s'),
            'is_approved'   => 0 // Pending
        ]);

        (new LogModel())->record('UPDATE PROGRESS', 'Mengajukan progress aplikasi ID: ' . $aplikasi_id);

        return redirect()->back()->with('sukses', 'Progress berhasil diajukan. Menunggu persetujuan Admin.');
    }
}

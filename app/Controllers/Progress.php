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
            // Cek Modul (Sistem Bobot)
            $modulList = $db->table('aplikasi_modul')->where('aplikasi_id', $app['id'])->get()->getResultArray();
            
            if (count($modulList) > 0) {
                // Kalkulasi Weighted Progress
                $totalBobot = 0;
                $totalProgresTertimbang = 0;
                foreach ($modulList as $m) {
                    $totalBobot += $m['bobot_kesulitan'];
                    $totalProgresTertimbang += ($m['persentase'] * $m['bobot_kesulitan']);
                }
                $app['last_percent'] = ($totalBobot > 0) ? round($totalProgresTertimbang / $totalBobot) : 0;
            } else {
                // Fallback manual persentase lama
                $lastProgress = $db->table('progres_log')
                                   ->where('aplikasi_id', $app['id'])
                                   ->orderBy('tgl_update', 'DESC')
                                   ->get()->getRowArray();
                $app['last_percent'] = $lastProgress['persentase'] ?? 0;
            }

            // Status Laporan Terakhir
            $lastLog = $db->table('progres_log')
                          ->where('aplikasi_id', $app['id'])
                          ->orderBy('tgl_update', 'DESC')
                          ->get()->getRowArray();
            $app['last_status']  = $lastLog['is_approved'] ?? 0;
            $app['modules']      = $modulList;
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

        $modul_id = $this->request->getPost('modul_id');

        // Jika user update spesifik modul, update persentase di tabel modul
        if (!empty($modul_id)) {
            $db->table('aplikasi_modul')->where('id', $modul_id)->update(['persentase' => $persentase]);
        }

        $db->table('progres_log')->insert([
            'aplikasi_id'   => $aplikasi_id,
            'modul_id'      => empty($modul_id) ? null : $modul_id,
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

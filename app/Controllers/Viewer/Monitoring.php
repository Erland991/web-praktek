<?php

namespace App\Controllers\Viewer;

use App\Controllers\BaseController;
use App\Models\AppMasterModel;

class Monitoring extends BaseController
{
    public function index()
    {
        $model = new AppMasterModel();
        $db = \Config\Database::connect();
        $selectedApps = $this->request->getGet('apps');
        
        $query = $model->select('aplikasi_master.*, users.nama_lengkap as pic_name, divisi.nama_divisi')
                       ->join('users', 'users.id = aplikasi_master.pic_id', 'left')
                       ->join('divisi', 'divisi.id = aplikasi_master.divisi_id', 'left');

        if ($selectedApps) {
            $query->whereIn('aplikasi_master.id', $selectedApps);
        }

        $apps = $query->findAll();
        $allApps = $model->findAll();

        foreach ($apps as &$app) {
            $lastProgress = $db->table('progres_log')
                               ->where('aplikasi_id', $app['id'])
                               ->where('is_approved', 1)
                               ->orderBy('tgl_update', 'DESC')
                               ->get()->getRowArray();
            $app['real_percent'] = $lastProgress['persentase'] ?? 0;
            $app['last_update']  = $lastProgress['tgl_update'] ?? '-';
        }

        return view('viewer/monitoring_v', [
            'apps' => $apps,
            'all_apps' => $allApps,
            'selected' => $selectedApps ?? []
        ]);
    }
}

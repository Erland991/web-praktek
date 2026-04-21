<?php

namespace App\Controllers;

class Calendar extends BaseController
{
    public function index()
    {
        return view('calendar_v');
    }

    public function events()
    {
        $db = \Config\Database::connect();
        $updates = $db->table('progres_log')
                      ->select('progres_log.*, aplikasi_master.nama_app')
                      ->join('aplikasi_master', 'aplikasi_master.id = progres_log.aplikasi_id')
                      ->where('is_approved', 1)
                      ->get()->getResultArray();

        $events = [];
        foreach ($updates as $u) {
            $events[] = [
                'title' => '[' . $u['persentase'] . '%] ' . $u['nama_app'],
                'start' => date('Y-m-d', strtotime($u['tgl_update'])),
                'description' => $u['pesan_update'],
                'className'   => 'bg-primary border-0'
            ];
        }

        return $this->response->setJSON($events);
    }
}

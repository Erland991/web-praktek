<?php

namespace App\Controllers;

class DocumentCenter extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $keyword = $this->request->getGet('q');

        $builder = $db->table('progres_log')
                      ->select('progres_log.*, aplikasi_master.nama_app, users.nama_lengkap as pic_name')
                      ->join('aplikasi_master', 'aplikasi_master.id = progres_log.aplikasi_id')
                      ->join('users', 'users.id = progres_log.user_id')
                      ->where('file_lampiran IS NOT NULL')
                      ->where('file_lampiran !=', '')
                      ->where('is_approved', 1); // Hanya dokumen yang sudah divalidasi progress-nya

        if ($keyword) {
            $builder->groupStart()
                    ->like('aplikasi_master.nama_app', $keyword)
                    ->orLike('progres_log.pesan_update', $keyword)
                    ->groupEnd();
        }

        $data['documents'] = $builder->orderBy('tgl_update', 'DESC')->get()->getResultArray();
        $data['q'] = $keyword;

        return view('document_center_v', $data);
    }
}

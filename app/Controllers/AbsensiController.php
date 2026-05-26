<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;

class AbsensiController extends BaseController
{
    private function checkTable()
    {
        $db = \Config\Database::connect();
        if (!$db->tableExists('absensi_kehadiran')) {
            $db->simpleQuery("CREATE TABLE absensi_kehadiran (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                aplikasi_id INT(11) UNSIGNED NULL,
                user_id INT(11) UNSIGNED NOT NULL,
                acara VARCHAR(255) NOT NULL,
                tanggal DATE NOT NULL,
                waktu VARCHAR(100) NOT NULL,
                tempat VARCHAR(255) NOT NULL,
                peserta JSON NULL,
                created_at DATETIME NULL,
                updated_at DATETIME NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }
    }

    public function index($id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->checkTable();
        $db = \Config\Database::connect();
        $absensi = null;
        $app_id = $this->request->getGet('app_id');
        $appData = null;

        if ($id) {
            $absensi = $db->table('absensi_kehadiran')->where('id', $id)->get()->getRowArray();
            if ($absensi) {
                $absensi['peserta'] = json_decode($absensi['peserta'], true);
                $app_id = $absensi['aplikasi_id'];
            }
        }

        if ($app_id) {
            $appData = $db->table('aplikasi_master')
                          ->select('aplikasi_master.*, users.nama_lengkap as pic_name, divisi.nama_divisi')
                          ->join('users', 'users.id = aplikasi_master.pic_id', 'left')
                          ->join('divisi', 'divisi.id = aplikasi_master.divisi_id', 'left')
                          ->where('aplikasi_master.id', $app_id)
                          ->get()->getRowArray();
        }

        if (!$absensi && $appData) {
            $absensi = [
                'tanggal' => date('Y-m-d'),
                'waktu' => date('H:i') . ' - Selesai',
                'tempat' => 'Ruang Rapat / Online',
                'acara' => 'Pembahasan Aplikasi: ' . $appData['nama_app'],
                'peserta' => [
                    ['nama' => session()->get('nama_lengkap'), 'jabatan' => 'Tim IT', 'hp' => '-', 'email' => '-'],
                    ['nama' => $appData['pic_name'] ?? 'PIC', 'jabatan' => 'PIC Proyek', 'hp' => '-', 'email' => '-']
                ]
            ];
        }

        return view('absensi/form_v', [
            'absensi' => $absensi,
            'appData' => $appData,
            'app_id'  => $app_id
        ]);
    }

    public function save()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        
        $pesertaNama = $this->request->getPost('peserta_nama') ?? [];
        $pesertaJabatan = $this->request->getPost('peserta_jabatan') ?? [];
        $pesertaHp = $this->request->getPost('peserta_hp') ?? [];
        $pesertaEmail = $this->request->getPost('peserta_email') ?? [];

        $peserta = [];
        for ($i = 0; $i < count($pesertaNama); $i++) {
            if (!empty(trim($pesertaNama[$i]))) {
                $peserta[] = [
                    'nama' => $pesertaNama[$i],
                    'jabatan' => $pesertaJabatan[$i],
                    'hp' => $pesertaHp[$i],
                    'email' => $pesertaEmail[$i]
                ];
            }
        }

        $data = [
            'aplikasi_id' => $this->request->getPost('aplikasi_id') ?: null,
            'user_id'     => session()->get('id'),
            'acara'       => $this->request->getPost('acara'),
            'tanggal'     => $this->request->getPost('tanggal'),
            'waktu'       => $this->request->getPost('waktu'),
            'tempat'      => $this->request->getPost('tempat'),
            'peserta'     => json_encode($peserta)
        ];

        if ($id) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $db->table('absensi_kehadiran')->where('id', $id)->update($data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $db->table('absensi_kehadiran')->insert($data);
            $id = $db->insertID();
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Daftar Hadir berhasil disimpan!', 'id' => $id]);
    }

    public function list()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->checkTable();
        $db = \Config\Database::connect();
        
        $builder = $db->table('absensi_kehadiran')
                      ->select('absensi_kehadiran.*, aplikasi_master.nama_app')
                      ->join('aplikasi_master', 'aplikasi_master.id = absensi_kehadiran.aplikasi_id', 'left')
                      ->orderBy('absensi_kehadiran.created_at', 'DESC');

        if (session()->get('role') != 'Admin') {
            $builder->where('absensi_kehadiran.user_id', session()->get('id'));
        }

        $data['absensi'] = $builder->get()->getResultArray();
        
        foreach ($data['absensi'] as &$row) {
            $row['peserta'] = json_decode($row['peserta'], true);
        }

        return view('absensi/list_v', $data);
    }

    public function delete($id)
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }
        $db = \Config\Database::connect();
        $db->table('absensi_kehadiran')->where('id', $id)->delete();
        return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }

    public function pdf($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }
        
        $db = \Config\Database::connect();
        $absensi = $db->table('absensi_kehadiran')->where('id', $id)->get()->getRowArray();
        if (!$absensi) {
            return redirect()->to('absensi/list')->with('error', 'Data tidak ditemukan');
        }
        
        $absensi['peserta'] = json_decode($absensi['peserta'], true);
        
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);
        
        // Load the view for PDF
        $html = view('absensi/pdf_v', ['absensi' => $absensi]);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $dompdf->stream("Daftar_Hadir_" . date('Ymd', strtotime($absensi['tanggal'])) . ".pdf", array("Attachment" => false));
    }
}

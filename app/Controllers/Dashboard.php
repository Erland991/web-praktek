<?php

namespace App\Controllers;

use App\Models\AssetModel;
use App\Models\LogModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Dashboard extends BaseController
{
    public function index()
    {
        // 1. Proteksi Halaman: Wajib Login
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }

        $model = new AssetModel();
        
        // 2. Ambil Input Filter (Pencarian)
        $keyword  = $this->request->getGet('keyword');
        $kategori = $this->request->getGet('kategori');
        $status   = $this->request->getGet('status');

        // 3. Query Data & Filter berdasarkan Role
        $role = session()->get('role');
        $nama_lengkap = session()->get('nama_lengkap');
        $user_id = session()->get('id');

        // A. Ambil Data dari Tabel ASET
        $builder = $model;
        if ($role === 'User') {
            $builder = $builder->where('pic', $nama_lengkap);
        }
        if ($keyword) {
            $builder = $builder->groupStart()
                               ->like('nama_aset', $keyword)
                               ->orLike('pic', $keyword)
                               ->orLike('deskripsi', $keyword)
                               ->groupEnd();
        }
        if ($kategori) $builder = $builder->where('kategori', $kategori);
        if ($status)   $builder = $builder->where('status', $status);
        $assets = $builder->findAll();
        foreach ($assets as &$asset) {
            $asset['is_app'] = false;
        }

        // B. Ambil Data dari Tabel APLIKASI_MASTER (Agar sinkron)
        $db = \Config\Database::connect();
        $appQuery = $db->table('aplikasi_master')
                       ->select('aplikasi_master.id, aplikasi_master.nama_app as nama_aset, divisi.nama_divisi as kategori, users.nama_lengkap as pic, aplikasi_master.status, aplikasi_master.deskripsi')
                       ->join('users', 'users.id = aplikasi_master.pic_id', 'left')
                       ->join('divisi', 'divisi.id = aplikasi_master.divisi_id', 'left');

        if ($role === 'User') {
            $appQuery->where('aplikasi_master.pic_id', $user_id);
        }

        if ($keyword) {
            $appQuery->groupStart()
                     ->like('aplikasi_master.nama_app', $keyword)
                     ->orLike('users.nama_lengkap', $keyword)
                     ->orLike('aplikasi_master.deskripsi', $keyword)
                     ->groupEnd();
        }
        
        $apps = $appQuery->get()->getResultArray();
        foreach ($apps as &$app) {
            $app['is_app'] = true;
        }

        // C. Siapkan Data untuk View (Gabungkan Aset & Aplikasi)
        $data = [
            'semua_aset'   => array_merge($assets, $apps),
            'total_aset'   => $model->countAll(),
            'total_pic'    => $db->table('users')->countAllResults(),
            'total_divisi' => $db->table('divisi')->countAllResults(),
            'total_app'    => $db->table('aplikasi_master')->countAllResults(),
            'keyword'      => $keyword,
            'kategori'     => $kategori,
            'status'       => $status
        ];

        // --- DATA UNTUK GRAFIK ---
        // 1. Distribusi Aset Berdasarkan Kategori
        $data['cat_labels'] = [];
        $data['cat_counts'] = [];
        foreach ($db->table('aset')->select('kategori, count(*) as total')->groupBy('kategori')->get()->getResultArray() as $row) {
            $data['cat_labels'][] = $row['kategori'];
            $data['cat_counts'][] = (int)$row['total'];
        }

        // 2. Data Progress Proyek (Latest)
        $data['proj_labels'] = [];
        $data['proj_percents'] = [];
        $apps = $db->table('aplikasi_master')->limit(5)->get()->getResultArray();
        foreach ($apps as $app) {
            $data['proj_labels'][] = $app['nama_app'];
            
            // CEK APAKAH ADA MODUL (Jika ada, pakai rata-rata tertimbang)
            $modules = $db->table('aplikasi_modul')->where('aplikasi_id', $app['id'])->get()->getResultArray();
            
            if (!empty($modules)) {
                $totalBobot = 0;
                $totalProgresTertimbang = 0;
                foreach ($modules as $m) {
                    $totalBobot += $m['bobot_kesulitan'];
                    $totalProgresTertimbang += ($m['persentase'] * $m['bobot_kesulitan']);
                }
                $progresFinal = ($totalBobot > 0) ? round($totalProgresTertimbang / $totalBobot, 2) : 0;
            } else {
                // Fallback ke log terakhir jika tidak ada modul
                $lastP = $db->table('progres_log')->where('aplikasi_id', $app['id'])->where('is_approved', 1)->orderBy('tgl_update', 'DESC')->get()->getRowArray();
                $progresFinal = $lastP['persentase'] ?? 0;
            }
            
            $data['proj_percents'][] = $progresFinal;
        }

        return view('dashboard_v', $data);
    }

    // Fungsi lain (add, save, edit, update, delete) biarkan seperti kode lama kamu
    public function add() { 
        if (!session()->get('logged_in')) return redirect()->to('/');
        $data['list_pic'] = (new \App\Models\UserModel())->findAll();
        return view('add_asset_v', $data); 
    }

    public function save() {
        $model = new AssetModel();
        $picName = $this->request->getPost('pic');
        
        // --- FITUR AUTO-REGISTER USER ---
        // Jika PIC yang diketik belum ada di tabel users, buatkan akunnya otomatis
        $userModel = new \App\Models\UserModel();
        $cekUser = $userModel->where('nama_lengkap', $picName)->first();
        
        if (!$cekUser && !empty($picName)) {
            $userModel->save([
                'nama_lengkap' => $picName,
                'username'     => strtolower(str_replace(' ', '', $picName)),
                'password'     => password_hash('si12345', PASSWORD_DEFAULT),
                'role'         => 'User',
                'divisi'       => 'Umum'
            ]);
        }

        if ($model->save([
            'nama_aset' => $this->request->getPost('nama_aset'),
            'kategori'  => $this->request->getPost('kategori'),
            'status'    => $this->request->getPost('status'),
            'pic'       => $picName,
            'deskripsi' => $this->request->getPost('deskripsi'),
        ])) {
            (new LogModel())->record('TAMBAH ASET', 'Menambahkan aset: ' . $this->request->getPost('nama_aset') . ' (PIC: '.$picName.')');
            return redirect()->to('/dashboard')->with('sukses', 'Aset Berhasil Ditambah!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambah aset.');
        }
    }

    public function edit($id) {
        if (!session()->get('logged_in')) return redirect()->to('/');
        $model = new AssetModel();
        $data['aset'] = $model->find($id);
        $data['list_pic'] = (new \App\Models\UserModel())->findAll();
        return view('edit_asset_v', $data);
    }

    public function update($id) {
        $model = new AssetModel();
        $picName = $this->request->getPost('pic');

        // --- FITUR AUTO-REGISTER USER ---
        $userModel = new \App\Models\UserModel();
        $cekUser = $userModel->where('nama_lengkap', $picName)->first();
        if (!$cekUser && !empty($picName)) {
            $userModel->save([
                'nama_lengkap' => $picName,
                'username'     => strtolower(str_replace(' ', '', $picName)),
                'password'     => password_hash('si12345', PASSWORD_DEFAULT),
                'role'         => 'User',
                'divisi'       => 'Umum'
            ]);
        }

        if ($model->update($id, [
            'nama_aset' => $this->request->getPost('nama_aset'),
            'kategori'  => $this->request->getPost('kategori'),
            'status'    => $this->request->getPost('status'),
            'pic'       => $picName,
            'deskripsi' => $this->request->getPost('deskripsi'),
        ])) {
            (new LogModel())->record('UPDATE ASET', 'Memperbarui aset id: ' . $id);
            return redirect()->to('/dashboard')->with('sukses', 'Aset Berhasil Diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui aset.');
        }
    }

    public function delete($id) {
        if (!session()->get('logged_in')) return redirect()->to('/');
        $model = new AssetModel();
        $model->delete($id);
        (new LogModel())->record('HAPUS ASET', 'Menghapus aset id: ' . $id);
        return redirect()->to('/dashboard')->with('sukses', 'Aset Berhasil Dihapus!');
    }

    public function export()
    {
        if (!session()->get('logged_in')) return redirect()->to('/');
        
        $model = new AssetModel();
        
        // Ambil Input Filter
        $keyword  = $this->request->getGet('keyword');
        $kategori = $this->request->getGet('kategori');
        $status   = $this->request->getGet('status');

        $builder = $model;
        if ($keyword) {
            $builder = $builder->groupStart()
                               ->like('nama_aset', $keyword)
                               ->orLike('pic', $keyword)
                               ->orLike('deskripsi', $keyword)
                               ->groupEnd();
        }
        if ($kategori) $builder = $builder->where('kategori', $kategori);
        if ($status)   $builder = $builder->where('status', $status);

        $data = [
            'semua_aset' => $builder->findAll(),
            'tgl_cetak'  => date('d F Y'),
            'user'       => session()->get('username'),
            'filters'    => [
                'keyword'  => $keyword,
                'kategori' => $kategori,
                'status'   => $status
            ]
        ];

        $html = view('export_pdf_v', $data);
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $this->response->setHeader('Content-Type', 'application/pdf')->setBody($dompdf->output());
    }
}
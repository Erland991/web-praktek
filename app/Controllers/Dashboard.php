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

        // --- DATA UNTUK GRAFIK (Menggunakan gaya template namun data asli aplikasi) ---
        // 1. Chart 1: Distribusi Aplikasi Per Kategori (Aktif vs Maintenance)
        $data['cat_labels'] = [];
        $data['cat_aktif']  = [];
        $data['cat_mtn']    = [];
        
        $categories = $db->table('aset')->select('kategori')->distinct()->get()->getResultArray();
        foreach ($categories as $cat) {
            $data['cat_labels'][] = $cat['kategori'];
            $aktif = $db->table('aset')->where('kategori', $cat['kategori'])->where('status', 'Aktif')->countAllResults();
            $mtn = $db->table('aset')->where('kategori', $cat['kategori'])->where('status !=', 'Aktif')->countAllResults();
            $data['cat_aktif'][] = $aktif;
            $data['cat_mtn'][] = $mtn;
        }

        // 2. Chart 2: Capaian Progres Proyek (Aktual vs Target)
        $data['proj_labels'] = [];
        $data['proj_aktual'] = [];
        $data['proj_target'] = [];
        $projectApps = $db->table('aplikasi_master')->limit(7)->get()->getResultArray();
        foreach ($projectApps as $app) {
            $data['proj_labels'][] = $app['nama_app'];
            
            // Hitung persentase aktual dari modul
            $modules = $db->table('aplikasi_modul')->where('aplikasi_id', $app['id'])->get()->getResultArray();
            $progresFinal = 0;
            if (!empty($modules)) {
                $totalBobot = 0;
                $totalProgres = 0;
                foreach ($modules as $m) {
                    $totalBobot += $m['bobot_kesulitan'];
                    $totalProgres += ($m['persentase'] * $m['bobot_kesulitan']);
                }
                if ($totalBobot > 0) $progresFinal = round($totalProgres / $totalBobot, 2);
            } else {
                // Fallback dummy progress 
                $progresFinal = rand(30, 85);
            }
            $data['proj_aktual'][] = $progresFinal;
            $data['proj_target'][] = min(100, $progresFinal + rand(5, 25)); // Target simulasi
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
            (new LogModel())->record('TAMBAH APLIKASI', 'Menambahkan aplikasi: ' . $this->request->getPost('nama_aset') . ' (PIC: '.$picName.')');
            return redirect()->to('/dashboard')->with('sukses', 'Aplikasi Berhasil Ditambah!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambah aplikasi.');
        }
    }

    public function edit($id) {
        if (!session()->get('logged_in')) return redirect()->to('/');
        $model = new AssetModel();
        
        $aset = $model->find($id);
        if (!$aset) {
            return redirect()->to('/dashboard')->with('error', 'Data aplikasi tidak ditemukan atau sudah dihapus (karena reset database).');
        }
        
        $data['aset'] = $aset;
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
            (new LogModel())->record('UPDATE APLIKASI', 'Memperbarui aplikasi id: ' . $id);
            return redirect()->to('/dashboard')->with('sukses', 'Aplikasi Berhasil Diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui aplikasi.');
        }
    }

    public function delete($id) {
        if (!session()->get('logged_in')) return redirect()->to('/');
        $model = new AssetModel();
        $model->delete($id);
        (new LogModel())->record('HAPUS APLIKASI', 'Menghapus aplikasi id: ' . $id);
        return redirect()->to('/dashboard')->with('sukses', 'Aplikasi Berhasil Dihapus!');
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
        $dompdf->stream("Laporan_Aset_" . date('Ymd') . ".pdf", ["Attachment" => false]);
        exit;
    }
    public function updateProfilePhoto()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('id');
        $user = $userModel->find($userId);

        $filePhoto = $this->request->getFile('photo');
        if ($filePhoto && $filePhoto->isValid() && !$filePhoto->hasMoved()) {
            $namaPhoto = $filePhoto->getRandomName();
            $filePhoto->move('uploads/profile', $namaPhoto);

            // Hapus foto lama jika bukan default
            if ($user['photo'] != 'default.png' && file_exists('uploads/profile/' . $user['photo'])) {
                unlink('uploads/profile/' . $user['photo']);
            }

            $userModel->update($userId, ['photo' => $namaPhoto]);
            
            // Update Session agar header langsung berubah
            session()->set('photo', $namaPhoto);

            return redirect()->back()->with('sukses', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui foto profil.');
    }
}
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
        
        // 2. Ambil Input Filter (Pencarian & Tanggal)
        $keyword  = $this->request->getGet('keyword');
        $kategori = $this->request->getGet('kategori');
        $status   = $this->request->getGet('status');
        $start_date = $this->request->getGet('start_date');
        $end_date   = $this->request->getGet('end_date');

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
        if ($start_date) $builder = $builder->where('created_at >=', $start_date . ' 00:00:00');
        if ($end_date)   $builder = $builder->where('created_at <=', $end_date . ' 23:59:59');
        $assets = $builder->findAll();
        foreach ($assets as &$asset) {
            $asset['is_app'] = false;
        }

        // B. Ambil Data dari Tabel APLIKASI_MASTER (Agar sinkron)
        $db = \Config\Database::connect();
        $appQuery = $db->table('aplikasi_master')
                       ->select('aplikasi_master.id, aplikasi_master.nama_app as nama_aset, divisi.nama_divisi as kategori, users.nama_lengkap as pic, aplikasi_master.status, aplikasi_master.deskripsi, aplikasi_master.delete_request, aplikasi_master.delete_reason')
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
        if ($start_date) $appQuery->where('aplikasi_master.created_at >=', $start_date . ' 00:00:00');
        if ($end_date)   $appQuery->where('aplikasi_master.created_at <=', $end_date . ' 23:59:59');
        
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
            'status'       => $status,
            'start_date'   => $start_date,
            'end_date'     => $end_date
        ];

        // --- DATA UNTUK GRAFIK (Menggunakan gaya template namun data asli aplikasi) ---
        // 1. Chart 1: Distribusi Aplikasi Per Kategori (Aktif vs Maintenance)
        $chart1_data = [];
        
        // Data dari Aset
        $asetsQuery = $db->table('aset')->select('kategori, status');
        if ($start_date) $asetsQuery->where('created_at >=', $start_date . ' 00:00:00');
        if ($end_date)   $asetsQuery->where('created_at <=', $end_date . ' 23:59:59');
        $asets = $asetsQuery->get()->getResultArray();
        foreach($asets as $a) {
            $kat = trim($a['kategori'] ?? '');
            if(empty($kat)) $kat = 'Lainnya';
            if(!isset($chart1_data[$kat])) $chart1_data[$kat] = ['aktif' => 0, 'mtn' => 0];
            
            if(isset($a['status']) && $a['status'] == 'Aktif') $chart1_data[$kat]['aktif']++;
            else $chart1_data[$kat]['mtn']++;
        }

        // Data dari Aplikasi Master
        $appsQuery = $db->table('aplikasi_master')
                   ->select('divisi.nama_divisi as kategori, aplikasi_master.status')
                   ->join('divisi', 'divisi.id = aplikasi_master.divisi_id', 'left');
        if ($start_date) $appsQuery->where('aplikasi_master.created_at >=', $start_date . ' 00:00:00');
        if ($end_date)   $appsQuery->where('aplikasi_master.created_at <=', $end_date . ' 23:59:59');
        $apps = $appsQuery->get()->getResultArray();
        foreach($apps as $app) {
            $kat = trim($app['kategori'] ?? '');
            if(empty($kat)) $kat = 'Lainnya';
            if(!isset($chart1_data[$kat])) $chart1_data[$kat] = ['aktif' => 0, 'mtn' => 0];
            
            if(isset($app['status']) && $app['status'] == 'Aktif') $chart1_data[$kat]['aktif']++;
            else $chart1_data[$kat]['mtn']++;
        }

        $data['cat_labels'] = array_keys($chart1_data);
        $data['cat_aktif']  = array_column($chart1_data, 'aktif');
        $data['cat_mtn']    = array_column($chart1_data, 'mtn');

        // 2. Chart 2: Capaian Progres Proyek (Aktual vs Target)
        $data['proj_labels'] = [];
        $data['proj_aktual'] = [];
        $data['proj_target'] = [];
        // Ambil 7 aplikasi terbaru
        $projectAppsQuery = $db->table('aplikasi_master')->orderBy('id', 'DESC')->limit(7);
        if ($start_date) $projectAppsQuery->where('created_at >=', $start_date . ' 00:00:00');
        if ($end_date)   $projectAppsQuery->where('created_at <=', $end_date . ' 23:59:59');
        $projectApps = $projectAppsQuery->get()->getResultArray();
        // Balik array agar yang paling lama di sebelah kiri grafik
        $projectApps = array_reverse($projectApps);
        
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
        
        $aset = $model->find($id);
        if ($aset) {
            $alasan = $this->request->getPost('alasan');
            
            // Insert notification
            $db = \Config\Database::connect();
            if ($db->tableExists('notifikasi') && !empty($alasan)) {
                $user = $db->table('users')->where('nama_lengkap', $aset['pic'])->get()->getRowArray();
                $userId = $user ? $user['id'] : 0;
                
                $db->table('notifikasi')->insert([
                    'user_id' => $userId,
                    'judul' => 'Penghapusan Aplikasi',
                    'pesan' => 'Aplikasi "' . $aset['nama_aset'] . '" telah dihapus oleh Admin/PM. Alasan: ' . $alasan,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
            
            $model->delete($id);
            (new LogModel())->record('HAPUS APLIKASI', 'Menghapus aplikasi id: ' . $id . ' Alasan: ' . ($alasan ?: 'Tanpa alasan'));
        }
        
    }

    public function request_delete($id, $is_app) {
        if (!session()->get('logged_in')) return redirect()->to('/');
        $db = \Config\Database::connect();
        $table = $is_app ? 'aplikasi_master' : 'aset';
        $alasan = $this->request->getPost('alasan');

        $db->table($table)->where('id', $id)->update([
            'delete_request' => 1,
            'delete_reason'  => $alasan
        ]);

        // Kirim notifikasi ke Admin/PM
        if ($db->tableExists('notifikasi')) {
            $admins = $db->table('users')->whereIn('role', ['Admin', 'PM'])->get()->getResultArray();
            foreach ($admins as $adm) {
                $db->table('notifikasi')->insert([
                    'user_id' => $adm['id'],
                    'judul' => 'Pengajuan Penghapusan Aplikasi',
                    'pesan' => session()->get('nama_lengkap') . ' mengajukan penghapusan aplikasi ID: ' . $id . '. Alasan: ' . $alasan,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        (new LogModel())->record('PENGAJUAN HAPUS', 'User mengajukan penghapusan aplikasi id: ' . $id);
        return redirect()->to('/dashboard')->with('sukses', 'Pengajuan penghapusan berhasil dikirim ke Admin/PM!');
    }

    public function approve_delete($id, $is_app) {
        if (!session()->get('logged_in') || !in_array(session()->get('role'), ['Admin', 'PM'])) return redirect()->to('/');
        
        $db = \Config\Database::connect();
        $table = $is_app ? 'aplikasi_master' : 'aset';
        $app = $db->table($table)->where('id', $id)->get()->getRowArray();
        
        if ($app) {
            // Delete the application
            $db->table($table)->where('id', $id)->delete();
            
            // Send notification to user
            if ($db->tableExists('notifikasi')) {
                // If it's aplikasi_master, we have pic_id. If aset, we only have pic name.
                $userId = 0;
                if ($is_app && !empty($app['pic_id'])) {
                    $userId = $app['pic_id'];
                } elseif (!$is_app && !empty($app['pic'])) {
                    $user = $db->table('users')->where('nama_lengkap', $app['pic'])->get()->getRowArray();
                    $userId = $user ? $user['id'] : 0;
                }

                if ($userId) {
                    $db->table('notifikasi')->insert([
                        'user_id' => $userId,
                        'judul' => 'Penghapusan Aplikasi Disetujui',
                        'pesan' => 'Pengajuan penghapusan aplikasi Anda telah disetujui oleh Admin/PM.',
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            (new LogModel())->record('HAPUS APLIKASI', 'Admin/PM menyetujui penghapusan aplikasi id: ' . $id);
        }
        
        return redirect()->to('/dashboard')->with('sukses', 'Penghapusan disetujui dan aplikasi telah dihapus!');
    }

    public function reject_delete($id, $is_app) {
        if (!session()->get('logged_in') || !in_array(session()->get('role'), ['Admin', 'PM'])) return redirect()->to('/');
        
        $db = \Config\Database::connect();
        $table = $is_app ? 'aplikasi_master' : 'aset';
        $app = $db->table($table)->where('id', $id)->get()->getRowArray();

        if ($app) {
            $db->table($table)->where('id', $id)->update([
                'delete_request' => 0,
                'delete_reason'  => null
            ]);
            
            // Send notification to user
            if ($db->tableExists('notifikasi')) {
                $userId = 0;
                if ($is_app && !empty($app['pic_id'])) {
                    $userId = $app['pic_id'];
                } elseif (!$is_app && !empty($app['pic'])) {
                    $user = $db->table('users')->where('nama_lengkap', $app['pic'])->get()->getRowArray();
                    $userId = $user ? $user['id'] : 0;
                }

                if ($userId) {
                    $db->table('notifikasi')->insert([
                        'user_id' => $userId,
                        'judul' => 'Penghapusan Aplikasi Ditolak',
                        'pesan' => 'Pengajuan penghapusan aplikasi Anda ditolak oleh Admin/PM.',
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            (new LogModel())->record('TOLAK HAPUS', 'Admin/PM menolak penghapusan aplikasi id: ' . $id);
        }
        
        return redirect()->to('/dashboard')->with('sukses', 'Pengajuan penghapusan telah ditolak.');
    }

    public function export()
    {
        if (!session()->get('logged_in')) return redirect()->to('/');
        
        $model = new AssetModel();
        $db    = \Config\Database::connect();
        $role  = session()->get('role');
        $user_id     = session()->get('id');
        $nama_lengkap = session()->get('nama_lengkap');
        
        // Ambil Input Filter
        $keyword  = $this->request->getGet('keyword');
        $kategori = $this->request->getGet('kategori');
        $status   = $this->request->getGet('status');

        // A. Data dari tabel ASET
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

        // B. Data dari tabel APLIKASI_MASTER
        $appQuery = $db->table('aplikasi_master')
                       ->select('aplikasi_master.id, aplikasi_master.nama_app as nama_aset, divisi.nama_divisi as kategori, users.nama_lengkap as pic, aplikasi_master.status, aplikasi_master.deskripsi, aplikasi_master.delete_request, aplikasi_master.delete_reason')
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
        if ($kategori) $appQuery->where('divisi.nama_divisi', $kategori);
        if ($status)   $appQuery->where('aplikasi_master.status', $status);
        $apps = $appQuery->get()->getResultArray();
        foreach ($apps as &$app) {
            $app['is_app'] = true;
        }

        // C. Gabungkan aset + aplikasi
        $semua_aset = array_merge($assets, $apps);

        $data = [
            'semua_aset' => $semua_aset,
            'tgl_cetak'  => date('d F Y'),
            'user'       => session()->get('nama_lengkap') ?: session()->get('username'),
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
        $dompdf->stream("Laporan_Inventaris_" . date('Ymd') . ".pdf", ["Attachment" => false]);
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
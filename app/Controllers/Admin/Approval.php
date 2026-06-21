<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LogModel;

class Approval extends BaseController
{
    public function memo_persetujuan()
    {
        if (!session()->get('logged_in')) return redirect()->to('/');

        $db     = \Config\Database::connect();
        $userId = session()->get('id');
        $role   = session()->get('role');

        $data['pending_memo'] = [];
        if ($db->tableExists('notula_rapat')) {
            $builder = $db->table('notula_rapat')
                ->select('notula_rapat.*, aplikasi_master.nama_app, creator.nama_lengkap as dibuat_oleh,
                          u1.nama_lengkap as penyetuju1, u2.nama_lengkap as penyetuju2')
                ->join('aplikasi_master', 'aplikasi_master.id = notula_rapat.aplikasi_id', 'left')
                ->join('users as creator', 'creator.id = notula_rapat.user_id', 'left')
                ->join('users as u1', 'u1.id = notula_rapat.approval_user1_id', 'left')
                ->join('users as u2', 'u2.id = notula_rapat.approval_user2_id', 'left')
                ->where('notula_rapat.is_final', 0);

            // Semua role HANYA melihat memo yang menunjuk mereka sebagai penyetuju
            $builder->groupStart()
                ->groupStart()
                    ->where('notula_rapat.approval_user1_id', $userId)
                    ->where('notula_rapat.is_approved1', 0)
                ->groupEnd()
                ->orGroupStart()
                    ->where('notula_rapat.approval_user2_id', $userId)
                    ->where('notula_rapat.is_approved2', 0)
                ->groupEnd()
            ->groupEnd();

            $data['pending_memo'] = $builder->orderBy('notula_rapat.created_at', 'DESC')->get()->getResultArray();
        }

        return view('admin/memo_persetujuan_v', $data);
    }

    public function index()
    {
        if (session()->get('role') != 'Admin' && session()->get('role') != 'PM') return redirect()->to('/dashboard');

        $db     = \Config\Database::connect();
        $userId = session()->get('id');
        $role   = session()->get('role');

        // Tahap 1: Menunggu Persetujuan Kepala Divisi (Progress)
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

        // Riwayat Persetujuan Progress
        $data['history'] = $db->table('progres_log')
                              ->select('progres_log.*, aplikasi_master.nama_app, users.nama_lengkap as pic_name, users.divisi as pic_divisi, master_cobit_19.nama_proses as tahapan')
                              ->join('aplikasi_master', 'aplikasi_master.id = progres_log.aplikasi_id', 'left')
                              ->join('users', 'users.id = progres_log.user_id', 'left')
                              ->join('master_cobit_19', 'master_cobit_19.id = progres_log.cobit_id', 'left')
                              ->whereIn('is_approved', [2, 3, 4])
                              ->orderBy('updated_at', 'DESC')
                              ->get()->getResultArray();

        // ── Notula/Memo menunggu tanda tangan ──
        $data['pending_notula'] = [];
        if ($db->tableExists('notula_rapat')) {
            $builder = $db->table('notula_rapat')
                ->select('notula_rapat.*, aplikasi_master.nama_app, creator.nama_lengkap as dibuat_oleh,
                          u1.nama_lengkap as penyetuju1, u2.nama_lengkap as penyetuju2')
                ->join('aplikasi_master', 'aplikasi_master.id = notula_rapat.aplikasi_id', 'left')
                ->join('users as creator', 'creator.id = notula_rapat.user_id', 'left')
                ->join('users as u1', 'u1.id = notula_rapat.approval_user1_id', 'left')
                ->join('users as u2', 'u2.id = notula_rapat.approval_user2_id', 'left')
                ->where('notula_rapat.is_final', 0);

            if ($role === 'Admin') {
                // Admin lihat semua notula yang belum final dan masih ada pending
                $builder->groupStart()
                    ->where('notula_rapat.is_approved1', 0)
                    ->orWhere('notula_rapat.is_approved2', 0)
                    ->groupEnd();
            } else {
                // PM: hanya yang mereka ditunjuk sebagai penyetuju
                $builder->groupStart()
                    ->groupStart()
                        ->where('notula_rapat.approval_user1_id', $userId)
                        ->where('notula_rapat.is_approved1', 0)
                    ->groupEnd()
                    ->orGroupStart()
                        ->where('notula_rapat.approval_user2_id', $userId)
                        ->where('notula_rapat.is_approved2', 0)
                    ->groupEnd()
                ->groupEnd();
            }

            $data['pending_notula'] = $builder->orderBy('notula_rapat.created_at', 'DESC')->get()->getResultArray();
        }

        return view('admin/approval_v', $data);
    }

    public function approve_notula($id, $slot)
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $db     = \Config\Database::connect();
        $notula = $db->table('notula_rapat')->where('id', $id)->get()->getRowArray();

        if (!$notula) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Notula tidak ditemukan.']);
        }

        $userId = session()->get('id');
        $role   = session()->get('role');
        $updateData = ['updated_at' => date('Y-m-d H:i:s')];

        if ($slot == 1) {
            if ($notula['is_approved1']) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Sudah disetujui sebelumnya.']);
            }
            if ($role !== 'Admin' && $userId != $notula['approval_user1_id']) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Anda tidak berwenang.']);
            }
            $updateData['is_approved1'] = 1;
        } elseif ($slot == 2) {
            if ($notula['is_approved2']) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Sudah disetujui sebelumnya.']);
            }
            if ($role !== 'Admin' && $userId != $notula['approval_user2_id']) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Anda tidak berwenang.']);
            }
            $updateData['is_approved2'] = 1;
        }

        // Jika semua slot sudah approved → set final
        $newApproved1 = ($slot == 1) ? 1 : $notula['is_approved1'];
        $newApproved2 = ($slot == 2) ? 1 : $notula['is_approved2'];
        $needsBoth    = !empty($notula['approval_user2_id']);

        if ($newApproved1 && (!$needsBoth || $newApproved2)) {
            $updateData['is_final']   = 1;
            $updateData['doc_status'] = 'approved';
        }

        $db->table('notula_rapat')->where('id', $id)->update($updateData);
        (new LogModel())->record('APPROVE NOTULA', 'Menyetujui notula ID: ' . $id . ' slot-' . $slot);

        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Notula berhasil disetujui.',
            'is_final' => $updateData['is_final'] ?? 0
        ]);
    }

    public function action($id, $status)
    {
        if (session()->get('role') != 'Admin' && session()->get('role') != 'PM') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $db       = \Config\Database::connect();
        $komentar = $this->request->getPost('komentar');

        $db->table('progres_log')
           ->where('id', $id)
           ->update([
               'is_approved'    => $status,
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

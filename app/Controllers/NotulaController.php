<?php

namespace App\Controllers;

use App\Models\LogModel;
use App\Models\UserModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class NotulaController extends BaseController
{
    public function index($id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->checkTable();
        $db = \Config\Database::connect();
        $notula = null;
        $app_id = $this->request->getGet('app_id');
        $appData = null;

        if ($id) {
            $notula = $db->table('notula_rapat')->where('id', $id)->get()->getRowArray();
            if ($notula) {
                $notula['hasil_pembahasan'] = json_decode($notula['hasil_pembahasan'], true);
                $app_id = $notula['aplikasi_id'];
            }
        }

        // Fetch application details to auto-fill the form
        if ($app_id) {
            $appData = $db->table('aplikasi_master')
                          ->select('aplikasi_master.*, users.nama_lengkap as pic_name, divisi.nama_divisi')
                          ->join('users', 'users.id = aplikasi_master.pic_id', 'left')
                          ->join('divisi', 'divisi.id = aplikasi_master.divisi_id', 'left')
                          ->where('aplikasi_master.id', $app_id)
                          ->get()->getRowArray();
        }

        // Approval user lookup for dropdowns
        $users = $db->table('users')->select('id, nama_lengkap, role')->orderBy('nama_lengkap')->get()->getResultArray();

        // Auto-fill defaults for new notula
        if (!$notula && $appData) {
            $isQuick = $this->request->getGet('quick');

            $defaultHasil = $isQuick ? [
                ['item'=>'01', 'hasil'=>'Ringkasan hasil rapat dan keputusan utama', 'pic'=>$appData['pic_name'] ?? '', 'target'=>date('Y-m-d', strtotime('+7 days'))],
                ['item'=>'02', 'hasil'=>'Tindak lanjut sistem / aplikasi yang dibahas', 'pic'=>$appData['pic_name'] ?? '', 'target'=>date('Y-m-d', strtotime('+14 days'))],
                ['item'=>'03', 'hasil'=>'Rencana komunikasi dan notifikasi kepada pemangku kepentingan', 'pic'=>'Tim IT', 'target'=>date('Y-m-d', strtotime('+21 days'))],
            ] : [['item'=>'01', 'hasil'=>'Review Progress Aplikasi ' . $appData['nama_app'], 'pic'=>$appData['pic_name'] ?? '', 'target'=>'']];

            $notula = [
                'tanggal' => date('Y-m-d'),
                'tempat' => 'Ruang Rapat Utama',
                'agenda' => $isQuick ? 'Quick MoM: ' . $appData['nama_app'] : 'Pembahasan Proyek: ' . $appData['nama_app'],
                'peserta' => session()->get('nama_lengkap') . ' (IT), ' . ($appData['pic_name'] ?? 'PM') . ' (PM), Tim ' . ($appData['nama_divisi'] ?? 'Terkait'),
                'nama_disiapkan' => session()->get('nama_lengkap'),
                'jabatan_disiapkan' => session()->get('role'),
                'approval_method' => 'manual',
                'doc_status' => $isQuick ? 'draft' : 'draft',
                'nama_setuju1' => $appData['pic_name'] ?? '',
                'jabatan_setuju1' => 'Project Manager',
                'nama_setuju2' => '',
                'jabatan_setuju2' => 'Manajer Divisi ' . ($appData['nama_divisi'] ?? ''),
                'hasil_pembahasan' => $defaultHasil,
                'attendance_list' => [['name' => session()->get('nama_lengkap'), 'role' => session()->get('role'), 'status' => 'Hadir']],
            ];
        }

        if ($notula && !empty($notula['approval_history'])) {
            $notula['approval_history'] = json_decode($notula['approval_history'], true) ?: [];
        } else {
            $notula['approval_history'] = [];
        }

        $data = [
            'doc_number' => 'FP-MR07-04',
            'revision' => '00',
            'notula' => $notula,
            'app_id' => $app_id,
            'users' => $users,
        ];

        return view('notula/notula_v', $data);
    }

    private function checkTable()
    {
        $db = \Config\Database::connect();
        if (!$db->tableExists('notula_rapat')) {
            $forge = \Config\Database::forge();
            $fields = [
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'aplikasi_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
                'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'tanggal' => ['type' => 'DATE'],
                'tempat' => ['type' => 'VARCHAR', 'constraint' => '255'],
                'agenda' => ['type' => 'VARCHAR', 'constraint' => '255'],
                'peserta' => ['type' => 'TEXT'],
                'hasil_pembahasan' => ['type' => 'TEXT'],
                'nama_disiapkan' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
                'jabatan_disiapkan' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
                'nama_setuju1' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
                'jabatan_setuju1' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
                'is_approved1' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
                'nama_setuju2' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
                'jabatan_setuju2' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
                'is_approved2' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
                'is_final' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
            ];
            $forge->addField($fields);
            $forge->addKey('id', true);
            $forge->createTable('notula_rapat');
        } else {
            $forge = \Config\Database::forge();
            $extraFields = [];

            if (!$db->fieldExists('approval_method', 'notula_rapat')) {
                $extraFields['approval_method'] = ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true, 'default' => 'manual'];
            }
            if (!$db->fieldExists('approval_user1_id', 'notula_rapat')) {
                $extraFields['approval_user1_id'] = ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true];
            }
            if (!$db->fieldExists('approval_user2_id', 'notula_rapat')) {
                $extraFields['approval_user2_id'] = ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true];
            }
            if (!$db->fieldExists('doc_status', 'notula_rapat')) {
                $extraFields['doc_status'] = ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true, 'default' => 'draft'];
            }
            if (!$db->fieldExists('revision_notes', 'notula_rapat')) {
                $extraFields['revision_notes'] = ['type' => 'TEXT', 'null' => true];
            }
            if (!$db->fieldExists('approval_history', 'notula_rapat')) {
                $extraFields['approval_history'] = ['type' => 'TEXT', 'null' => true];
            }
            if (!$db->fieldExists('parent_id', 'notula_rapat')) {
                $extraFields['parent_id'] = ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true];
            }
            if (!$db->fieldExists('attendance_list', 'notula_rapat')) {
                $extraFields['attendance_list'] = ['type' => 'TEXT', 'null' => true];
            }
            if (!$db->fieldExists('agenda', 'notula_rapat')) {
                $extraFields['agenda'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true];
            }
            if (!$db->fieldExists('peserta', 'notula_rapat')) {
                $extraFields['peserta'] = ['type' => 'TEXT', 'null' => true];
            }
            if (!$db->fieldExists('hasil_pembahasan', 'notula_rapat')) {
                $extraFields['hasil_pembahasan'] = ['type' => 'TEXT', 'null' => true];
            }
            if (!$db->fieldExists('nama_disiapkan', 'notula_rapat')) {
                $extraFields['nama_disiapkan'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true];
            }
            if (!$db->fieldExists('jabatan_disiapkan', 'notula_rapat')) {
                $extraFields['jabatan_disiapkan'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true];
            }
            if (!$db->fieldExists('nama_setuju1', 'notula_rapat')) {
                $extraFields['nama_setuju1'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true];
            }
            if (!$db->fieldExists('jabatan_setuju1', 'notula_rapat')) {
                $extraFields['jabatan_setuju1'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true];
            }
            if (!$db->fieldExists('is_approved1', 'notula_rapat')) {
                $extraFields['is_approved1'] = ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0];
            }
            if (!$db->fieldExists('nama_setuju2', 'notula_rapat')) {
                $extraFields['nama_setuju2'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true];
            }
            if (!$db->fieldExists('jabatan_setuju2', 'notula_rapat')) {
                $extraFields['jabatan_setuju2'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true];
            }
            if (!$db->fieldExists('is_approved2', 'notula_rapat')) {
                $extraFields['is_approved2'] = ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0];
            }
            if (!$db->fieldExists('is_final', 'notula_rapat')) {
                $extraFields['is_final'] = ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0];
            }

            if (!empty($extraFields)) {
                $forge->addColumn('notula_rapat', $extraFields);
            }
        }
    }

    public function save()
    {
        $this->checkTable();
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        
        $items = $this->request->getPost('item');
        $hasils = $this->request->getPost('hasil');
        $pics = $this->request->getPost('pic');
        $targets = $this->request->getPost('target');

        $hasil_pembahasan = [];
        if ($items) {
            foreach ($items as $index => $item) {
                $hasil_pembahasan[] = [
                    'item' => $item,
                    'hasil' => $hasils[$index],
                    'pic' => $pics[$index],
                    'target' => $targets[$index]
                ];
            }
        }

        $approval_method = $this->request->getPost('approval_method') ?? 'manual';
        $approval_user1_id = $this->request->getPost('approval_user1_id');
        $approval_user2_id = $this->request->getPost('approval_user2_id');
        $custom_setuju1 = $this->request->getPost('nama_setuju1');
        $custom_setuju2 = $this->request->getPost('nama_setuju2');
        $doc_status = $this->request->getPost('doc_status') ?? 'draft';

        if ($approval_method === 'automatic') {
            if ($approval_user1_id) {
                $user1 = $db->table('users')->where('id', $approval_user1_id)->get()->getRowArray();
                if ($user1) {
                    $custom_setuju1 = $user1['nama_lengkap'];
                }
            } elseif (!empty($custom_setuju1)) {
                $existingUser = $db->table('users')->where('nama_lengkap', $custom_setuju1)->get()->getRowArray();
                if (!$existingUser) {
                    $username = strtolower(preg_replace('/[^a-z0-9]/', '', str_replace(' ', '.', $custom_setuju1))) . rand(10,99);
                    $newUser = [
                        'nama_lengkap' => $custom_setuju1,
                        'username' => $username,
                        'password' => password_hash('default123', PASSWORD_DEFAULT),
                        'role' => 'Eksternal',
                        'divisi' => '-',
                    ];
                    $db->table('users')->insert($newUser);
                    $approval_user1_id = $db->insertID();
                } else {
                    $approval_user1_id = $existingUser['id'];
                }
            }

            if ($approval_user2_id) {
                $user2 = $db->table('users')->where('id', $approval_user2_id)->get()->getRowArray();
                if ($user2) {
                    $custom_setuju2 = $user2['nama_lengkap'];
                }
            } elseif (!empty($custom_setuju2)) {
                $existingUser = $db->table('users')->where('nama_lengkap', $custom_setuju2)->get()->getRowArray();
                if (!$existingUser) {
                    $username = strtolower(preg_replace('/[^a-z0-9]/', '', str_replace(' ', '.', $custom_setuju2))) . rand(10,99);
                    $newUser = [
                        'nama_lengkap' => $custom_setuju2,
                        'username' => $username,
                        'password' => password_hash('default123', PASSWORD_DEFAULT),
                        'role' => 'Eksternal',
                        'divisi' => '-',
                    ];
                    $db->table('users')->insert($newUser);
                    $approval_user2_id = $db->insertID();
                } else {
                    $approval_user2_id = $existingUser['id'];
                }
            }
        }

        $attendanceNames = $this->request->getPost('attendee_name');
        $attendanceRoles = $this->request->getPost('attendee_role');
        $attendanceStatuses = $this->request->getPost('attendance_status');
        $attendance_list = [];
        if ($attendanceNames) {
            foreach ($attendanceNames as $index => $name) {
                if (trim($name) === '') continue;
                $attendance_list[] = [
                    'name' => $name,
                    'role' => $attendanceRoles[$index] ?? '',
                    'status' => $attendanceStatuses[$index] ?? 'Hadir',
                ];
            }
        }

        $data = [
            'aplikasi_id' => $this->request->getPost('aplikasi_id'),
            'user_id' => session()->get('id'),
            'tanggal' => $this->request->getPost('tanggal'),
            'tempat' => $this->request->getPost('tempat'),
            'agenda' => $this->request->getPost('agenda'),
            'peserta' => $this->request->getPost('peserta'),
            'hasil_pembahasan' => json_encode($hasil_pembahasan),
            'nama_disiapkan' => $this->request->getPost('nama_disiapkan'),
            'jabatan_disiapkan' => $this->request->getPost('jabatan_disiapkan'),
            'approval_method' => $approval_method,
            'approval_user1_id' => $approval_user1_id ?: null,
            'approval_user2_id' => $approval_user2_id ?: null,
            'nama_setuju1' => $custom_setuju1,
            'jabatan_setuju1' => $this->request->getPost('jabatan_setuju1'),
            'nama_setuju2' => $custom_setuju2,
            'jabatan_setuju2' => $this->request->getPost('jabatan_setuju2'),
            'doc_status' => $doc_status,
            'revision_notes' => $this->request->getPost('revision_notes'),
            'attendance_list' => json_encode($attendance_list),
        ];

        if ($id) {
            // Check if already approved (can't edit)
            $existing = $db->table('notula_rapat')->where('id', $id)->get()->getRowArray();
            if ($existing['is_approved1'] && $existing['is_approved2']) {
                return redirect()->back()->with('error', 'Notula sudah disetujui sepenuhnya dan tidak dapat diedit.');
            }
            $db->table('notula_rapat')->where('id', $id)->update($data);
            $msg = 'Notula Rapat Berhasil Diperbarui!';
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $db->table('notula_rapat')->insert($data);
            $msg = 'Notula Rapat Berhasil Disimpan!';
            
            // --- Integrasi Google Calendar API ---
            try {
                $gcal = new \App\Libraries\GoogleCalendarService();
                $gcal->createEvent(
                    $data['agenda'], // Judul
                    "Notula Rapat: " . $data['agenda'] . "\nOleh: " . $data['nama_disiapkan'], // Deskripsi
                    $data['tempat'], // Lokasi
                    $data['tanggal'] . ' 08:00:00', // Mulai (default pagi)
                    $data['tanggal'] . ' 10:00:00'  // Selesai (default 2 jam)
                );
            } catch (\Exception $e) {
                log_message('error', 'Gagal sync Google Calendar: ' . $e->getMessage());
            }
            // -------------------------------------
        }

        (new LogModel())->record('BUAT NOTULA', 'Menyimpan notula rapat: ' . $this->request->getPost('agenda'));
        return redirect()->to('/progress')->with('sukses', $msg);
    }

    public function list($app_id)
    {
        $this->checkTable();
        $db = \Config\Database::connect();
        $data['memos'] = $db->table('notula_rapat')->where('aplikasi_id', $app_id)->get()->getResultArray();
        $data['app'] = $db->table('aplikasi_master')->where('id', $app_id)->get()->getRowArray();
        return view('notula/list_v', $data);
    }

    public function approve($id, $side)
    {
        $this->checkTable();
        $db = \Config\Database::connect();
        $field = ($side == 1) ? 'is_approved1' : 'is_approved2';

        $notula = $db->table('notula_rapat')->where('id', $id)->get()->getRowArray();
        if (!$notula) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
            }
            return redirect()->back()->with('error', 'Notula tidak ditemukan.');
        }

        $history = !empty($notula['approval_history']) ? json_decode($notula['approval_history'], true) : [];
        $history[] = [
            'timestamp' => date('c'),
            'user_id' => session()->get('id'),
            'user_name' => session()->get('nama_lengkap'),
            'action' => ($side == 1) ? 'approved_by_1' : 'approved_by_2',
            'target' => 'notula',
            'doc_status' => $notula['doc_status'] ?? 'draft',
        ];

        $db->table('notula_rapat')->where('id', $id)->update([
            $field => 1,
            'approval_history' => json_encode($history),
        ]);
        
        // Cek jika keduanya sudah approve, tandai final
        $notula = $db->table('notula_rapat')->where('id', $id)->get()->getRowArray();
        $is_final = ($notula['is_approved1'] && $notula['is_approved2']);
        if ($is_final) {
            $db->table('notula_rapat')->where('id', $id)->update(['is_final' => 1, 'doc_status' => 'final']);
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'is_final' => $is_final]);
        }

        return redirect()->back()->with('sukses', 'Notula berhasil disetujui.');
    }

    public function duplicate($id)
    {
        $this->checkTable();
        $db = \Config\Database::connect();
        $existing = $db->table('notula_rapat')->where('id', $id)->get()->getRowArray();
        if (!$existing) {
            return redirect()->back()->with('error', 'Tidak dapat menduplikat notula yang tidak ada.');
        }

        unset($existing['id']);
        $existing['is_approved1'] = 0;
        $existing['is_approved2'] = 0;
        $existing['is_final'] = 0;
        $existing['doc_status'] = 'draft';
        $existing['parent_id'] = $id;
        $existing['created_at'] = date('Y-m-d H:i:s');
        $history = !empty($existing['approval_history']) ? json_decode($existing['approval_history'], true) : [];
        $history[] = [
            'timestamp' => date('c'),
            'user_id' => session()->get('id'),
            'user_name' => session()->get('nama_lengkap'),
            'action' => 'duplicated',
            'source_id' => $id,
        ];
        $existing['approval_history'] = json_encode($history);

        $db->table('notula_rapat')->insert($existing);
        $newId = $db->insertID();

        return redirect()->to('/notula/edit/' . $newId)->with('sukses', 'Notula berhasil diduplikasi. Silakan periksa kembali.');
    }

    public function revise($id)
    {
        $this->checkTable();
        $db = \Config\Database::connect();
        $notula = $db->table('notula_rapat')->where('id', $id)->get()->getRowArray();
        if (!$notula) {
            return redirect()->back()->with('error', 'Notula tidak ditemukan.');
        }

        $comment = $this->request->getPost('revision_comment');
        $history = !empty($notula['approval_history']) ? json_decode($notula['approval_history'], true) : [];
        $history[] = [
            'timestamp' => date('c'),
            'user_id' => session()->get('id'),
            'user_name' => session()->get('nama_lengkap'),
            'action' => 'revision_requested',
            'comment' => $comment,
            'previous_approved1' => $notula['is_approved1'],
            'previous_approved2' => $notula['is_approved2'],
        ];

        $db->table('notula_rapat')->where('id', $id)->update([
            'is_approved1' => 0,
            'is_approved2' => 0,
            'is_final' => 0,
            'doc_status' => 'draft',
            'revision_notes' => $comment,
            'approval_history' => json_encode($history),
        ]);

        return redirect()->back()->with('sukses', 'Permintaan revisi telah disimpan. Approval harus dilakukan kembali.');
    }

    public function export($id)
    {
        try {
            $db = \Config\Database::connect();
            $notula = $db->table('notula_rapat')->where('id', $id)->get()->getRowArray();
            
            if (!$notula) {
                log_message('error', 'Notula Export: Data ID ' . $id . ' not found.');
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }
            
            $notula['hasil_pembahasan'] = json_decode($notula['hasil_pembahasan'], true);

            // Create new FPDF instance
            $pdf = new \setasign\Fpdi\Fpdi('P', 'mm', 'A4');
            $pdf->SetAutoPageBreak(true, 10);
            $pdf->AddPage();
            
            // Set Base Config
            $pdf->SetDrawColor(0, 0, 0); // Black borders
            $pdf->SetLineWidth(0.4);

            // 1. Top Logo Row (Y=10)
            $pdf->Rect(10, 10, 130, 20);
            $logoPath = FCPATH . 'images/logo_si.png';
            if (file_exists($logoPath)) {
                $pdf->Image($logoPath, 15, 12, 22);
            }
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->SetTextColor(30, 64, 175); // Blue
            $pdf->SetXY(45, 16);
            $pdf->Cell(80, 10, 'PT SURVEYOR INDONESIA (Persero)', 0, 0, 'L');

            // Dok Row 
            $pdf->Rect(140, 10, 60, 25);
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetXY(142, 13);
            $pdf->Cell(60, 5, 'No Dok.   : FP-MR07-04', 0, 1);
            $pdf->SetXY(142, 19);
            $pdf->Cell(60, 5, 'Status     : ' . strtoupper($notula['doc_status'] ?? 'DRAFT'), 0, 1);
            $pdf->SetXY(142, 25);
            $pdf->Cell(60, 5, 'Revisi      : 00', 0, 1);

            // 2. Title Row (Y=30)
            $pdf->SetFillColor(204, 204, 204); // Grey background
            $pdf->Rect(10, 30, 130, 15, 'DF'); 
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY(10, 34);
            $pdf->Cell(130, 8, 'NOTULA RAPAT', 0, 0, 'C');

            // Draw right date box without top border
            $pdf->Line(140, 30, 140, 54);
            $pdf->Line(200, 30, 200, 54);
            $pdf->Line(140, 54, 200, 54);
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetXY(142, 36);
            $pdf->Cell(60, 5, 'Tanggal : ' . date('d/m/Y', strtotime($notula['tanggal'])), 0, 1);
            $pdf->SetXY(142, 42);
            $pdf->Cell(60, 5, 'Tempat : ' . $notula['tempat'], 0, 1);

            // 3. Agenda Row (combined with NOTULA RAPAT title)
            $pdf->Rect(10, 30, 130, 60);
            $pdf->SetFillColor(204, 204, 204); // Grey background for title sub-row
            $pdf->Rect(10, 30, 130, 15, 'DF');
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY(10, 34);
            $pdf->Cell(130, 8, 'NOTULA RAPAT', 0, 0, 'C');

            $pdf->SetFont('Arial', '', 9);
            $pdf->SetXY(12, 48);
            $pdf->Cell(20, 5, 'AGENDA', 0, 0);
            $pdf->Cell(3, 5, ':', 0, 0);
            $pdf->Cell(95, 5, $notula['agenda'], 0, 1);

            $pdf->SetXY(12, 54);
            $pdf->Cell(20, 5, 'PESERTA', 0, 0);
            $pdf->Cell(3, 5, ':', 0, 1);
            $yP = 59;
            $peserta = explode(',', $notula['peserta']);
            foreach($peserta as $p) {
                $pdf->SetXY(20, $yP);
                $pdf->Cell(100, 5, '- ' . trim($p), 0, 1);
                $yP += 5;
                if ($yP > 88) break;
            }

            $pdf->Rect(140, 54, 60, 36);
            $pdf->SetXY(142, 56);
            $pdf->Cell(60, 5, 'DISTRIBUSI NOTULA RAPAT:', 0, 1);
            $pdf->SetXY(145, 62);
            $pdf->Cell(60, 5, '- Unit Kerja Terkait', 0, 1);

            $noteY = max($yP + 5, 95);
            if (!empty(trim($notula['revision_notes']))) {
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetXY(12, $noteY);
                $pdf->Cell(190, 5, 'Catatan Revisi:', 0, 1);
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetXY(12, $noteY + 5);
                $pdf->MultiCell(190, 5, trim($notula['revision_notes']), 0, 'L');
                $noteY = $pdf->GetY() + 3;
            }

            $tableStartY = max($noteY, 95) + 3;
            if ($tableStartY < 98) {
                $tableStartY = 98;
            }

            // 4. Table Header
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetFillColor(230, 230, 230);
            $pdf->SetXY(10, $tableStartY);
            $pdf->Cell(15, 10, 'ITEM', 1, 0, 'C', true);
            $pdf->Cell(100, 10, 'HASIL PEMBAHASAN', 1, 0, 'C', true);
            $pdf->Cell(45, 10, 'PENANGGUNG JAWAB', 1, 0, 'C', true);
            $pdf->Cell(30, 10, 'TARGET WAKTU', 1, 1, 'C', true);

            // 5. Table Data
            $pdf->SetFont('Arial', '', 9);
            $y = $tableStartY + 10;
            $no = 1;

            $wrapLines = function($pdf, $width, $text) {
                $text = trim($text);
                if ($text === '') {
                    return 1;
                }

                $lines = 0;
                foreach (explode("\n", $text) as $line) {
                    $line = trim($line);
                    if ($line === '') {
                        $lines++;
                        continue;
                    }

                    $words = preg_split('/\s+/', $line);
                    $current = '';
                    foreach ($words as $word) {
                        $candidate = $current === '' ? $word : $current . ' ' . $word;

                        if ($pdf->GetStringWidth($candidate) > $width) {
                            if ($current === '') {
                                // Word itself is longer than the width, split by characters
                                $sub = '';
                                foreach (str_split($word) as $char) {
                                    $test = $sub . $char;
                                    if ($pdf->GetStringWidth($test) > $width) {
                                        $lines++;
                                        $sub = $char;
                                    } else {
                                        $sub = $test;
                                    }
                                }
                                if ($sub !== '') {
                                    $current = $sub;
                                } else {
                                    $current = '';
                                }
                            } else {
                                $lines++;
                                $current = $word;
                            }
                        } else {
                            $current = $candidate;
                        }
                    }
                    if ($current !== '') {
                        $lines++;
                    }
                }
                return max(1, $lines);
            };

            foreach ($notula['hasil_pembahasan'] as $it) {
                $hasil = trim($it['hasil']);
                $targetDate = !empty($it['target']) ? date('d/m/Y', strtotime($it['target'])) : '-';

                $textLines = $wrapLines($pdf, 100, $hasil ?: '-');
                $picLines = $wrapLines($pdf, 45, $it['pic'] ?: '-');
                $targetLines = $wrapLines($pdf, 30, $targetDate);
                $rowHeight = max(12, max($textLines, $picLines, $targetLines) * 5 + 4);

                if ($y + $rowHeight > 260) {
                    $pdf->AddPage();
                    $y = 10;
                }

                $pdf->Rect(10, $y, 15, $rowHeight);
                $pdf->Rect(25, $y, 100, $rowHeight);
                $pdf->Rect(125, $y, 45, $rowHeight);
                $pdf->Rect(170, $y, 30, $rowHeight);

                $pdf->SetXY(10, $y + 2);
                $pdf->Cell(15, 5, $no++, 0, 0, 'C');

                $pdf->SetXY(25, $y + 2);
                $pdf->MultiCell(100, 5, $hasil ?: '-', 0, 'L');

                $pdf->SetXY(125, $y + 2);
                $pdf->MultiCell(45, 5, $it['pic'] ?: '-', 0, 'C');

                $pdf->SetXY(170, $y + 2);
                $pdf->MultiCell(30, 5, $targetDate, 0, 'C');

                $y += $rowHeight;
            }

            // 5.5. Absensi Kehadiran
            if (!empty($notula['attendance_list'])) {
                $attendanceList = is_string($notula['attendance_list']) ? json_decode($notula['attendance_list'], true) : $notula['attendance_list'];
                
                if (is_array($attendanceList) && count($attendanceList) > 0) {
                    $y += 5;
                    if ($y + 20 > 280) {
                        $pdf->AddPage();
                        $y = 10;
                    }
                    
                    $pdf->SetFont('Arial', 'B', 9);
                    $pdf->SetXY(10, $y);
                    $pdf->Cell(190, 6, 'DAFTAR ABSENSI KEHADIRAN', 0, 1, 'L');
                    $y += 6;
                    
                    $pdf->SetFont('Arial', 'B', 8);
                    $pdf->SetFillColor(230, 230, 230);
                    $pdf->SetXY(10, $y);
                    $pdf->Cell(15, 8, 'NO', 1, 0, 'C', true);
                    $pdf->Cell(85, 8, 'NAMA PESERTA', 1, 0, 'C', true);
                    $pdf->Cell(60, 8, 'PERAN / JABATAN', 1, 0, 'C', true);
                    $pdf->Cell(30, 8, 'STATUS', 1, 1, 'C', true);
                    
                    $y += 8;
                    $pdf->SetFont('Arial', '', 8);
                    $noAtt = 1;
                    
                    foreach ($attendanceList as $att) {
                        $nameLines = $wrapLines($pdf, 85, $att['name'] ?: '-');
                        $roleLines = $wrapLines($pdf, 60, $att['role'] ?: '-');
                        $rowHeight = max(8, max($nameLines, $roleLines) * 5 + 4);
                        
                        if ($y + $rowHeight > 280) {
                            $pdf->AddPage();
                            $y = 10;
                            
                            $pdf->SetFont('Arial', 'B', 8);
                            $pdf->SetFillColor(230, 230, 230);
                            $pdf->SetXY(10, $y);
                            $pdf->Cell(15, 8, 'NO', 1, 0, 'C', true);
                            $pdf->Cell(85, 8, 'NAMA PESERTA', 1, 0, 'C', true);
                            $pdf->Cell(60, 8, 'PERAN / JABATAN', 1, 0, 'C', true);
                            $pdf->Cell(30, 8, 'STATUS', 1, 1, 'C', true);
                            $y += 8;
                            $pdf->SetFont('Arial', '', 8);
                        }
                        
                        $pdf->Rect(10, $y, 15, $rowHeight);
                        $pdf->Rect(25, $y, 85, $rowHeight);
                        $pdf->Rect(110, $y, 60, $rowHeight);
                        $pdf->Rect(170, $y, 30, $rowHeight);
                        
                        $pdf->SetXY(10, $y + 1.5);
                        $pdf->Cell(15, 5, $noAtt++, 0, 0, 'C');
                        
                        $pdf->SetXY(25, $y + 1.5);
                        $pdf->MultiCell(85, 5, $att['name'] ?: '-', 0, 'L');
                        
                        $pdf->SetXY(110, $y + 1.5);
                        $pdf->MultiCell(60, 5, $att['role'] ?: '-', 0, 'C');
                        
                        $pdf->SetXY(170, $y + 1.5);
                        $pdf->Cell(30, 5, $att['status'] ?: '-', 0, 1, 'C');
                        
                        $y += $rowHeight;
                    }
                    $y += 5;
                }
            }

            // 6. Signatures
            $signatureY = $y;
            if ($signatureY + 55 > 280) {
                $pdf->AddPage();
                $signatureY = 15;
            }

            $pdf->Rect(10, $signatureY, 190, 55);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetXY(10, $signatureY + 4);
            $pdf->Cell(63, 5, 'Disiapkan oleh', 0, 0, 'C');
            $pdf->Cell(63, 5, 'Disetujui oleh 1', 0, 0, 'C');
            $pdf->Cell(64, 5, 'Disetujui oleh 2', 0, 1, 'C');

            $pdf->SetFont('Arial', '', 8);
            $pdf->SetXY(10, $signatureY + 10);

            $qrFiles = [];
            $generateQR = function($text) {
                $tempFile = sys_get_temp_dir() . '/' . uniqid('qr_') . '.png';
                $url = 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=' . urlencode($text);
                if (function_exists('curl_init')) {
                    $ch = curl_init($url);
                    $fp = fopen($tempFile, 'wb');
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_exec($ch);
                    curl_close($ch);
                    fclose($fp);
                } else {
                    file_put_contents($tempFile, file_get_contents($url));
                }
                return $tempFile;
            };

            $qrSize = 24;
            $columnXs = [14, 76.5, 140];

            $preparedName = $notula['nama_disiapkan'] ?: '-';
            $approved1Name = $notula['is_approved1'] ? ($notula['nama_setuju1'] ?: '-') : '-';
            $approved2Name = $notula['is_approved2'] ? ($notula['nama_setuju2'] ?: '-') : '-';

            $preparedRole = $notula['jabatan_disiapkan'] ?: '-';
            $approved1Role = $notula['jabatan_setuju1'] ?: '-';
            $approved2Role = $notula['jabatan_setuju2'] ?: '-';

            $qrFiles[] = $f = $generateQR(base_url('notula/verify/' . $id . '?sign=prepared'));
            if (file_exists($f)) {
                $pdf->Image($f, $columnXs[0] + 17, $signatureY + 14, $qrSize, $qrSize);
            }

            if ($notula['is_approved1']) {
                $qrFiles[] = $f = $generateQR(base_url('notula/verify/' . $id . '?sign=approved1'));
                if (file_exists($f)) {
                    $pdf->Image($f, $columnXs[1] + 17, $signatureY + 14, $qrSize, $qrSize);
                }
            }

            if ($notula['is_approved2']) {
                $qrFiles[] = $f = $generateQR(base_url('notula/verify/' . $id . '?sign=approved2'));
                if (file_exists($f)) {
                    $pdf->Image($f, $columnXs[2] + 17, $signatureY + 14, $qrSize, $qrSize);
                }
            }

            $pdf->SetXY(10, $signatureY + 40);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(63, 5, $preparedName, 0, 0, 'C');
            $pdf->Cell(63, 5, $approved1Name, 0, 0, 'C');
            $pdf->Cell(64, 5, $approved2Name, 0, 1, 'C');

            $pdf->SetXY(10, $signatureY + 45);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(63, 5, $preparedRole, 0, 0, 'C');
            $pdf->Cell(63, 5, $approved1Role, 0, 0, 'C');
            $pdf->Cell(64, 5, $approved2Role, 0, 1, 'C');

            // Capture PDF output
            $output = $pdf->Output('S');

            // Cleanup temp files
            foreach($qrFiles as $f) { 
                if(file_exists($f)) @unlink($f); 
            }

            return $this->response->setHeader('Content-Type', 'application/pdf')
                                  ->setHeader('Content-Disposition', 'inline; filename="Notula_Rapat_'.$id.'.pdf"')
                                  ->setBody($output);

        } catch (\Exception $e) {
            log_message('error', 'Notula FPDF Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            return redirect()->back()->with('error', 'Gagal memuat template PDF: ' . $e->getMessage());
        }
    }

    public function verify($id)
    {
        $db = \Config\Database::connect();
        $notula = $db->table('notula_rapat')->where('id', $id)->get()->getRowArray();
        
        if (!$notula) {
            return "<h1>Dokumen Tidak Ditemukan</h1><p>Notula rapat dengan ID tersebut tidak ada dalam sistem.</p>";
        }
        
        $sign = $this->request->getGet('sign');
        $name = "-";
        $role = "-";
        $status = "Menunggu Persetujuan";
        
        if ($sign == 'prepared') {
            $name = $notula['nama_disiapkan'];
            $role = $notula['jabatan_disiapkan'];
            $status = "Telah Disiapkan secara Digital";
        } elseif ($sign == 'approved1') {
            if ($notula['is_approved1']) {
                $name = $notula['nama_setuju1'];
                $role = $notula['jabatan_setuju1'];
                $status = "Telah Disetujui (Approved)";
            }
        } elseif ($sign == 'approved2') {
            if ($notula['is_approved2']) {
                $name = $notula['nama_setuju2'];
                $role = $notula['jabatan_setuju2'];
                $status = "Telah Disetujui (Approved)";
            }
        }

        $html = '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Tanda Tangan Digital</title>
    <style>
        body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); max-width: 400px; width: 100%; border-top: 5px solid #2563eb; }
        .success-icon { color: #16a34a; font-size: 48px; text-align: center; margin-bottom: 10px; }
        h2 { text-align: center; color: #1f2937; margin-top: 0; font-size: 20px; }
        .divider { border-bottom: 1px dashed #e5e7eb; margin: 20px 0; }
        .row { margin-bottom: 12px; }
        .label { font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; }
        .value { font-size: 15px; color: #111827; font-weight: 500; margin-top: 4px; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; background-color: #dcfce7; color: #166534; }
        .footer { text-align: center; margin-top: 25px; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="card">
        <div class="success-icon">✓</div>
        <h2>Verifikasi Tanda Tangan Valid</h2>
        
        <div class="divider"></div>
        
        <div class="row">
            <div class="label">Dokumen Terkait</div>
            <div class="value">Notula Rapat #' . esc($id) . '</div>
        </div>
        <div class="row">
            <div class="label">Agenda</div>
            <div class="value">' . esc($notula['agenda']) . '</div>
        </div>
        
        <div class="divider"></div>
        
        <div class="row">
            <div class="label">Ditandatangani Oleh</div>
            <div class="value">' . esc($name) . '</div>
        </div>
        <div class="row">
            <div class="label">Peran / Jabatan</div>
            <div class="value">' . esc($role) . '</div>
        </div>
        <div class="row">
            <div class="label">Status Penandatanganan</div>
            <div class="value"><span class="badge">' . esc($status) . '</span></div>
        </div>
        
        <div class="footer">
            Sistem Informasi PT Surveyor Indonesia<br>
            Waktu Verifikasi: ' . date('d M Y H:i:s') . '
        </div>
    </div>
</body>
</html>';

        return $this->response->setBody($html);
    }

    public function print($id)
    {
        $db = \Config\Database::connect();
        $notula = $db->table('notula_rapat')->where('id', $id)->get()->getRowArray();
        
        if (!$notula) return redirect()->back()->with('error', 'Data tidak ditemukan.');
        
        $notula['hasil_pembahasan'] = json_decode($notula['hasil_pembahasan'], true);

        $data = [
            'doc_number' => 'FP-MR07-04',
            'revision' => '00',
            'notula' => $notula,
            'is_print' => true
        ];

        return view('notula/print_v', $data);
    }
}

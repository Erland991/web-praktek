<?php

namespace App\Controllers;

use App\Models\LogModel;

class PermintaanController extends BaseController
{
    private function checkTable()
    {
        $db = \Config\Database::connect();
        if (!$db->tableExists('permintaan_aplikasi')) {
            $db->simpleQuery("CREATE TABLE permintaan_aplikasi (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nama_app VARCHAR(255) NULL,
                deskripsi TEXT NULL,
                latar_belakang TEXT NULL,
                tgl_target DATE NULL,
                uraian_tambahan TEXT NULL,
                lampiran TEXT NULL,
                user_id INT(11) UNSIGNED NOT NULL,
                nama_disiapkan VARCHAR(100) NULL,
                jabatan_disiapkan VARCHAR(100) NULL,
                tgl_disiapkan DATETIME NULL,
                approval_user_id INT(11) UNSIGNED NULL,
                nama_setuju VARCHAR(100) NULL,
                jabatan_setuju VARCHAR(100) NULL,
                tgl_setuju DATETIME NULL,
                is_approved TINYINT(1) DEFAULT 0,
                doc_status VARCHAR(20) DEFAULT 'draft',
                tgl_mulai_pengembangan DATE NULL,
                aplikasi_id INT(11) NULL,
                created_at DATETIME NULL,
                updated_at DATETIME NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4");
        } else {
            // Check for missing columns in existing table (for hosting)
            if (!$db->fieldExists('uraian_tambahan', 'permintaan_aplikasi')) {
                $db->simpleQuery("ALTER TABLE permintaan_aplikasi ADD COLUMN uraian_tambahan TEXT NULL AFTER tgl_target");
            }
            if (!$db->fieldExists('lampiran', 'permintaan_aplikasi')) {
                $db->simpleQuery("ALTER TABLE permintaan_aplikasi ADD COLUMN lampiran TEXT NULL AFTER uraian_tambahan");
            }
        }
    }

    public function index($id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->checkTable();
        $db = \Config\Database::connect();
        $permintaan = null;

        if ($id) {
            $permintaan = $db->table('permintaan_aplikasi')->where('id', $id)->get()->getRowArray();
        }

        // Dropdown users for 'Penyetuju'
        $users = $db->table('users')->select('id, nama_lengkap, role')->orderBy('nama_lengkap')->get()->getResultArray();

        if (!$permintaan) {
            $permintaan = [
                'nama_app' => '',
                'deskripsi' => '',
                'latar_belakang' => '',
                'tgl_target' => '',
                'nama_disiapkan' => session()->get('nama_lengkap'),
                'jabatan_disiapkan' => session()->get('role'),
                'approval_user_id' => '',
                'nama_setuju' => '',
                'jabatan_setuju' => 'Manajer Divisi / Kepala Divisi',
                'doc_status' => 'draft',
                'is_approved' => 0
            ];
        }

        $data = [
            'permintaan' => $permintaan,
            'users' => $users
        ];

        return view('permintaan/permintaan_v', $data);
    }

    public function list()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->checkTable();
        $db = \Config\Database::connect();
        
        $role = session()->get('role');
        $userId = session()->get('id');

        $builder = $db->table('permintaan_aplikasi');
        
        // Filter based on role
        if ($role !== 'Admin' && $role !== 'PM') {
            // Can see their own requests or requests needing their approval
            $builder->groupStart()
                    ->where('user_id', $userId)
                    ->orWhere('approval_user_id', $userId)
                    ->groupEnd();
        }

        $data['permintaan_list'] = $builder->orderBy('created_at', 'DESC')->get()->getResultArray();

        return view('permintaan/list_permintaan_v', $data);
    }

    public function save()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }

        $this->checkTable();
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');

        $approval_user_id = $this->request->getPost('approval_user_id');
        $nama_setuju = $this->request->getPost('nama_setuju');

        if ($approval_user_id) {
            $userApprover = $db->table('users')->where('id', $approval_user_id)->get()->getRowArray();
            if ($userApprover) {
                $nama_setuju = $userApprover['nama_lengkap'];
            }
        }

        $data = [
            'nama_app' => $this->request->getPost('nama_app'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'latar_belakang' => $this->request->getPost('latar_belakang'),
            'tgl_target' => $this->request->getPost('tgl_target'),
            'uraian_tambahan' => $this->request->getPost('uraian_tambahan'),
            'lampiran' => $this->request->getPost('lampiran'),
            'user_id' => session()->get('id'),
            'nama_disiapkan' => $this->request->getPost('nama_disiapkan'),
            'jabatan_disiapkan' => $this->request->getPost('jabatan_disiapkan'),
            'approval_user_id' => $approval_user_id ?: null,
            'nama_setuju' => $nama_setuju,
            'jabatan_setuju' => $this->request->getPost('jabatan_setuju'),
            'doc_status' => 'pending_approval'
        ];

        if ($id) {
            $existing = $db->table('permintaan_aplikasi')->where('id', $id)->get()->getRowArray();
            if ($existing && $existing['is_approved']) {
                return redirect()->back()->with('error', 'Permintaan sudah disetujui, tidak dapat diubah.');
            }
            $data['updated_at'] = date('Y-m-d H:i:s');
            $db->table('permintaan_aplikasi')->where('id', $id)->update($data);
            $msg = 'Permintaan Aplikasi Berhasil Diperbarui!';
        } else {
            $data['tgl_disiapkan'] = date('Y-m-d H:i:s');
            $data['created_at'] = date('Y-m-d H:i:s');
            $db->table('permintaan_aplikasi')->insert($data);
            $msg = 'Permintaan Aplikasi Berhasil Diajukan!';
        }

        (new LogModel())->record('PERMINTAAN APLIKASI', 'Mengajukan/Mengupdate permintaan aplikasi: ' . $data['nama_app']);
        
        return redirect()->to('/permintaan/list')->with('sukses', $msg);
    }

    public function approve($id)
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $db = \Config\Database::connect();
        $permintaan = $db->table('permintaan_aplikasi')->where('id', $id)->get()->getRowArray();

        if (!$permintaan) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
        }

        // Verifikasi wewenang (apakah user ini adalah approval_user_id, atau Admin)
        $userId = session()->get('id');
        $role = session()->get('role');

        if ($permintaan['approval_user_id'] != $userId && $role !== 'Admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Anda tidak berhak menyetujui dokumen ini.']);
        }

        $tgl_sekarang = date('Y-m-d H:i:s');
        $tgl_mulai_pengembangan = date('Y-m-d'); // Tanggal mulai pengembangan = tgl approve

        // 1. Update form permintaan
        $db->table('permintaan_aplikasi')->where('id', $id)->update([
            'is_approved' => 1,
            'doc_status' => 'approved',
            'tgl_setuju' => $tgl_sekarang,
            'tgl_mulai_pengembangan' => $tgl_mulai_pengembangan,
            'updated_at' => $tgl_sekarang
        ]);

        // 2. Insert ke master aplikasi
        $db->table('aplikasi_master')->insert([
            'nama_app' => $permintaan['nama_app'],
            'deskripsi' => $permintaan['deskripsi'],
            'tgl_mulai' => $tgl_mulai_pengembangan,
            'tgl_target' => $permintaan['tgl_target'],
            'status' => 'Development',
            'created_at' => $tgl_sekarang,
            'updated_at' => $tgl_sekarang
        ]);
        
        $newAppId = $db->insertID();

        // 3. Update aplikasi_id di permintaan_aplikasi
        $db->table('permintaan_aplikasi')->where('id', $id)->update([
            'aplikasi_id' => $newAppId
        ]);

        (new LogModel())->record('APPROVE PERMINTAAN', 'Menyetujui permintaan aplikasi: ' . $permintaan['nama_app']);

        // --- Integrasi Google Calendar API ---
        try {
            $gcal = new \App\Libraries\GoogleCalendarService();
            $gcal->createAllDayEvent(
                "Deadline Project: " . $permintaan['nama_app'],
                "Tanggal Mulai: " . $tgl_mulai_pengembangan . "\nTarget Selesai: " . $permintaan['tgl_target'] . "\n\nDeskripsi: " . $permintaan['deskripsi'],
                $permintaan['tgl_target']
            );
        } catch (\Exception $e) {
            log_message('error', 'Gagal sync Google Calendar: ' . $e->getMessage());
        }
        // -------------------------------------

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'Permintaan disetujui. Aplikasi baru telah ditambahkan ke Master.',
                'tgl_mulai' => $tgl_mulai_pengembangan
            ]);
        }

        return redirect()->back()->with('sukses', 'Permintaan disetujui. Aplikasi baru telah ditambahkan ke Master.');
    }

    public function verify($id)
    {
        $db = \Config\Database::connect();
        $permintaan = $db->table('permintaan_aplikasi')->where('id', $id)->get()->getRowArray();
        
        if (!$permintaan) {
            die("Dokumen tidak ditemukan!");
        }

        $sign = $this->request->getGet('sign');
        echo "<h3>Verifikasi Tanda Tangan Digital</h3>";
        echo "<p>Dokumen: Permintaan Aplikasi Baru - " . htmlspecialchars($permintaan['nama_app']) . "</p>";

        if ($sign == 'prepared') {
            echo "<p>Telah ditandatangani/disiapkan oleh: <b>" . htmlspecialchars($permintaan['nama_disiapkan']) . "</b></p>";
            echo "<p>Waktu: " . ($permintaan['tgl_disiapkan'] ?: $permintaan['created_at']) . "</p>";
        } else if ($sign == 'approved') {
            if ($permintaan['is_approved']) {
                echo "<p>Telah disetujui secara digital oleh: <b>" . htmlspecialchars($permintaan['nama_setuju']) . "</b></p>";
                echo "<p>Waktu: " . $permintaan['tgl_setuju'] . "</p>";
            } else {
                echo "<p style='color:red;'>Dokumen ini belum disetujui.</p>";
            }
        } else {
            echo "<p>Tanda tangan tidak valid.</p>";
        }
    }

    public function export($id)
    {
        try {
            $db = \Config\Database::connect();
            $permintaan = $db->table('permintaan_aplikasi')->where('id', $id)->get()->getRowArray();
            
            if (!$permintaan) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $pdf = new \setasign\Fpdi\Fpdi('P', 'mm', 'A4');
            $pdf->SetAutoPageBreak(true, 15);
            $pdf->SetMargins(12, 15, 12);
            $pdf->AddPage();
            
            // Draw Header Table
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetLineWidth(0.3);

            // Row 1 (Header Box) - height 28mm to fit logo
            $startX   = 12;
            $startY   = 15;
            $hdrH     = 28;  // header total height
            $col1W    = 45;  // logo cell width
            $col2W    = 85;  // title cell width
            $col3W    = 56;  // meta cell width

            // Cell 1: Logo border
            $pdf->Rect($startX, $startY, $col1W, $hdrH);
            $logoPath = FCPATH . 'images/logo_si.png';
            if (file_exists($logoPath)) {
                // Force image to fill the cell minus 2mm padding, keeping aspect ratio in width
                $pdf->Image($logoPath, $startX + 1, $startY + 1, $col1W - 2, $hdrH - 2);
            }

            // Cell 2: Title border
            $pdf->Rect($startX + $col1W, $startY, $col2W, $hdrH);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->SetXY($startX + $col1W, $startY + ($hdrH / 2) - 5);
            $pdf->Cell($col2W, 5, 'Permintaan Pengembangan', 0, 2, 'C');
            $pdf->Cell($col2W, 5, 'Sistem Informasi', 0, 0, 'C');

            // Cell 3: Meta (4 rows x 7mm = 28mm)
            $col3X   = $startX + $col1W + $col2W;
            $rowH    = $hdrH / 4; // 7mm per row
            $pdf->Rect($col3X, $startY, $col3W, $hdrH);

            $pdf->SetFont('Arial', '', 8);
            $metaRows = [
                ['No. Dokumen',   'FP-DTI03-04'],
                ['No. Revisi',    '04'],
                ['Tanggal Revisi','2024'],
                ['Halaman',       '1'],
            ];
            foreach ($metaRows as $i => $row) {
                $ry = $startY + ($i * $rowH);
                if ($i > 0) $pdf->Line($col3X, $ry, $col3X + $col3W, $ry);
                // Label half
                $pdf->SetXY($col3X + 1, $ry + 1);
                $pdf->Cell(26, $rowH - 2, $row[0], 0, 0, 'L');
                // Separator line (vertical inside cell3)
                $pdf->Line($col3X + 27, $ry, $col3X + 27, $ry + $rowH);
                // Value half
                $pdf->SetXY($col3X + 28, $ry + 1);
                $pdf->Cell($col3W - 28, $rowH - 2, $row[1], 0, 0, 'L');
            }

            // Nomor Dokumen row
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetXY($startX, $startY + $hdrH + 4);
            $pdf->Cell(186, 6, 'NO : ' . sprintf('%04d', $permintaan['id']), 0, 1, 'R');

            // Title "INFO KEBUTUHAN SISTEM INFORMASI"
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetXY($startX, $startY + $hdrH + 14);
            $pdf->Cell(186, 6, 'INFO KEBUTUHAN SISTEM INFORMASI', 0, 1, 'C');

            $y = $pdf->GetY() + 2;

            // Table Settings
            $pdf->SetFont('Arial', '', 10);
            $col1 = 55;
            $col2 = 131;

            // Helper: estimate number of lines needed for a string in a given width
            $estimateLines = function($str, $cellWidth) use ($pdf) {
                if (!$str) return 1;
                // Convert UTF-8 to latin1 for FPDF
                $str = @iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $str) ?: $str;
                // Split by newlines first
                $paragraphs = explode("\n", $str);
                $totalLines = 0;
                foreach ($paragraphs as $para) {
                    if ($para === '') { $totalLines++; continue; }
                    $paraWidth = $pdf->GetStringWidth($para);
                    $totalLines += max(1, ceil($paraWidth / ($cellWidth - 1)));
                }
                return $totalLines;
            };

            // Function to draw a row: calculates height first, then draws border, then text
            $drawRow = function($label, $value) use ($pdf, $col1, $col2, &$y, $startX, $estimateLines) {
                $pdf->SetFont('Arial', '', 10);
                $lineH = 5;

                // Convert to latin1 for FPDF
                $valStr   = $value ? (@iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $value) ?: $value) : '-';
                $labelStr = @iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $label) ?: $label;

                // Estimate how many lines each column needs
                $valLines   = $estimateLines($valStr, $col2 - 3);
                $labelLines = $estimateLines($labelStr, $col1 - 3);
                $maxLines   = max($valLines, $labelLines);
                $height     = max(8, $maxLines * $lineH + 4);

                // Page break check BEFORE drawing anything
                if ($y + $height > 272) {
                    $pdf->AddPage();
                    $y = 15;
                }

                // Draw border rectangles FIRST (so text is on top)
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetLineWidth(0.3);
                $pdf->Rect($startX, $y, $col1, $height);
                $pdf->Rect($startX + $col1, $y, $col2, $height);

                // Draw label text
                $pdf->SetXY($startX + 1, $y + 1);
                $pdf->MultiCell($col1 - 3, $lineH, $labelStr);

                // Draw value text
                $pdf->SetXY($startX + $col1 + 1, $y + 1);
                $pdf->MultiCell($col2 - 3, $lineH, $valStr);

                $y = $y + $height;
            };

            // Draw Data Rows
            $drawRow('Latar Belakang', $permintaan['latar_belakang']);
            $drawRow('Tujuan', $permintaan['deskripsi']);
            $drawRow('Target Implementasi Sistem', date('d/m/Y', strtotime($permintaan['tgl_target'])));
            $drawRow('Fungsi-fungsi Sistem Informasi', "Nama Aplikasi: " . $permintaan['nama_app']);
            $drawRow('Jenis Aplikasi', 'Web / Desktop / Mobile *');
            $drawRow('Pengguna', 'Internal / Eksternal *');
            $drawRow('Uraian Permintaan Tambahan/Khusus', $permintaan['uraian_tambahan']);
            $drawRow('Lampiran', $permintaan['lampiran']);

            $pdf->SetFont('Arial', '', 8);
            $pdf->SetXY($startX, $y);
            $pdf->Cell(100, 5, '*coret yg tidak sesuai', 0, 1);
            $y += 5;

            // Signature Block
            if ($y + 50 > 280) {
                $pdf->AddPage();
                $y = 15;
            }

            $sigWidth = 186 / 2;
            $pdf->Rect($startX, $y, $sigWidth, 45);
            $pdf->Rect($startX + $sigWidth, $y, $sigWidth, 45);

            $pdf->SetFont('Arial', '', 10);
            $pdf->SetXY($startX, $y + 2);
            $pdf->Cell($sigWidth, 6, 'Disiapkan oleh', 0, 0, 'C');
            $pdf->Cell($sigWidth, 6, 'Disetujui oleh', 0, 1, 'C');

            $pdf->Line($startX, $y + 8, $startX + 186, $y + 8);

            // QR Codes
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

            $qrSize = 22;
            $preparedName = $permintaan['nama_disiapkan'] ?: '-';
            $approvedName = $permintaan['is_approved'] ? ($permintaan['nama_setuju'] ?: '-') : '-';
            $preparedRole = $permintaan['jabatan_disiapkan'] ?: '-';
            $approvedRole = $permintaan['jabatan_setuju'] ?: '-';
            $tglPrepared  = $permintaan['created_at'] ? date('d/m/Y', strtotime($permintaan['created_at'])) : '-';
            $tglApproved  = $permintaan['tgl_setuju'] ? date('d/m/Y', strtotime($permintaan['tgl_setuju'])) : '-';

            $qrFiles[] = $f = $generateQR(base_url('permintaan/verify/' . $id . '?sign=prepared'));
            if (file_exists($f)) {
                $pdf->Image($f, $startX + ($sigWidth/2) - ($qrSize/2), $y + 10, $qrSize, $qrSize);
            }

            if ($permintaan['is_approved']) {
                $qrFiles[] = $f = $generateQR(base_url('permintaan/verify/' . $id . '?sign=approved'));
                if (file_exists($f)) {
                    $pdf->Image($f, $startX + $sigWidth + ($sigWidth/2) - ($qrSize/2), $y + 10, $qrSize, $qrSize);
                }
            }

            // Names & Roles
            $pdf->SetXY($startX, $y + 34);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell($sigWidth, 4, '('.$preparedName.')', 0, 0, 'C');
            $pdf->Cell($sigWidth, 4, '('.$approvedName.')', 0, 1, 'C');
            
            $pdf->SetXY($startX, $y + 38);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell($sigWidth, 4, '('.$preparedRole.')', 0, 0, 'C');
            $pdf->Cell($sigWidth, 4, '('.$approvedRole.')', 0, 1, 'C');

            // Tanggal Line
            $pdf->Line($startX, $y + 44, $startX + 186, $y + 44);

            // Tanggal Text
            $pdf->SetXY($startX + 2, $y + 45);
            $pdf->Cell($sigWidth - 4, 5, 'Tanggal: ' . $tglPrepared, 0, 0, 'L');
            $pdf->SetXY($startX + $sigWidth + 2, $y + 45);
            $pdf->Cell($sigWidth - 4, 5, 'Tanggal: ' . ($permintaan['is_approved'] ? $tglApproved : '-'), 0, 1, 'L');

            // Extend Rect for the Date block
            $pdf->Rect($startX, $y, $sigWidth, 52);
            $pdf->Rect($startX + $sigWidth, $y, $sigWidth, 52);

            $output = $pdf->Output('I', 'Form_Permintaan_Pengembangan_'.$permintaan['nama_app'].'.pdf');

            // Cleanup temp files
            foreach ($qrFiles as $q) {
                if (file_exists($q)) {
                    @unlink($q);
                }
            }
            exit;

        } catch (\Exception $e) {
            log_message('error', 'Permintaan Export PDF Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
    }
}

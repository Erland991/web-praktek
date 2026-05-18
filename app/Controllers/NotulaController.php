<?php

namespace App\Controllers;

use App\Models\LogModel;
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

        // Auto-fill defaults for new notula
        if (!$notula && $appData) {
            $notula = [
                'tanggal' => date('Y-m-d'),
                'tempat' => 'Ruang Rapat Utama',
                'agenda' => 'Pembahasan Proyek: ' . $appData['nama_app'],
                'peserta' => session()->get('nama_lengkap') . ' (IT), ' . ($appData['pic_name'] ?? 'PM') . ' (PM), Tim ' . ($appData['nama_divisi'] ?? 'Terkait'),
                'nama_disiapkan' => session()->get('nama_lengkap'),
                'jabatan_disiapkan' => session()->get('role'),
                'nama_setuju1' => $appData['pic_name'] ?? '',
                'jabatan_setuju1' => 'Project Manager',
                'nama_setuju2' => '',
                'jabatan_setuju2' => 'Manajer Divisi ' . ($appData['nama_divisi'] ?? ''),
                'hasil_pembahasan' => [['item'=>'01', 'hasil'=>'Review Progress Aplikasi ' . $appData['nama_app'], 'pic'=>$appData['pic_name'] ?? '', 'target'=>'']]
            ];
        }

        $data = [
            'doc_number' => 'FP-MR07-04',
            'revision' => '00',
            'notula' => $notula,
            'app_id' => $app_id
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
            'nama_setuju1' => $this->request->getPost('nama_setuju1'),
            'jabatan_setuju1' => $this->request->getPost('jabatan_setuju1'),
            'nama_setuju2' => $this->request->getPost('nama_setuju2'),
            'jabatan_setuju2' => $this->request->getPost('jabatan_setuju2'),
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
        $db->table('notula_rapat')->where('id', $id)->update([$field => 1]);
        
        // Cek jika keduanya sudah approve, tandai final
        $notula = $db->table('notula_rapat')->where('id', $id)->get()->getRowArray();
        $is_final = ($notula['is_approved1'] && $notula['is_approved2']);
        if ($is_final) {
            $db->table('notula_rapat')->where('id', $id)->update(['is_final' => 1]);
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'is_final' => $is_final]);
        }

        return redirect()->back()->with('sukses', 'Notula berhasil disetujui.');
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
            $pdf->Rect(140, 10, 60, 20);
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetXY(142, 12);
            $pdf->Cell(60, 6, 'No Dok.   : FP-MR07-04', 0, 1);
            $pdf->SetXY(142, 18);
            $pdf->Cell(60, 6, 'Revisi      : 00', 0, 1);

            // 2. Title Row (Y=30)
            $pdf->SetFillColor(204, 204, 204); // Grey background
            $pdf->Rect(10, 30, 130, 15, 'DF'); 
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY(10, 34);
            $pdf->Cell(130, 8, 'NOTULA RAPAT', 0, 0, 'C');

            $pdf->Rect(140, 30, 60, 15);
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetXY(142, 31);
            $pdf->Cell(60, 6, 'Tanggal : ' . date('d/m/Y', strtotime($notula['tanggal'])), 0, 1);
            $pdf->SetXY(142, 37);
            $pdf->Cell(60, 6, 'Tempat : ' . $notula['tempat'], 0, 1);

            // 3. Agenda Row (Y=45)
            $pdf->Rect(10, 45, 130, 35);
            $pdf->SetXY(12, 47);
            $pdf->Cell(20, 5, 'AGENDA', 0, 0);
            $pdf->Cell(3, 5, ':', 0, 0);
            $pdf->Cell(95, 5, $notula['agenda'], 0, 1);

            $pdf->SetXY(12, 53);
            $pdf->Cell(20, 5, 'PESERTA', 0, 0);
            $pdf->Cell(3, 5, ':', 0, 1);
            $yP = 58;
            $peserta = explode(',', $notula['peserta']);
            foreach($peserta as $p) {
                $pdf->SetXY(20, $yP);
                $pdf->Cell(100, 5, '- ' . trim($p), 0, 1);
                $yP += 5;
                if ($yP > 75) break; 
            }

            $pdf->Rect(140, 45, 60, 35);
            $pdf->SetXY(142, 47);
            $pdf->Cell(60, 5, 'DISTRIBUSI NOTULA RAPAT:', 0, 1);
            $pdf->SetXY(145, 53);
            $pdf->Cell(60, 5, '- Unit Kerja Terkait', 0, 1);

            // 4. Table Header (Y=80)
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Rect(10, 80, 15, 10);
            $pdf->SetXY(10, 82); $pdf->Cell(15, 6, 'ITEM', 0, 0, 'C');

            $pdf->Rect(25, 80, 100, 10);
            $pdf->SetXY(25, 82); $pdf->Cell(100, 6, 'HASIL PEMBAHASAN', 0, 0, 'C');

            $pdf->Rect(125, 80, 35, 10);
            $pdf->SetXY(125, 80); $pdf->Cell(35, 5, 'PENANGGUNG', 0, 1, 'C');
            $pdf->SetXY(125, 84); $pdf->Cell(35, 5, 'JAWAB', 0, 0, 'C');

            $pdf->Rect(160, 80, 40, 10);
            $pdf->SetXY(160, 80); $pdf->Cell(40, 5, 'TARGET', 0, 1, 'C');
            $pdf->SetXY(160, 84); $pdf->Cell(40, 5, 'WAKTU', 0, 0, 'C');

            // 5. Table Data (Y=90)
            $pdf->SetFont('Arial', '', 9);
            $y = 90;
            $no = 1;
            
            foreach ($notula['hasil_pembahasan'] as $it) {
                $hasil = $it['hasil'];
                // Estimate height needed for text
                $numLines = ceil($pdf->GetStringWidth($hasil) / 95) + substr_count($hasil, "\n");
                $h = max(10, $numLines * 5 + 4);

                if ($y + $h > 260) {
                    $pdf->AddPage();
                    $y = 10;
                }

                $pdf->Rect(10, $y, 15, $h);
                $pdf->Rect(25, $y, 100, $h);
                $pdf->Rect(125, $y, 35, $h);
                $pdf->Rect(160, $y, 40, $h);

                $pdf->SetXY(10, $y + 2);
                $pdf->Cell(15, 5, $no++, 0, 0, 'C');

                $pdf->SetXY(27, $y + 2);
                $pdf->MultiCell(96, 5, $hasil, 0, 'L');

                $pdf->SetXY(125, $y + 2);
                $pdf->MultiCell(35, 5, $it['pic'], 0, 'C');

                $pdf->SetXY(160, $y + 2);
                $targetDate = !empty($it['target']) ? date('d/m/Y', strtotime($it['target'])) : '-';
                $pdf->Cell(40, 5, $targetDate, 0, 0, 'C');

                $y += $h;
            }

            // 6. Signatures
            $sigH = 35;
            if ($y + $sigH > 280) {
                $pdf->AddPage();
                $y = 10;
            }
            $pdf->Rect(10, $y, 190, $sigH); // One big cell
            $pdf->SetXY(10, $y + 3);
            $pdf->Cell(63, 5, 'Disiapkan oleh', 0, 0, 'C');
            $pdf->Cell(63, 5, 'Disetujui oleh', 0, 0, 'C');
            $pdf->Cell(64, 5, 'Disetujui oleh', 0, 1, 'C');

            // --- ADD QR CODES ---
            $qrFiles = [];
            $generateQR = function($text) {
                $tempFile = sys_get_temp_dir() . '/' . uniqid('qr_') . '.png';
                $url = 'https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=' . urlencode($text);
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

            // Disiapkan
            $qrFiles[] = $f = $generateQR('Disiapkan: ' . $notula['nama_disiapkan']);
            if (file_exists($f)) $pdf->Image($f, 33.5, $y + 8, 16, 16);

            // Disetujui 1
            if ($notula['is_approved1']) {
                $qrFiles[] = $f = $generateQR('Disetujui 1: ' . $notula['nama_setuju1'] . "\nApp 1: " . date('Y-m-d'));
                if (file_exists($f)) $pdf->Image($f, 96.5, $y + 8, 16, 16);
            }

            // Disetujui 2
            if ($notula['is_approved2']) {
                $qrFiles[] = $f = $generateQR('Disetujui 2: ' . $notula['nama_setuju2'] . "\nApp 2: " . date('Y-m-d'));
                if (file_exists($f)) $pdf->Image($f, 160, $y + 8, 16, 16);
            }

            $pdf->SetXY(10, $y + 25);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(63, 4, $notula['nama_disiapkan'], 0, 0, 'C');
            $pdf->Cell(63, 4, $notula['nama_setuju1'], 0, 0, 'C');
            $pdf->Cell(64, 4, $notula['nama_setuju2'], 0, 1, 'C');

            $pdf->SetXY(10, $y + 29);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(63, 4, $notula['jabatan_disiapkan'], 0, 0, 'C');
            $pdf->Cell(63, 4, $notula['jabatan_setuju1'], 0, 0, 'C');
            $pdf->Cell(64, 4, $notula['jabatan_setuju2'], 0, 1, 'C');

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
            return redirect()->back()->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
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

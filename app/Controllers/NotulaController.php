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

        if ($id) {
            $notula = $db->table('notula_rapat')->where('id', $id)->get()->getRowArray();
            if ($notula) {
                $notula['hasil_pembahasan'] = json_decode($notula['hasil_pembahasan'], true);
            }
        }

        $data = [
            'doc_number' => 'FP-MR07-04',
            'revision' => '00',
            'notula' => $notula,
            'app_id' => $app_id ?? ($notula['aplikasi_id'] ?? null)
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
        if ($notula['is_approved1'] && $notula['is_approved2']) {
            $db->table('notula_rapat')->where('id', $id)->update(['is_final' => 1]);
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

            $data = [
                'doc_number' => 'FP-MR07-04',
                'revision' => '00',
                'notula' => $notula,
                'logo_base64' => null
            ];

            $html = view('notula/export_pdf_v', $data);

            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('isHtml5ParserEnabled', true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return $this->response->setHeader('Content-Type', 'application/pdf')
                                  ->setHeader('Content-Disposition', 'attachment; filename="Notula_Rapat_'.$id.'.pdf"')
                                  ->setBody($dompdf->output());

        } catch (\Exception $e) {
            log_message('error', 'Notula Export Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
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

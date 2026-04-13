<?php

namespace App\Controllers;

use App\Models\AssetModel;
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

        // 3. Query Data
        $builder = $model;
        if ($keyword) {
            $builder = $builder->groupStart()
                               ->like('nama_aset', $keyword)
                               ->orLike('pic', $keyword)
                               ->groupEnd();
        }
        if ($kategori) $builder = $builder->where('kategori', $kategori);
        if ($status)   $builder = $builder->where('status', $status);

        // 4. Siapkan Data untuk View
        $data = [
            'semua_aset' => $builder->findAll(),
            'total_aset' => $model->countAll(),
            'keyword'    => $keyword,
            'kategori'   => $kategori,
            'status'     => $status
        ];

        return view('dashboard_v', $data);
    }

    // Fungsi lain (add, save, edit, update, delete) biarkan seperti kode lama kamu
    public function add() { 
        if (!session()->get('logged_in')) return redirect()->to('/');
        return view('add_asset_v'); 
    }

    public function save() {
        $model = new AssetModel();
        $model->save([
            'nama_aset' => $this->request->getPost('nama_aset'),
            'kategori'  => $this->request->getPost('kategori'),
            'status'    => $this->request->getPost('status'),
            'pic'       => $this->request->getPost('pic'),
        ]);
        return redirect()->to('/dashboard')->with('sukses', 'Aset Berhasil Ditambah!');
    }

    public function edit($id) {
        if (!session()->get('logged_in')) return redirect()->to('/');
        $model = new AssetModel();
        $data['aset'] = $model->find($id);
        return view('edit_asset_v', $data);
    }

    public function update($id) {
        $model = new AssetModel();
        $model->update($id, [
            'nama_aset' => $this->request->getPost('nama_aset'),
            'kategori'  => $this->request->getPost('kategori'),
            'status'    => $this->request->getPost('status'),
            'pic'       => $this->request->getPost('pic'),
        ]);
        return redirect()->to('/dashboard')->with('sukses', 'Aset Berhasil Diperbarui!');
    }

    public function delete($id) {
        if (!session()->get('logged_in')) return redirect()->to('/');
        $model = new AssetModel();
        $model->delete($id);
        return redirect()->to('/dashboard')->with('sukses', 'Aset Berhasil Dihapus!');
    }

    public function export()
    {
        if (!session()->get('logged_in')) return redirect()->to('/');
        $model = new AssetModel();
        $data = [
            'semua_aset' => $model->findAll(),
            'tgl_cetak'  => date('d F Y'),
            'user'       => session()->get('username')
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
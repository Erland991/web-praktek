<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CobitModel;
use App\Models\LogModel;

class Cobit extends BaseController
{
    public function index()
    {
        $model = new CobitModel();
        $data['cobit'] = $model->findAll();
        return view('admin/master/cobit_v', $data);
    }

    public function save()
    {
        if (session()->get('role') != 'Admin') return redirect()->back();

        $model = new CobitModel();
        $data = [
            'domain'       => $this->request->getPost('domain'),
            'kode_proses'  => $this->request->getPost('kode_proses'),
            'nama_proses'  => $this->request->getPost('nama_proses'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'tujuan_audit' => $this->request->getPost('tujuan_audit'),
            'created_at'   => date('Y-m-d H:i:s')
        ];

        $model->save($data);
        (new LogModel())->record('TAMBAH COBIT', 'Menambahkan standar COBIT: ' . $data['kode_proses']);

        return redirect()->back()->with('sukses', 'Standar COBIT-19 berhasil didaftarkan.');
    }

    public function delete($id)
    {
        if (session()->get('role') != 'Admin') return redirect()->back();
        (new CobitModel())->delete($id);
        (new LogModel())->record('HAPUS COBIT', 'Menghapus standar COBIT ID: ' . $id);
        return redirect()->back()->with('sukses', 'Standar berhasil dihapus.');
    }
}

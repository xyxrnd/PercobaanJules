<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\BarangModel;

class Barang extends BaseController
{
    protected $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        $data = [
            'barang' => $this->barangModel->findAll()
        ];
        return view('barang/index', $data);
    }

    public function new()
    {
        return view('barang/create');
    }

    public function create()
    {
        $rules = [
            'nama'  => 'required',
            'harga' => 'required|integer',
            'stok'  => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->barangModel->save([
            'nama'      => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga'     => $this->request->getPost('harga'),
            'stok'      => $this->request->getPost('stok'),
        ]);

        return redirect()->to('/barang')->with('message', 'Data barang berhasil ditambahkan.');
    }

    public function edit($id = null)
    {
        $data = [
            'barang' => $this->barangModel->find($id)
        ];

        if (empty($data['barang'])) {
            return redirect()->to('/barang')->with('error', 'Barang tidak ditemukan.');
        }

        return view('barang/edit', $data);
    }

    public function update($id = null)
    {
        $rules = [
            'nama'  => 'required',
            'harga' => 'required|integer',
            'stok'  => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->barangModel->update($id, [
            'nama'      => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga'     => $this->request->getPost('harga'),
            'stok'      => $this->request->getPost('stok'),
        ]);

        return redirect()->to('/barang')->with('message', 'Data barang berhasil diubah.');
    }

    public function delete($id = null)
    {
        $this->barangModel->delete($id);
        return redirect()->to('/barang')->with('message', 'Data barang berhasil dihapus.');
    }
}

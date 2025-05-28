<?php

namespace App\Controllers;
use App\Models\ProductCategoryModel;

class ProdukKategoriController extends BaseController
{
    public function index()
    {
        $model = new ProductCategoryModel();
        $data['kategori'] = $model->findAll();
        return view('v_produkkategori', $data); 
    }

    public function store()
    {
        $model = new ProductCategoryModel();
        $name = $this->request->getPost('name');

        if ($name) {
            $model->save(['name' => $name]);
            return redirect()->to('/kategori')->with('success', 'Data berhasil ditambah');
        }

        return redirect()->to('/kategori')->with('error', 'Gagal menyimpan data');
    }

    public function update($id)
    {
        $model = new ProductCategoryModel();
        $name = $this->request->getPost('name');

        if ($name) {
            $model->update($id, ['name' => $name]);
            return redirect()->to('/kategori')->with('success', 'Data berhasil diubah');
        }

        return redirect()->to('/kategori')->with('error', 'Gagal mengubah data');
    }

    public function delete($id)
    {
        $model = new ProductCategoryModel();

        if ($model->delete($id)) {
            return redirect()->to('/kategori')->with('success', 'Data berhasil dihapus');
        }

        return redirect()->to('/kategori')->with('error', 'Gagal menghapus data');
    }
}
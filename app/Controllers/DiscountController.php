<?php

namespace App\Controllers;

use App\Models\DiscountModel;

class DiscountController extends BaseController
{
    public function index()
    {
        if (session('role') !== 'admin') return redirect()->to('/');
        $model = new DiscountModel();
        $data['diskon'] = $model->orderBy('tanggal', 'ASC')->findAll();
        return view('v_discount', $data);
    }

    public function store()
    {
        if (session('role') !== 'admin') return redirect()->to('/');
        $model = new DiscountModel();

        $rules = [
            'tanggal' => 'required|is_unique[discount.tanggal]',
            'nominal' => 'required|numeric'
        ];

        if (! $this->validate($rules)) {
            $errorMessages = $this->validator->getErrors();
            $firstError = reset($errorMessages); // Ambil 1 pesan pertama
            return redirect()->to('/discount')->with('error', $firstError)->withInput();
        }

        $model->save([
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/discount')->with('success', 'Diskon berhasil ditambahkan.');
    }

    public function update($id)
    {
        if (session('role') !== 'admin') return redirect()->to('/');
        $model = new DiscountModel();

        $model->update($id, [
            'nominal' => $this->request->getPost('nominal'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/discount')->with('success', 'Diskon berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session('role') !== 'admin') return redirect()->to('/');
        $model = new DiscountModel();
        $model->delete($id);
        return redirect()->to('/discount')->with('success', 'Diskon berhasil dihapus.');
    }

    
}

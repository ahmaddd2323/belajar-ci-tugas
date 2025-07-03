<?php

namespace App\Controllers;

use App\Models\ProductModel;
use Dompdf\Dompdf;

class ProdukController extends BaseController
{
    protected $product;

    function __construct()
    {
        $this->product = new ProductModel();
    }

    public function index()
    {
        $product = $this->product->findAll();
        $data['product'] = $product;

        return view('v_produk', $data);
    }

    public function create()
    {
        $dataFoto = $this->request->getFile('foto');

        $dataForm = [
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'jumlah' => $this->request->getPost('jumlah'),
            'created_at' => date("Y-m-d H:i:s")
        ];

        if ($dataFoto->isValid()) {
            $fileName = $dataFoto->getRandomName();
            $dataForm['foto'] = $fileName;
            $dataFoto->move('img/', $fileName);
        }

        $this->product->insert($dataForm);

        return redirect('produk')->with('success', 'Data Berhasil Ditambah');
    }

    public function edit($id)
    {
        $dataProduk = $this->product->find($id);

        $dataForm = [
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'jumlah' => $this->request->getPost('jumlah'),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        if ($this->request->getPost('check') == 1) {
            if ($dataProduk['foto'] != '' && file_exists("img/" . $dataProduk['foto'])) {
                unlink("img/" . $dataProduk['foto']);
            }

            $dataFoto = $this->request->getFile('foto');

            if ($dataFoto->isValid()) {
                $fileName = $dataFoto->getRandomName();
                $dataFoto->move('img/', $fileName);
                $dataForm['foto'] = $fileName;
            }
        }

        $this->product->update($id, $dataForm);

        return redirect('produk')->with('success', 'Data Berhasil Diubah');
    }

    public function delete($id)
    {
        $dataProduk = $this->product->find($id);

        if ($dataProduk['foto'] != '' && file_exists("img/" . $dataProduk['foto'])) {
            unlink("img/" . $dataProduk['foto']);
        }

        $this->product->delete($id);

        return redirect('produk')->with('success', 'Data Berhasil Dihapus');
    }

    public function download()
    {
        $product = $this->product->findAll();
        $html = view('v_produkPDF', ['product' => $product]);
        $filename = date('y-m-d-H-i-s') . '-produk';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($filename);
    }

    //Tambahan: Add to Cart dengan Diskon
    public function addToCart($id)
    {
        $cart = \Config\Services::cart();
        $produk = $this->product->find($id);

        if (!$produk) {
            return redirect()->to('/produk')->with('error', 'Produk tidak ditemukan.');
        }

        // Ambil diskon dari session
        $discount = session()->get('discount_nominal') ?? 0;
        $hargaSetelahDiskon = $produk['harga'] - $discount;
        if ($hargaSetelahDiskon < 0) $hargaSetelahDiskon = 0;

        $cart->insert([
            'id'      => $produk['id'],
            'qty'     => 1,
            'price'   => $hargaSetelahDiskon,
            'name'    => $produk['nama'],
            'options' => [
                'harga_asli' => $produk['harga'],
                'foto' => $produk['foto'] ?? ''
            ]
        ]);

        return redirect()->to('/keranjang')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }
}

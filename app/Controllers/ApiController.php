<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

use App\Models\UserModel; 
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;  


class ApiController extends ResourceController
{
    protected $apiKey; 
    protected $user; 
    protected $transaction; 
    protected $transaction_detail;

    function __construct()
    {
        $this->apiKey=env('API_KEY');
        $this->user=new UserModel();
        $this->transaction=new TransactionModel();
        $this->transaction_detail=new TransactionDetailModel();
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
{
    $key = $this->request->getHeaderLine('key');
    if ($key !== 'random123678abcghi') {
        return $this->response->setJSON(['status' => false, 'message' => 'Unauthorized']);
    }

    $transaksi = $this->transaction->findAll();

    foreach ($transaksi as &$row) {
        $detail = $this->transaction_detail
            ->where('transaction_id', $row['id'])
            ->selectSum('jumlah')
            ->first();

        $row['jumlah_item'] = $detail['jumlah'] ?? 0;

        // Format status
        $row['status'] = $row['status'] == 1 ? 'Sudah Selesai' : 'Belum Selesai';
    }

    return $this->response->setJSON([
        'status' => true,
        'results' => $transaksi
    ]);
}


    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
} 
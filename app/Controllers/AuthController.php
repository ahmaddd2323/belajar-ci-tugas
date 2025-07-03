<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UserModel; 
use App\Models\DiscountModel; 

class AuthController extends BaseController
{
    protected $user; 
    protected $discount;
    
    function __construct()
    {
        helper('form');
        $this->user=new UserModel(); 
        $this->discount= new DiscountModel(); 
    }

    public function login()
{
    if ($this->request->getPost()) {
        $rules = [
            'username' => 'required|min_length[6]',
            'password' => 'required|min_length[7]|numeric',
        ];

        if ($this->validate($rules)) {
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            $dataUser = $this->user->where(['username' => $username])->first();

            if ($dataUser) {
                if (password_verify($password, $dataUser['password'])) {

                    // Ambil data diskon hari ini
                    $today = date('Y-m-d');
                    $diskon = $this->discount->where('tanggal', $today)->first();

                    // Set semua data ke session sekaligus
                    $sessionData = [
                        'id' => $dataUser['id'],
                        'username' => $dataUser['username'],
                        'role' => $dataUser['role'],
                        'isLoggedIn' => TRUE,
                        'discount_nominal' => $diskon ? $diskon['nominal'] : null
                    ];

                    session()->set($sessionData);

                    return redirect()->to(base_url('/'));

                } else {
                    session()->setFlashdata('failed', 'Kombinasi Username & Password Salah');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('failed', 'Username Tidak Ditemukan');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('failed', $this->validator->listErrors());
            return redirect()->back();
        }
    }

    return view('v_login');
}


public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}
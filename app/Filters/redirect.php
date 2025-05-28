<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class Redirect implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Cek apakah user baru saja login
        if ($session->get('just_logged_in')) {
            // Hapus flag supaya tidak redirect terus
            $session->remove('just_logged_in');

            // Redirect ke halaman contact
            return redirect()->to('/contact');
        }

        // Tidak ada redirect
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak digunakan
    }
}
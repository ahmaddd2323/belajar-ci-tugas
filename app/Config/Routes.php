<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

$routes->group('produk', ['filter' => 'auth'], function ($routes) { 
    $routes->get('', 'ProdukController::index');
    $routes->post('', 'ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    $routes->get('download', 'ProdukController::download');
});

$routes->group('produkkategori', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'ProdukKategoriController::index');
    $routes->post('/kategori/update/(:num)', 'ProdukKategoriController::update/$1');
});

$routes->post('/kategori/delete/(:num)', 'ProdukKategoriController::delete/$1');
$routes->get('/kategori', 'ProdukKategoriController::index');
$routes->post('/kategori/store', 'ProdukKategoriController::store');

$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('', 'TransaksiController::cart_add');
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});

$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);
$routes->get('contact', 'ContactController::index', ['filter' => 'auth']);
$routes->get('contact', 'ContactController::index', ['filter' => 'redirect']);
$routes->get('get-location', 'TransaksiController::getLocation', ['filter' => 'auth']);
$routes->get('get-cost', 'TransaksiController::getCost', ['filter' => 'auth']);
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);

$routes->get('contact', 'ContactController::index', ['filter' => 'auth']);
$routes->get('contact', 'ContactController::index', ['filter' => 'redirect']);
$routes->get('profile', 'Home::profile', ['filter' => 'auth']);
$routes->resource('api', ['controller' => 'apiController']);

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('discount', 'DiscountController::index');
    $routes->get('discount/create', 'DiscountController::create');
    $routes->post('discount/store', 'DiscountController::store');
    $routes->get('discount/edit/(:num)', 'DiscountController::edit/$1');
    $routes->post('discount/update/(:num)', 'DiscountController::update/$1');
    $routes->post('discount/delete/(:num)', 'DiscountController::delete/$1');
});
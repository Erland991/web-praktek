<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->post('/login_action', 'Auth::login_action');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/logout', 'Auth::logout');
$routes->get('/dashboard/delete/(:num)', 'Dashboard::delete/$1');
$routes->get('/dashboard/add', 'Dashboard::add'); // Halaman form
$routes->post('/dashboard/save', 'Dashboard::save'); // Proses simpan ke database
$routes->get('/dashboard/edit/(:num)', 'Dashboard::edit/$1');
$routes->post('/dashboard/update/(:num)', 'Dashboard::update/$1');

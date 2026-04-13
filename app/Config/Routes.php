<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- AUTH / LOGIN ---
$routes->get('/', 'Home::index');
$routes->post('/login', 'Home::login');
$routes->get('/logout', 'Home::logout');

// --- DASHBOARD ---
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/dashboard/add', 'Dashboard::add');
$routes->post('/dashboard/save', 'Dashboard::save');
$routes->get('/dashboard/edit/(:num)', 'Dashboard::edit/$1');
$routes->post('/dashboard/update/(:num)', 'Dashboard::update/$1');
$routes->get('/dashboard/delete/(:num)', 'Dashboard::delete/$1');
$routes->get('/dashboard/export', 'Dashboard::export');

// --- MASTER DATA ---
$routes->group('master', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    
    // Kelola Karyawan
    $routes->get('karyawan', 'Master::karyawan');
    $routes->post('karyawan/save', 'Master::saveKaryawan');
    
    // INI YANG TADI SALAH TEMPAT (Sekarang sudah di dalam group)
    $routes->post('karyawan/update/(:num)', 'Master::updateKaryawan/$1'); 
    
    $routes->get('karyawan/delete/(:num)', 'Master::deleteKaryawan/$1');

    // Kelola Divisi
    $routes->get('divisi', 'Master::divisi');
    $routes->post('divisi/save', 'Master::saveDivisi');
    $routes->get('divisi/delete/(:num)', 'Master::deleteDivisi/$1');
});
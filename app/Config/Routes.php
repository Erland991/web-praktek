<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- AUTH / LOGIN ---
$routes->get('/', 'Home::index');
$routes->get('/login-page', 'Home::loginPage');
$routes->post('/login', 'Home::login');
$routes->get('/logout', 'Home::logout');
$routes->get('/setup-database', 'DatabaseSetup::index');

// --- DASHBOARD ---
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/dashboard/add', 'Dashboard::add');
$routes->post('/dashboard/save', 'Dashboard::save');
$routes->get('/dashboard/edit/(:num)', 'Dashboard::edit/$1');
$routes->post('/dashboard/update/(:num)', 'Dashboard::update/$1');
$routes->get('/dashboard/delete/(:num)', 'Dashboard::delete/$1');
$routes->get('/dashboard/export', 'Dashboard::export');

// --- PROGRESS FEATURES ---
$routes->get('/progress', 'Progress::index');
$routes->post('/progress/update', 'Progress::update');

// --- VIEWER FEATURES ---
$routes->get('/monitoring', 'Viewer\Monitoring::index');
$routes->get('/document-center', 'DocumentCenter::index');

// --- CALENDAR FEATURES ---
$routes->get('/calendar', 'Calendar::index');
$routes->get('/calendar/events', 'Calendar::events');

// --- MASTER DATA ---
$routes->group('master', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    
    // Kelola Karyawan
    $routes->get('karyawan', 'Master::karyawan');
    $routes->get('karyawan/export', 'Master::exportKaryawan');
    $routes->post('karyawan/save', 'Master::saveKaryawan');
    
    // INI YANG TADI SALAH TEMPAT (Sekarang sudah di dalam group)
    $routes->post('karyawan/update/(:num)', 'Master::updateKaryawan/$1'); 
    
    $routes->get('karyawan/delete/(:num)', 'Master::deleteKaryawan/$1');

    // Kelola Divisi
    $routes->get('divisi', 'Master::divisi');
    $routes->post('divisi/save', 'Master::saveDivisi');
    $routes->get('divisi/delete/(:num)', 'Master::deleteDivisi/$1');
});

// --- ADMIN FEATURES ---
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('logs', 'Logs::index');
    $routes->get('logs/clear', 'Logs::clear');
    $routes->get('logs/delete/(:num)', 'Logs::delete/$1');
    
    // Master Aplikasi Register
    $routes->get('app-master', 'AppMaster::index');
    $routes->post('app-master/save', 'AppMaster::save');
    $routes->post('app-master/release', 'AppMaster::release');
    $routes->get('app-master/delete/(:num)', 'AppMaster::delete/$1');

    // Modul & Bobot Per Aplikasi
    $routes->get('app-master/get-modules/(:num)', 'AppMaster::get_modules/$1');
    $routes->post('app-master/save-module', 'AppMaster::save_module');
    $routes->get('app-master/delete-module/(:num)', 'AppMaster::delete_module/$1');

    // Master KPI
    $routes->get('kpi', 'Kpi::index');
    $routes->post('kpi/save', 'Kpi::save');
    $routes->get('kpi/delete/(:num)', 'Kpi::delete/$1');

    // Master COBIT
    $routes->get('cobit', 'Cobit::index');
    $routes->post('cobit/save', 'Cobit::save');
    $routes->get('cobit/delete/(:num)', 'Cobit::delete/$1');

    // Approval Progress
    $routes->get('approval', 'Approval::index');
    $routes->post('approval/action/(:num)/(:num)', 'Approval::action/$1/$2');
});
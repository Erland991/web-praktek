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
$routes->get('/test_db', 'Home::test_db');
$routes->get('/test_c', 'TestController::index');
$routes->get('/test_d', 'TestController::data');
$routes->get('/test_insert', 'TestController::insert_data');
$routes->get('/test_master', 'TestController::test_master');
$routes->get('/setup-database', 'DatabaseSetup::index');

// --- DASHBOARD ---
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/dashboard/add', 'Dashboard::add');
$routes->post('/dashboard/save', 'Dashboard::save');
$routes->get('/dashboard/edit/(:num)', 'Dashboard::edit/$1');
$routes->post('/dashboard/update/(:num)', 'Dashboard::update/$1');
$routes->get('/dashboard/delete/(:num)', 'Dashboard::delete/$1');
$routes->get('/dashboard/export', 'Dashboard::export');
$routes->post('/dashboard/update-profile-photo', 'Dashboard::updateProfilePhoto');

// --- PROGRESS FEATURES ---
$routes->get('/progress', 'Progress::index');
$routes->post('/progress/update', 'Progress::update');
$routes->post('/progress/updateSdlc', 'Progress::updateSdlc');

// --- VIEWER FEATURES ---
$routes->get('/monitoring', 'Viewer\Monitoring::index');
$routes->get('/document-center', 'DocumentCenter::index');

// --- CALENDAR FEATURES ---
$routes->get('/calendar', 'Calendar::index');
$routes->get('/calendar/events', 'Calendar::events');

// --- NOTULA FEATURES ---
$routes->get('/notula', 'NotulaController::index');
$routes->get('/notula/list/(:num)', 'NotulaController::list/$1');
$routes->get('/notula/edit/(:num)', 'NotulaController::index/$1');
$routes->post('/notula/save', 'NotulaController::save');
$routes->get('/notula/verify/(:num)', 'NotulaController::verify/$1');
$routes->get('/notula/approve/(:num)/(:num)', 'NotulaController::approve/$1/$2');
$routes->get('/notula/duplicate/(:num)', 'NotulaController::duplicate/$1');
$routes->post('/notula/revise/(:num)', 'NotulaController::revise/$1');
$routes->get('/notula/export/(:num)', 'NotulaController::export/$1');
$routes->get('/notula/print/(:num)', 'NotulaController::print/$1');

// --- PERMINTAAN APLIKASI ---
$routes->get('/permintaan', 'PermintaanController::index');
$routes->get('/permintaan/list', 'PermintaanController::list');
$routes->get('/permintaan/edit/(:num)', 'PermintaanController::index/$1');
$routes->post('/permintaan/save', 'PermintaanController::save');
$routes->get('/permintaan/approve/(:num)', 'PermintaanController::approve/$1');
$routes->get('/permintaan/verify/(:num)', 'PermintaanController::verify/$1');
$routes->get('/permintaan/export/(:num)', 'PermintaanController::export/$1');


// --- ABSENSI FEATURES ---
$routes->get('/absensi', 'AbsensiController::index');
$routes->get('/absensi/list', 'AbsensiController::list');
$routes->get('/absensi/edit/(:num)', 'AbsensiController::index/$1');
$routes->post('/absensi/save', 'AbsensiController::save');
$routes->get('/absensi/delete/(:num)', 'AbsensiController::delete/$1');
$routes->get('/absensi/pdf/(:num)', 'AbsensiController::pdf/$1');

// --- MASTER DATA ---
$routes->group('master', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    
    // Kelola Karyawan
    $routes->get('karyawan', 'Master::karyawan');
    $routes->get('karyawan/export', 'Master::exportKaryawan');
    $routes->post('karyawan/save', 'Master::saveKaryawan');
    
    // INI YANG TADI SALAH TEMPAT (Sekarang sudah di dalam group)
    $routes->post('karyawan/update/(:num)', 'Master::updateKaryawan/$1'); 
    
    $routes->get('karyawan/delete/(:num)', 'Master::deleteKaryawan/$1');
    $routes->get('karyawan/detail/(:num)', 'Master::detailKaryawan/$1');

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

    // Approval Notula/Memo
    $routes->get('approval/approve-notula/(:num)/(:num)', 'Approval::approve_notula/$1/$2');

    // Persetujuan Memo (halaman khusus, akses semua user)
    $routes->get('approval/memo', 'Approval::memo_persetujuan');
});

// --- MEMO PERSETUJUAN (shortcut, akses semua user) ---
$routes->get('memo/persetujuan', 'Admin\Approval::memo_persetujuan');
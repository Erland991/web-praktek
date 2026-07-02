<?php
// Script debug sederhana untuk test koneksi Google Calendar
// Akses via: http://localhost:8080/public/test_gcal.php

define('APPPATH', __DIR__ . '/../app/');
define('FCPATH', __DIR__ . '/');

// Load composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

$credentialsPath = APPPATH . 'credentials.json';

echo "<h2>Test Google Calendar API</h2>";

// 1. Cek file credentials
if (!file_exists($credentialsPath)) {
    die("<p style='color:red;'>GAGAL: File credentials.json TIDAK DITEMUKAN di: " . $credentialsPath . "</p>");
}
echo "<p style='color:green;'>OK: File credentials.json ditemukan.</p>";

// 2. Baca isi credentials untuk cek type
$creds = json_decode(file_get_contents($credentialsPath), true);
echo "<p>Tipe: <b>" . ($creds['type'] ?? 'TIDAK ADA') . "</b></p>";
echo "<p>Client Email: <b>" . ($creds['client_email'] ?? 'TIDAK ADA') . "</b></p>";

if (($creds['type'] ?? '') !== 'service_account') {
    die("<p style='color:red;'>GAGAL: Tipe credentials bukan 'service_account'. Pastikan kamu download JSON dari Service Account, bukan OAuth Client.</p>");
}
echo "<p style='color:green;'>OK: Tipe credentials sudah benar (service_account).</p>";

// 3. Coba koneksi
try {
    $client = new Google_Client();
    $client->setApplicationName('Test Calendar');
    $client->setScopes([Google_Service_Calendar::CALENDAR, Google_Service_Calendar::CALENDAR_EVENTS]);
    $client->setAuthConfig($credentialsPath);

    $service = new Google_Service_Calendar($client);
    
    // Coba buat event test
    $event = new Google_Service_Calendar_Event([
        'summary' => '[TEST] Event dari Sistem - Bisa Dihapus',
        'description' => 'Ini adalah event test untuk verifikasi koneksi Google Calendar API.',
        'start' => [
            'dateTime' => date('c', strtotime('tomorrow 09:00')),
            'timeZone' => 'Asia/Jakarta',
        ],
        'end' => [
            'dateTime' => date('c', strtotime('tomorrow 10:00')),
            'timeZone' => 'Asia/Jakarta',
        ],
    ]);
    
    $calendarId = 'erland3112@gmail.com';
    $createdEvent = $service->events->insert($calendarId, $event);
    
    echo "<hr>";
    echo "<p style='color:green; font-size:18px;'><b>BERHASIL!</b> Event test telah dibuat di kalender kamu!</p>";
    echo "<p>Link Event: <a href='" . $createdEvent->htmlLink . "' target='_blank'>" . $createdEvent->htmlLink . "</a></p>";
    
} catch (Exception $e) {
    echo "<hr>";
    echo "<p style='color:red;'>GAGAL terkoneksi ke Google Calendar API.</p>";
    echo "<p><b>Pesan Error:</b><br><pre style='background:#fee;padding:10px;'>" . htmlspecialchars($e->getMessage()) . "</pre></p>";
    echo "<p>Salin pesan error di atas dan kirimkan ke saya untuk saya bantu debug ya!</p>";
}

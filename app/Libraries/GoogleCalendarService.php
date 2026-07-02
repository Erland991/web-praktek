<?php

namespace App\Libraries;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Exception;

class GoogleCalendarService
{
    protected $client;
    protected $service;
    protected $calendarId;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName('Sistem Informasi Terintegrasi Calendar');
        $this->client->setScopes([Google_Service_Calendar::CALENDAR, Google_Service_Calendar::CALENDAR_EVENTS]);
        
        // Sesuaikan path ini dengan lokasi file credentials.json kamu nantinya
        $credentialsPath = APPPATH . 'credentials.json';
        
        if (file_exists($credentialsPath)) {
            $this->client->setAuthConfig($credentialsPath);
        }
        
        // Kita gunakan ID kalender spesifik kamu (agar tidak masuk ke kalender internal Service Account)
        $this->calendarId = 'erland3112@gmail.com';
        $this->service = new Google_Service_Calendar($this->client);
    }

    /**
     * Membuat Event Baru
     */
    public function createEvent($summary, $description, $location, $startDate, $endDate, $attendees = [])
    {
        try {
            // Format attendees
            $formattedAttendees = [];
            foreach ($attendees as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $formattedAttendees[] = ['email' => $email];
                }
            }

            $event = new Google_Service_Calendar_Event([
                'summary' => $summary,
                'location' => $location,
                'description' => $description,
                'start' => [
                    // Asumsi format 'Y-m-d\TH:i:sP'
                    'dateTime' => date('c', strtotime($startDate)),
                    'timeZone' => 'Asia/Jakarta',
                ],
                'end' => [
                    'dateTime' => date('c', strtotime($endDate)),
                    'timeZone' => 'Asia/Jakarta',
                ],
                'attendees' => $formattedAttendees,
                'reminders' => [
                    'useDefault' => FALSE,
                    'overrides' => [
                        ['method' => 'email', 'minutes' => 24 * 60],
                        ['method' => 'popup', 'minutes' => 30],
                    ],
                ],
            ]);

            $event = $this->service->events->insert($this->calendarId, $event, ['sendUpdates' => 'all']);
            return $event->htmlLink;
        } catch (Exception $e) {
            log_message('error', 'Google Calendar API Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Membuat All-Day Event (seperti deadline)
     */
    public function createAllDayEvent($summary, $description, $date)
    {
        try {
            $event = new Google_Service_Calendar_Event([
                'summary' => $summary,
                'description' => $description,
                'start' => [
                    'date' => date('Y-m-d', strtotime($date)),
                    'timeZone' => 'Asia/Jakarta',
                ],
                'end' => [
                    'date' => date('Y-m-d', strtotime($date . ' + 1 days')),
                    'timeZone' => 'Asia/Jakarta',
                ],
                'reminders' => [
                    'useDefault' => FALSE,
                    'overrides' => [
                        ['method' => 'email', 'minutes' => 24 * 60],
                        ['method' => 'popup', 'minutes' => 10],
                    ],
                ],
            ]);

            $event = $this->service->events->insert($this->calendarId, $event);
            return $event->htmlLink;
        } catch (Exception $e) {
            log_message('error', 'Google Calendar API Error: ' . $e->getMessage());
            return false;
        }
    }
}

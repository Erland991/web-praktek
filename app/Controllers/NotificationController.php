<?php

namespace App\Controllers;

class NotificationController extends BaseController
{
    public function readAll()
    {
        if (!session()->get('logged_in')) return redirect()->to('/');
        $db = \Config\Database::connect();
        $userId = session()->get('id');
        
        if ($db->tableExists('notifikasi')) {
            $db->table('notifikasi')
               ->groupStart()
                   ->where('user_id', $userId)
                   ->orWhere('user_id', 0)
               ->groupEnd()
               ->update(['is_read' => 1]);
        }
        return redirect()->back();
    }

    public function read($id)
    {
        if (!session()->get('logged_in')) return redirect()->to('/');
        $db = \Config\Database::connect();
        
        if ($db->tableExists('notifikasi')) {
            $db->table('notifikasi')->where('id', $id)->update(['is_read' => 1]);
        }
        return redirect()->to('/dashboard'); // or redirect back
    }
}

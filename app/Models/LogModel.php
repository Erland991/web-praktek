<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table            = 'system_logs';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'username', 'aksi', 'keterangan', 'ip_address', 'user_agent', 'created_at'];
    protected $useTimestamps    = false;

    public function record($aksi, $keterangan = '')
    {
        return $this->save([
            'user_id'    => session()->get('id'),
            'username'   => session()->get('username') ?? 'System',
            'aksi'       => $aksi,
            'keterangan' => $keterangan,
            'ip_address' => service('request')->getIPAddress(),
            'user_agent' => service('request')->getUserAgent()->getAgentString(),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}

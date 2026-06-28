<?php

class LogAktivitas
{
    private $conn;
    private $table = 'log_aktivitas';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllWithRelations($search = '')
    {
        $query = "
            SELECT 
                l.id_log, l.aktivitas, l.ip_address, l.created_at,
                u.nama, u.username,
                r.nama_role
            FROM {$this->table} l
            JOIN users u ON l.id_user = u.id_user
            JOIN roles r ON l.id_role = r.id_role
        ";
        
        if ($search != '') {
            $safe_search = $this->conn->real_escape_string($search);
            $query .= " WHERE (l.aktivitas LIKE '%$safe_search%' OR u.nama LIKE '%$safe_search%' OR u.username LIKE '%$safe_search%')";
        }

        $query .= " ORDER BY l.created_at DESC";
        
        return mysqli_query($this->conn, $query);
    }
}
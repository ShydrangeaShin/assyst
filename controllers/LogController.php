<?php

class LogController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function index()
    {
        $page_title = "Log Aktivitas Sistem";
        $breadcrumbs = ["Sistem", "Log Aktivitas"];
        
        $search = $_GET['search'] ?? '';

        // Query relasional untuk mengambil riwayat aktivitas
        $query = "
            SELECT 
                l.id_log, l.aktivitas, l.ip_address, l.created_at,
                u.nama, u.username,
                r.nama_role
            FROM log_aktivitas l
            JOIN users u ON l.id_user = u.id_user
            JOIN roles r ON u.id_role = r.id_role
        ";
        
        // Fitur pencarian berdasarkan aktivitas atau nama user
        if ($search != '') {
            $safe_search = $this->conn->real_escape_string($search);
            $query .= " WHERE (l.aktivitas LIKE '%$safe_search%' OR u.nama LIKE '%$safe_search%' OR u.username LIKE '%$safe_search%')";
        }

        // Urutkan dari aktivitas terbaru
        $query .= " ORDER BY l.created_at DESC";
        
        $logs = mysqli_query($this->conn, $query);

        $content = "views/log/index.php";
        include "views/layouts/app.php";
    }
}
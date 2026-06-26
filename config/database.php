<?php

class Database
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "db_assyst";

    public $conn;

    public function connect()
    {
        $this->conn = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->db
        );

        if ($this->conn->connect_error) {
            die("Koneksi Database Gagal : " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8");

        return $this->conn;
    }
}

$db = new Database();
$conn = $db->connect();
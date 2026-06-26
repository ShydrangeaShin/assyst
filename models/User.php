<?php

class User
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($username)
    {
        $stmt = $this->conn->prepare("
            SELECT
            u.id_user,
            u.nama,
            u.username,
            u.password,
            u.status_akun,
            r.nama_role
            FROM users u
            JOIN roles r
            ON r.id_role = u.id_role
            WHERE u.username = ?
        ");

        $stmt->bind_param("s", $username);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
}
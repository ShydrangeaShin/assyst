<?php

class TugasController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function index()
    {
        $page_title = "Data Tugas Petugas";
        $breadcrumbs = ["Manajemen", "Tugas"];
        
        $search = $_GET['search'] ?? '';
        $role = $_SESSION['user']['role'];
        $id_user_login = $_SESSION['user']['id'];

        // Ambil Data Wilayah untuk Dropdown Cascading
        $provinsi = []; $kota = []; $kecamatan = []; $desa = [];
        if ($role == 'Admin') {
            $qProv = mysqli_query($this->conn, "SELECT * FROM provinsi ORDER BY nama_provinsi ASC");
            while ($r = mysqli_fetch_assoc($qProv)) { $provinsi[] = $r; }

            $qKota = mysqli_query($this->conn, "SELECT id_kota, id_provinsi, nama_kota FROM kota ORDER BY nama_kota ASC");
            while ($r = mysqli_fetch_assoc($qKota)) { $kota[] = $r; }

            $qKec = mysqli_query($this->conn, "SELECT id_kecamatan, id_kota, nama_kecamatan FROM kecamatan ORDER BY nama_kecamatan ASC");
            while ($r = mysqli_fetch_assoc($qKec)) { $kecamatan[] = $r; }

            $qDesa = mysqli_query($this->conn, "SELECT id_desa, id_kecamatan, nama_desa FROM desa ORDER BY nama_desa ASC");
            while ($r = mysqli_fetch_assoc($qDesa)) { $desa[] = $r; }
        }

        // Query Data sesuai tabel tugas_petugas
        $query = "
            SELECT 
                t.*, u.nama as nama_petugas, 
                d.nama_desa, k.nama_kecamatan, ko.nama_kota 
            FROM tugas_petugas t 
            JOIN users u ON t.id_petugas = u.id_user
            LEFT JOIN desa d ON t.id_desa = d.id_desa
            LEFT JOIN kecamatan k ON d.id_kecamatan = k.id_kecamatan
            LEFT JOIN kota ko ON k.id_kota = ko.id_kota
        ";
        
        $whereClauses = [];
        
        if ($role == 'Petugas') {
            $whereClauses[] = "t.id_petugas = " . (int)$id_user_login;
        }

        if ($search != '') {
            $safe_search = $this->conn->real_escape_string($search);
            $whereClauses[] = "(t.nama_tugas LIKE '%$safe_search%' OR t.deskripsi LIKE '%$safe_search%' OR u.nama LIKE '%$safe_search%' OR d.nama_desa LIKE '%$safe_search%')";
        }

        if (count($whereClauses) > 0) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }
        
        $query .= " ORDER BY t.id_tugas DESC";
        $tugas = mysqli_query($this->conn, $query);

        $petugas = [];
        if ($role == 'Admin') {
            $petugas = mysqli_query($this->conn, "SELECT id_user, nama FROM users WHERE id_role = 2 AND status_akun = 'Aktif'");
        }

        $content = "views/tugas/index.php";
        include "views/layouts/app.php";
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_petugas = (int)$_POST['id_petugas'];
            $id_desa = (int)$_POST['id_desa'];
            $nama_tugas = trim($_POST['nama_tugas']);
            $deskripsi = trim($_POST['deskripsi']);
            $tanggal_penugasan = $_POST['tanggal_penugasan'];
            $status_tugas = 'Belum Dikerjakan';

            if (empty($id_petugas) || empty($id_desa) || empty($nama_tugas) || empty($tanggal_penugasan)) {
                $_SESSION['error'] = "Semua form penugasan termasuk wilayah wajib diisi.";
                header("Location:?page=tugas");
                exit;
            }

            $stmt = $this->conn->prepare("INSERT INTO tugas_petugas (id_petugas, id_desa, nama_tugas, deskripsi, tanggal_penugasan, status_tugas) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissss", $id_petugas, $id_desa, $nama_tugas, $deskripsi, $tanggal_penugasan, $status_tugas);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "Tugas berhasil didistribusikan ke petugas.";
            } else {
                $_SESSION['error'] = "Gagal mendistribusikan data tugas.";
            }
            
            header("Location:?page=tugas");
            exit;
        }
    }

    public function edit($id)
    {
        $page_title = "Update Tugas Petugas";
        $breadcrumbs = ["Manajemen", "Tugas", "Edit"];
        
        $role = $_SESSION['user']['role'];
        $id_user_login = $_SESSION['user']['id'];

        $query = "
            SELECT t.*, u.nama as nama_petugas, 
                   d.id_kecamatan, k.id_kota, ko.id_provinsi,
                   d.nama_desa, k.nama_kecamatan
            FROM tugas_petugas t 
            JOIN users u ON t.id_petugas = u.id_user 
            LEFT JOIN desa d ON t.id_desa = d.id_desa
            LEFT JOIN kecamatan k ON d.id_kecamatan = k.id_kecamatan
            LEFT JOIN kota ko ON k.id_kota = ko.id_kota
            WHERE t.id_tugas = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $data = $stmt->get_result()->fetch_assoc();

        if (!$data || ($role == 'Petugas' && $data['id_petugas'] != $id_user_login)) {
            header("Location:?page=forbidden");
            exit;
        }

        $provinsi = []; $kota = []; $kecamatan = []; $desa = []; $petugas = [];
        if ($role == 'Admin') {
            $petugas = mysqli_query($this->conn, "SELECT id_user, nama FROM users WHERE id_role = 2 AND status_akun = 'Aktif'");
            
            $qProv = mysqli_query($this->conn, "SELECT * FROM provinsi");
            while ($r = mysqli_fetch_assoc($qProv)) { $provinsi[] = $r; }
            $qKota = mysqli_query($this->conn, "SELECT id_kota, id_provinsi, nama_kota FROM kota");
            while ($r = mysqli_fetch_assoc($qKota)) { $kota[] = $r; }
            $qKec = mysqli_query($this->conn, "SELECT id_kecamatan, id_kota, nama_kecamatan FROM kecamatan");
            while ($r = mysqli_fetch_assoc($qKec)) { $kecamatan[] = $r; }
            $qDesa = mysqli_query($this->conn, "SELECT id_desa, id_kecamatan, nama_desa FROM desa");
            while ($r = mysqli_fetch_assoc($qDesa)) { $desa[] = $r; }
        }

        $content = "views/tugas/edit.php";
        include "views/layouts/app.php";
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $role = $_SESSION['user']['role'];
            $id_tugas = (int)$_POST['id_tugas'];
            $status_tugas = $_POST['status_tugas'];

            if ($role == 'Admin') {
                $id_petugas = (int)$_POST['id_petugas'];
                $id_desa = (int)$_POST['id_desa'];
                $nama_tugas = trim($_POST['nama_tugas']);
                $deskripsi = trim($_POST['deskripsi']);
                $tanggal_penugasan = $_POST['tanggal_penugasan'];

                $stmt = $this->conn->prepare("UPDATE tugas_petugas SET id_petugas=?, id_desa=?, nama_tugas=?, deskripsi=?, tanggal_penugasan=?, status_tugas=? WHERE id_tugas=?");
                $stmt->bind_param("iissssi", $id_petugas, $id_desa, $nama_tugas, $deskripsi, $tanggal_penugasan, $status_tugas, $id_tugas);
            } else {
                $stmt = $this->conn->prepare("UPDATE tugas_petugas SET status_tugas=? WHERE id_tugas=?");
                $stmt->bind_param("si", $status_tugas, $id_tugas);
            }

            if ($stmt->execute()) {
                $_SESSION['success'] = "Data tugas berhasil diperbarui.";
            } else {
                $_SESSION['error'] = "Gagal memperbarui data tugas.";
            }

            header("Location:?page=tugas");
            exit;
        }
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM tugas_petugas WHERE id_tugas = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Data tugas berhasil dihapus.";
        } else {
            $_SESSION['error'] = "Gagal menghapus data tugas.";
        }
        header("Location:?page=tugas");
        exit;
    }
}
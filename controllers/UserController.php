<?php

class UserController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function index()
    {
        $page_title = "Manajemen Akun";
        $breadcrumbs = ["Manajemen Akun"];

        // Tangkap parameter search
        $search = $_GET['search'] ?? '';

        $query = "
            SELECT u.*, r.nama_role 
            FROM users u 
            JOIN roles r ON u.id_role = r.id_role 
        ";

        // Terapkan filter pencarian jika ada
        if ($search != '') {
            $safe_search = $this->conn->real_escape_string($search);
            $query .= " WHERE u.nama LIKE '%$safe_search%' 
                        OR u.username LIKE '%$safe_search%' 
                        OR r.nama_role LIKE '%$safe_search%' ";
        }

        $query .= " ORDER BY u.id_role ASC, u.id_user DESC";
        
        $users = mysqli_query($this->conn, $query);

        $content = "views/user/index.php";
        include "views/layouts/app.php";
    }

    public function store()
    {
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $id_role = (int)$_POST['id_role'];
        $status_akun = $_POST['status_akun'];

        // Cek username unik
        $stmt_cek = $this->conn->prepare("SELECT id_user FROM users WHERE username = ?");
        $stmt_cek->bind_param("s", $username);
        $stmt_cek->execute();
        
        if ($stmt_cek->get_result()->num_rows > 0) {
            $_SESSION['error'] = "Username sudah digunakan oleh akun lain.";
            header("Location: index.php?page=user-create");
            exit;
        }

        $stmt = $this->conn->prepare("INSERT INTO users (nama, username, password, id_role, status_akun) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $nama, $username, $password, $id_role, $status_akun);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Data akun berhasil ditambahkan.";
        } else {
            $_SESSION['error'] = "Gagal menambahkan data akun sistem.";
        }
        
        header("Location: index.php?page=user");
        exit;
    }

    public function edit($id)
    {
        $page_title = "Edit Data Akun";
        $breadcrumbs = ["Manajemen Akun", "Edit"];

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id_user = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        $roles = mysqli_query($this->conn, "SELECT * FROM roles");

        $content = "views/user/edit.php";
        include "views/layouts/app.php";
    }

    public function update()
    {
        $id_user = (int)$_POST['id_user'];
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $id_role = (int)$_POST['id_role'];
        $status_akun = $_POST['status_akun'];

        // Cek username unik (menghindari duplikasi dengan user lain)
        $stmt_cek = $this->conn->prepare("SELECT id_user FROM users WHERE username = ? AND id_user != ?");
        $stmt_cek->bind_param("si", $username, $id_user);
        $stmt_cek->execute();
        
        if ($stmt_cek->get_result()->num_rows > 0) {
            $_SESSION['error'] = "Username sudah digunakan oleh pengguna lain.";
            header("Location: index.php?page=user-edit&id=" . $id_user);
            exit;
        }

        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("UPDATE users SET nama=?, username=?, password=?, id_role=?, status_akun=? WHERE id_user=?");
            $stmt->bind_param("sssisi", $nama, $username, $password, $id_role, $status_akun, $id_user);
        } else {
            $stmt = $this->conn->prepare("UPDATE users SET nama=?, username=?, id_role=?, status_akun=? WHERE id_user=?");
            $stmt->bind_param("ssisi", $nama, $username, $id_role, $status_akun, $id_user);
        }

        if ($stmt->execute()) {
            $_SESSION['success'] = "Pembaruan informasi akun berhasil.";
        } else {
            $_SESSION['error'] = "Gagal melakukan pembaruan informasi akun.";
        }

        header("Location: index.php?page=user");
        exit;
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id_user = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Data akun berhasil dihapus dari sistem.";
        } else {
            $_SESSION['error'] = "Terjadi kegagalan saat menghapus akun.";
        }

        header("Location: index.php?page=user");
        exit;
    }
}
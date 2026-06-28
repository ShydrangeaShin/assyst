<?php

class KeluargaController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function index()
    {
        $page_title = "Data Keluarga";
        $breadcrumbs = ["Pendataan", "Keluarga"];
        
        $search = $_GET['search'] ?? '';
        $role = $_SESSION['user']['role'];
        $id_user_login = $_SESSION['user']['id'];

        // Ambil Data Wilayah untuk Dropdown
        $provinsi = []; $kota = []; $kecamatan = []; $desa = [];
        $qProv = mysqli_query($this->conn, "SELECT * FROM provinsi ORDER BY nama_provinsi ASC");
        while ($r = mysqli_fetch_assoc($qProv)) { $provinsi[] = $r; }
        $qKota = mysqli_query($this->conn, "SELECT id_kota, id_provinsi, nama_kota FROM kota ORDER BY nama_kota ASC");
        while ($r = mysqli_fetch_assoc($qKota)) { $kota[] = $r; }
        $qKec = mysqli_query($this->conn, "SELECT id_kecamatan, id_kota, nama_kecamatan FROM kecamatan ORDER BY nama_kecamatan ASC");
        while ($r = mysqli_fetch_assoc($qKec)) { $kecamatan[] = $r; }
        $qDesa = mysqli_query($this->conn, "SELECT id_desa, id_kecamatan, nama_desa FROM desa ORDER BY nama_desa ASC");
        while ($r = mysqli_fetch_assoc($qDesa)) { $desa[] = $r; }

        // Query Utama Data Keluarga
        $query = "
            SELECT k.*, u.nama as nama_petugas, d.nama_desa, kec.nama_kecamatan
            FROM keluarga k
            JOIN users u ON k.id_petugas = u.id_user
            JOIN desa d ON k.id_desa = d.id_desa
            JOIN kecamatan kec ON k.id_kecamatan = kec.id_kecamatan
        ";
        
        $whereClauses = [];
        
        if ($role == 'Petugas') {
            $whereClauses[] = "k.id_petugas = " . (int)$id_user_login;
        }

        if ($search != '') {
            $safe_search = $this->conn->real_escape_string($search);
            $whereClauses[] = "(k.nik_kk LIKE '%$safe_search%' OR k.nama_kepala_keluarga LIKE '%$safe_search%' OR d.nama_desa LIKE '%$safe_search%')";
        }

        if (count($whereClauses) > 0) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }
        
        $query .= " ORDER BY k.tanggal_input DESC";
        $keluarga = mysqli_query($this->conn, $query);

        // Ambil data list petugas (Khusus Admin saat membuat data)
        $petugas = [];
        if ($role == 'Admin') {
            $petugas = mysqli_query($this->conn, "SELECT id_user, nama FROM users WHERE id_role = 2 AND status_akun = 'Aktif'");
        }

        $content = "views/keluarga/index.php";
        include "views/layouts/app.php";
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $role = $_SESSION['user']['role'];
            $id_petugas = ($role == 'Admin') ? (int)$_POST['id_petugas'] : (int)$_SESSION['user']['id'];
            
            $nik_kk = trim($_POST['nik_kk']);
            $nama_kepala_keluarga = trim($_POST['nama_kepala_keluarga']);
            $nomor_telepon = trim($_POST['nomor_telepon']);
            $alamat = trim($_POST['alamat']);
            
            $id_provinsi = (int)$_POST['id_provinsi'];
            $id_kota = (int)$_POST['id_kota'];
            $id_kecamatan = (int)$_POST['id_kecamatan'];
            $id_desa = (int)$_POST['id_desa'];

            // Validasi NIK Unik
            $stmt_cek = $this->conn->prepare("SELECT id_keluarga FROM keluarga WHERE nik_kk = ?");
            $stmt_cek->bind_param("s", $nik_kk);
            $stmt_cek->execute();
            if ($stmt_cek->get_result()->num_rows > 0) {
                $_SESSION['error'] = "Nomor Induk Kependudukan (NIK/KK) sudah terdaftar dalam sistem.";
                header("Location:?page=keluarga");
                exit;
            }

            $stmt = $this->conn->prepare("INSERT INTO keluarga (id_petugas, nik_kk, nama_kepala_keluarga, alamat, nomor_telepon, id_provinsi, id_kota, id_kecamatan, id_desa) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssiiii", $id_petugas, $nik_kk, $nama_kepala_keluarga, $alamat, $nomor_telepon, $id_provinsi, $id_kota, $id_kecamatan, $id_desa);
            
            if ($stmt->execute()) {
                catatLog($this->conn, "Meregistrasi data keluarga baru dengan NIK: $nik_kk");
                $_SESSION['success'] = "Data keluarga baru berhasil diregistrasi.";
            } else {
                $_SESSION['error'] = "Gagal menyimpan data keluarga.";
            }
            header("Location:?page=keluarga");
            exit;
        }
    }

    public function detail($id)
    {
        $page_title = "Detail Keluarga";
        $breadcrumbs = ["Pendataan", "Keluarga", "Detail"];
        $role = $_SESSION['user']['role'];
        $id_user_login = $_SESSION['user']['id'];

        $query = "
            SELECT k.*, u.nama as nama_petugas, d.nama_desa, kec.nama_kecamatan, ko.nama_kota, p.nama_provinsi
            FROM keluarga k
            JOIN users u ON k.id_petugas = u.id_user
            JOIN desa d ON k.id_desa = d.id_desa
            JOIN kecamatan kec ON k.id_kecamatan = kec.id_kecamatan
            JOIN kota ko ON k.id_kota = ko.id_kota
            JOIN provinsi p ON k.id_provinsi = p.id_provinsi
            WHERE k.id_keluarga = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $keluarga = $stmt->get_result()->fetch_assoc();

        if (!$keluarga || ($role == 'Petugas' && $keluarga['id_petugas'] != $id_user_login)) {
            header("Location:?page=forbidden");
            exit;
        }

        $content = "views/keluarga/detail.php";
        include "views/layouts/app.php";
    }

    public function edit($id)
    {
        $page_title = "Edit Data Keluarga";
        $breadcrumbs = ["Pendataan", "Keluarga", "Edit"];
        $role = $_SESSION['user']['role'];
        $id_user_login = $_SESSION['user']['id'];

        $stmt = $this->conn->prepare("SELECT * FROM keluarga WHERE id_keluarga = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $data = $stmt->get_result()->fetch_assoc();

        if (!$data || ($role == 'Petugas' && $data['id_petugas'] != $id_user_login)) {
            header("Location:?page=forbidden");
            exit;
        }

        $provinsi = []; $kota = []; $kecamatan = []; $desa = []; $petugas = [];
        $qProv = mysqli_query($this->conn, "SELECT * FROM provinsi ORDER BY nama_provinsi ASC");
        while ($r = mysqli_fetch_assoc($qProv)) { $provinsi[] = $r; }
        $qKota = mysqli_query($this->conn, "SELECT id_kota, id_provinsi, nama_kota FROM kota");
        while ($r = mysqli_fetch_assoc($qKota)) { $kota[] = $r; }
        $qKec = mysqli_query($this->conn, "SELECT id_kecamatan, id_kota, nama_kecamatan FROM kecamatan");
        while ($r = mysqli_fetch_assoc($qKec)) { $kecamatan[] = $r; }
        $qDesa = mysqli_query($this->conn, "SELECT id_desa, id_kecamatan, nama_desa FROM desa");
        while ($r = mysqli_fetch_assoc($qDesa)) { $desa[] = $r; }

        if ($role == 'Admin') {
            $petugas = mysqli_query($this->conn, "SELECT id_user, nama FROM users WHERE id_role = 2 AND status_akun = 'Aktif'");
        }

        $content = "views/keluarga/edit.php";
        include "views/layouts/app.php";
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_keluarga = (int)$_POST['id_keluarga'];
            $nik_kk = trim($_POST['nik_kk']);
            $nama_kepala_keluarga = trim($_POST['nama_kepala_keluarga']);
            $nomor_telepon = trim($_POST['nomor_telepon']);
            $alamat = trim($_POST['alamat']);
            
            $id_provinsi = (int)$_POST['id_provinsi'];
            $id_kota = (int)$_POST['id_kota'];
            $id_kecamatan = (int)$_POST['id_kecamatan'];
            $id_desa = (int)$_POST['id_desa'];

            // Cek duplikasi NIK pada record lain
            $stmt_cek = $this->conn->prepare("SELECT id_keluarga FROM keluarga WHERE nik_kk = ? AND id_keluarga != ?");
            $stmt_cek->bind_param("si", $nik_kk, $id_keluarga);
            $stmt_cek->execute();
            if ($stmt_cek->get_result()->num_rows > 0) {
                $_SESSION['error'] = "Pembaruan gagal. NIK/KK tersebut sudah dipakai keluarga lain.";
                header("Location:?page=keluarga-edit&id=" . $id_keluarga);
                exit;
            }

            if ($_SESSION['user']['role'] == 'Admin' && !empty($_POST['id_petugas'])) {
                $id_petugas = (int)$_POST['id_petugas'];
                $stmt = $this->conn->prepare("UPDATE keluarga SET id_petugas=?, nik_kk=?, nama_kepala_keluarga=?, alamat=?, nomor_telepon=?, id_provinsi=?, id_kota=?, id_kecamatan=?, id_desa=? WHERE id_keluarga=?");
                $stmt->bind_param("issssiiiii", $id_petugas, $nik_kk, $nama_kepala_keluarga, $alamat, $nomor_telepon, $id_provinsi, $id_kota, $id_kecamatan, $id_desa, $id_keluarga);
            } else {
                $stmt = $this->conn->prepare("UPDATE keluarga SET nik_kk=?, nama_kepala_keluarga=?, alamat=?, nomor_telepon=?, id_provinsi=?, id_kota=?, id_kecamatan=?, id_desa=? WHERE id_keluarga=?");
                $stmt->bind_param("ssssiiiii", $nik_kk, $nama_kepala_keluarga, $alamat, $nomor_telepon, $id_provinsi, $id_kota, $id_kecamatan, $id_desa, $id_keluarga);
            }

            if ($stmt->execute()) {
                $_SESSION['success'] = "Data keluarga berhasil diperbarui.";
            } else {
                $_SESSION['error'] = "Gagal memperbarui data keluarga.";
            }
            header("Location:?page=keluarga");
            exit;
        }
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM keluarga WHERE id_keluarga = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Data keluarga beserta informasi terkait (kondisi/hasil) berhasil dihapus.";
        } else {
            $_SESSION['error'] = "Terjadi kegagalan saat menghapus data.";
        }
        header("Location:?page=keluarga");
        exit;
    }
}
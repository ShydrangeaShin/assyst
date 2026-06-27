<?php

class LaporanController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function index()
    {
        $page_title = "Laporan Data Bansos";
        $breadcrumbs = ["Laporan", "Rekapitulasi Data"];
        
        $role = $_SESSION['user']['role'];
        $id_user_login = $_SESSION['user']['id'];

        // Tangkap Parameter Filter
        $search = $_GET['search'] ?? '';
        $id_provinsi = $_GET['id_provinsi'] ?? '';
        $id_kota = $_GET['id_kota'] ?? '';
        $id_kecamatan = $_GET['id_kecamatan'] ?? '';
        $id_desa = $_GET['id_desa'] ?? '';
        $status_hasil = $_GET['status_hasil'] ?? '';

        // Master Data Wilayah untuk Cascading Dropdown
        $provinsi = []; $kota = []; $kecamatan = []; $desa = [];
        $qProv = mysqli_query($this->conn, "SELECT * FROM provinsi ORDER BY nama_provinsi ASC");
        while ($r = mysqli_fetch_assoc($qProv)) { $provinsi[] = $r; }
        $qKota = mysqli_query($this->conn, "SELECT id_kota, id_provinsi, nama_kota FROM kota ORDER BY nama_kota ASC");
        while ($r = mysqli_fetch_assoc($qKota)) { $kota[] = $r; }
        $qKec = mysqli_query($this->conn, "SELECT id_kecamatan, id_kota, nama_kecamatan FROM kecamatan ORDER BY nama_kecamatan ASC");
        while ($r = mysqli_fetch_assoc($qKec)) { $kecamatan[] = $r; }
        $qDesa = mysqli_query($this->conn, "SELECT id_desa, id_kecamatan, nama_desa FROM desa ORDER BY nama_desa ASC");
        while ($r = mysqli_fetch_assoc($qDesa)) { $desa[] = $r; }

        // Bangun Kueri Relasional Utama
        $query = "
            SELECT 
                k.id_keluarga, k.nik_kk, k.nama_kepala_keluarga, k.alamat,
                d.nama_desa, kec.nama_kecamatan, ko.nama_kota,
                kon.ekonomi_rendah, kon.penghasilan_tetap, kon.banyak_tanggungan, kon.aset_bernilai,
                h.status_hasil, h.tanggal_hitung,
                u.nama as nama_petugas
            FROM keluarga k
            LEFT JOIN desa d ON k.id_desa = d.id_desa
            LEFT JOIN kecamatan kec ON k.id_kecamatan = kec.id_kecamatan
            LEFT JOIN kota ko ON k.id_kota = ko.id_kota
            LEFT JOIN kondisi_keluarga kon ON k.id_keluarga = kon.id_keluarga
            LEFT JOIN hasil_penalaran h ON k.id_keluarga = h.id_keluarga
            LEFT JOIN users u ON k.id_petugas = u.id_user
            WHERE 1=1
        ";

        $whereClauses = [];

        // Isolasi Data Petugas: Jika bukan admin, hanya lihat wilayah yang didata sendiri
        if ($role == 'Petugas') {
            $whereClauses[] = "k.id_petugas = " . (int)$id_user_login;
        }

        // Terapkan Filter Request
        if ($id_provinsi != '') $whereClauses[] = "k.id_provinsi = " . (int)$id_provinsi;
        if ($id_kota != '') $whereClauses[] = "k.id_kota = " . (int)$id_kota;
        if ($id_kecamatan != '') $whereClauses[] = "k.id_kecamatan = " . (int)$id_kecamatan;
        if ($id_desa != '') $whereClauses[] = "k.id_desa = " . (int)$id_desa;
        
        if ($status_hasil != '') {
            if ($status_hasil == 'BELUM') {
                $whereClauses[] = "h.status_hasil IS NULL";
            } else {
                $safe_status = $this->conn->real_escape_string($status_hasil);
                $whereClauses[] = "h.status_hasil = '$safe_status'";
            }
        }

        if ($search != '') {
            $safe_search = $this->conn->real_escape_string($search);
            $whereClauses[] = "(k.nik_kk LIKE '%$safe_search%' OR k.nama_kepala_keluarga LIKE '%$safe_search%')";
        }

        if (count($whereClauses) > 0) {
            $query .= " AND " . implode(" AND ", $whereClauses);
        }

        $query .= " ORDER BY k.tanggal_input DESC";
        $laporan = mysqli_query($this->conn, $query);

        $content = "views/laporan/index.php";
        include "views/layouts/app.php";
    }
}
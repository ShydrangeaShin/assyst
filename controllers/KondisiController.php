<?php

class KondisiController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function index()
    {
        $page_title = "Data Kondisi Sosial";
        $breadcrumbs = ["Pendataan", "Kondisi Sosial"];
        
        $role = $_SESSION['user']['role'];
        $id_user_login = $_SESSION['user']['id'];

        // Tangkap Parameter Filter
        $search = $_GET['search'] ?? '';
        $id_provinsi = $_GET['id_provinsi'] ?? '';
        $id_kota = $_GET['id_kota'] ?? '';
        $id_kecamatan = $_GET['id_kecamatan'] ?? '';
        $id_desa = $_GET['id_desa'] ?? '';

        // Master Data Wilayah untuk Cascading Dropdown Filter
        $provinsi = []; $kota = []; $kecamatan = []; $desa = [];
        $qProv = mysqli_query($this->conn, "SELECT * FROM provinsi ORDER BY nama_provinsi ASC");
        while ($r = mysqli_fetch_assoc($qProv)) { $provinsi[] = $r; }
        $qKota = mysqli_query($this->conn, "SELECT id_kota, id_provinsi, nama_kota FROM kota ORDER BY nama_kota ASC");
        while ($r = mysqli_fetch_assoc($qKota)) { $kota[] = $r; }
        $qKec = mysqli_query($this->conn, "SELECT id_kecamatan, id_kota, nama_kecamatan FROM kecamatan ORDER BY nama_kecamatan ASC");
        while ($r = mysqli_fetch_assoc($qKec)) { $kecamatan[] = $r; }
        $qDesa = mysqli_query($this->conn, "SELECT id_desa, id_kecamatan, nama_desa FROM desa ORDER BY nama_desa ASC");
        while ($r = mysqli_fetch_assoc($qDesa)) { $desa[] = $r; }

        // Kueri Relasional Keluarga & Kondisi
        $query = "
            SELECT 
                k.id_keluarga, k.nik_kk, k.nama_kepala_keluarga,
                d.nama_desa, kec.nama_kecamatan,
                kon.id_kondisi, kon.ekonomi_rendah
            FROM keluarga k
            LEFT JOIN desa d ON k.id_desa = d.id_desa
            LEFT JOIN kecamatan kec ON k.id_kecamatan = kec.id_kecamatan
            LEFT JOIN kondisi_keluarga kon ON k.id_keluarga = kon.id_keluarga
            WHERE 1=1
        ";

        $whereClauses = [];

        // Filter Role: Petugas hanya melihat wilayah survei mereka
        if ($role == 'Petugas') {
            $whereClauses[] = "k.id_petugas = " . (int)$id_user_login;
        }

        // Terapkan Filter Lokasi & Pencarian
        if ($id_provinsi != '') $whereClauses[] = "k.id_provinsi = " . (int)$id_provinsi;
        if ($id_kota != '') $whereClauses[] = "k.id_kota = " . (int)$id_kota;
        if ($id_kecamatan != '') $whereClauses[] = "k.id_kecamatan = " . (int)$id_kecamatan;
        if ($id_desa != '') $whereClauses[] = "k.id_desa = " . (int)$id_desa;
        
        if ($search != '') {
            $safe_search = $this->conn->real_escape_string($search);
            $whereClauses[] = "(k.nik_kk LIKE '%$safe_search%' OR k.nama_kepala_keluarga LIKE '%$safe_search%')";
        }

        if (count($whereClauses) > 0) {
            $query .= " AND " . implode(" AND ", $whereClauses);
        }

        $query .= " ORDER BY kon.id_kondisi ASC, k.tanggal_input DESC";
        $keluarga = mysqli_query($this->conn, $query);

        $content = "views/kondisi/index.php";
        include "views/layouts/app.php";
    }

    public function edit($id_keluarga)
    {
        $page_title = "Input Kondisi Sosial & Foto";
        $breadcrumbs = ["Pendataan", "Kondisi Sosial", "Input Data"];
        $role = $_SESSION['user']['role'];
        $id_user_login = $_SESSION['user']['id'];

        // Ambil profil dasar keluarga
        $stmt_k = $this->conn->prepare("SELECT id_keluarga, id_petugas, nik_kk, nama_kepala_keluarga FROM keluarga WHERE id_keluarga = ?");
        $stmt_k->bind_param("i", $id_keluarga);
        $stmt_k->execute();
        $profil = $stmt_k->get_result()->fetch_assoc();

        if (!$profil || ($role == 'Petugas' && $profil['id_petugas'] != $id_user_login)) {
            header("Location:?page=forbidden");
            exit;
        }

        // Ambil data kondisi jika sudah ada
        $stmt_c = $this->conn->prepare("SELECT * FROM kondisi_keluarga WHERE id_keluarga = ?");
        $stmt_c->bind_param("i", $id_keluarga);
        $stmt_c->execute();
        $kondisi = $stmt_c->get_result()->fetch_assoc();

        // Ambil data foto bukti jika sudah ada
        $stmt_f = $this->conn->prepare("SELECT * FROM foto_bukti WHERE id_keluarga = ?");
        $stmt_f->bind_param("i", $id_keluarga);
        $stmt_f->execute();
        $foto = $stmt_f->get_result()->fetch_assoc();

        $content = "views/kondisi/edit.php";
        include "views/layouts/app.php";
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_keluarga = (int)$_POST['id_keluarga'];
            
            // 1. Validasi & Proses Simpan Kondisi Sosial
            $ekonomi_rendah = $_POST['ekonomi_rendah'] == 'Ya' ? 'Ya' : 'Tidak';
            $penghasilan_tetap = $_POST['penghasilan_tetap'] == 'Ya' ? 'Ya' : 'Tidak';
            $banyak_tanggungan = $_POST['banyak_tanggungan'] == 'Ya' ? 'Ya' : 'Tidak';
            $aset_bernilai = $_POST['aset_bernilai'] == 'Ya' ? 'Ya' : 'Tidak';

            $stmt_cek = $this->conn->prepare("SELECT id_kondisi FROM kondisi_keluarga WHERE id_keluarga = ?");
            $stmt_cek->bind_param("i", $id_keluarga);
            $stmt_cek->execute();
            if ($stmt_cek->get_result()->num_rows > 0) {
                $stmt = $this->conn->prepare("UPDATE kondisi_keluarga SET ekonomi_rendah=?, penghasilan_tetap=?, banyak_tanggungan=?, aset_bernilai=? WHERE id_keluarga=?");
                $stmt->bind_param("ssssi", $ekonomi_rendah, $penghasilan_tetap, $banyak_tanggungan, $aset_bernilai, $id_keluarga);
            } else {
                $stmt = $this->conn->prepare("INSERT INTO kondisi_keluarga (id_keluarga, ekonomi_rendah, penghasilan_tetap, banyak_tanggungan, aset_bernilai) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("issss", $id_keluarga, $ekonomi_rendah, $penghasilan_tetap, $banyak_tanggungan, $aset_bernilai);
            }
            $stmt->execute();

            // 2. Proses Upload Foto Bukti
            // Mengambil foto lama untuk fallback jika tidak ada upload baru
            $stmt_f_cek = $this->conn->prepare("SELECT * FROM foto_bukti WHERE id_keluarga = ?");
            $stmt_f_cek->bind_param("i", $id_keluarga);
            $stmt_f_cek->execute();
            $foto_lama = $stmt_f_cek->get_result()->fetch_assoc();

            $f_rumah = (!empty($_FILES['foto_rumah']['name'])) ? uploadFile($_FILES['foto_rumah'], 'rumah') : ($foto_lama['foto_rumah'] ?? null);
            $f_ekonomi = (!empty($_FILES['foto_ekonomi']['name'])) ? uploadFile($_FILES['foto_ekonomi'], 'ekonomi') : ($foto_lama['foto_ekonomi'] ?? null);
            $f_keluarga = (!empty($_FILES['foto_keluarga']['name'])) ? uploadFile($_FILES['foto_keluarga'], 'keluarga') : ($foto_lama['foto_keluarga'] ?? null);
            $f_dokumen = (!empty($_FILES['foto_dokumen']['name'])) ? uploadFile($_FILES['foto_dokumen'], 'dokumen') : ($foto_lama['foto_dokumen'] ?? null);

            if ($foto_lama) {
                $stmt_f = $this->conn->prepare("UPDATE foto_bukti SET foto_rumah=?, foto_ekonomi=?, foto_keluarga=?, foto_dokumen=? WHERE id_keluarga=?");
                $stmt_f->bind_param("ssssi", $f_rumah, $f_ekonomi, $f_keluarga, $f_dokumen, $id_keluarga);
            } else {
                $stmt_f = $this->conn->prepare("INSERT INTO foto_bukti (id_keluarga, foto_rumah, foto_ekonomi, foto_keluarga, foto_dokumen) VALUES (?, ?, ?, ?, ?)");
                $stmt_f->bind_param("issss", $id_keluarga, $f_rumah, $f_ekonomi, $f_keluarga, $f_dokumen);
            }
            
            if ($stmt_f->execute()) {
                $_SESSION['success'] = "Data kondisi sosial dan lampiran foto lapangan berhasil disimpan.";
            } else {
                $_SESSION['error'] = "Terjadi kesalahan saat menyimpan data.";
            }
            
            header("Location:?page=kondisi");
            exit;
        }
    }
}
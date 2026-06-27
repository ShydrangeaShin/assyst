<?php

class VerifikasiController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function index()
    {
        $page_title = "Verifikasi Data Survei";
        $breadcrumbs = ["Validasi", "Verifikasi Data"];
        
        $search = $_GET['search'] ?? '';

        // Ambil keluarga yang sudah diisi kondisi sosialnya oleh surveyor
        $query = "
            SELECT 
                k.id_keluarga, k.nik_kk, k.nama_kepala_keluarga, 
                d.nama_desa, 
                v.status_verifikasi, v.tanggal_verifikasi,
                u.nama as nama_petugas
            FROM keluarga k
            JOIN kondisi_keluarga kon ON k.id_keluarga = kon.id_keluarga
            LEFT JOIN verifikasi v ON k.id_keluarga = v.id_keluarga
            LEFT JOIN desa d ON k.id_desa = d.id_desa
            LEFT JOIN users u ON k.id_petugas = u.id_user
            WHERE 1=1
        ";

        if ($search != '') {
            $safe_search = $this->conn->real_escape_string($search);
            $query .= " AND (k.nik_kk LIKE '%$safe_search%' OR k.nama_kepala_keluarga LIKE '%$safe_search%')";
        }

        // Urutkan: Yang belum diverifikasi (Pending / NULL) tampil di atas
        $query .= " ORDER BY IFNULL(v.status_verifikasi, 'Pending') DESC, k.tanggal_input DESC";
        $data = mysqli_query($this->conn, $query);

        $content = "views/verifikasi/index.php";
        include "views/layouts/app.php";
    }

    public function detail($id_keluarga)
    {
        $page_title = "Detail Verifikasi";
        $breadcrumbs = ["Validasi", "Verifikasi Data", "Detail"];

        // Ambil Profil Keluarga dan Kondisinya
        $qKeluarga = $this->conn->prepare("
            SELECT k.*, d.nama_desa, kec.nama_kecamatan, ko.nama_kota, p.nama_provinsi, u.nama as nama_petugas,
                   kon.ekonomi_rendah, kon.penghasilan_tetap, kon.banyak_tanggungan, kon.aset_bernilai
            FROM keluarga k
            LEFT JOIN desa d ON k.id_desa = d.id_desa
            LEFT JOIN kecamatan kec ON k.id_kecamatan = kec.id_kecamatan
            LEFT JOIN kota ko ON k.id_kota = ko.id_kota
            LEFT JOIN provinsi p ON k.id_provinsi = p.id_provinsi
            LEFT JOIN users u ON k.id_petugas = u.id_user
            LEFT JOIN kondisi_keluarga kon ON k.id_keluarga = kon.id_keluarga
            WHERE k.id_keluarga = ?
        ");
        $qKeluarga->bind_param("i", $id_keluarga);
        $qKeluarga->execute();
        $keluarga = $qKeluarga->get_result()->fetch_assoc();

        if (!$keluarga || empty($keluarga['ekonomi_rendah'])) {
            $_SESSION['error'] = "Data kondisi sosial keluarga ini belum dilengkapi oleh petugas.";
            header("Location:?page=verifikasi");
            exit;
        }

        // Ambil Data Verifikasi jika ada
        $qVerif = $this->conn->prepare("SELECT * FROM verifikasi WHERE id_keluarga = ?");
        $qVerif->bind_param("i", $id_keluarga);
        $qVerif->execute();
        $verifikasi = $qVerif->get_result()->fetch_assoc();

        // Ambil Foto Bukti
        $qFoto = $this->conn->prepare("SELECT * FROM foto_bukti WHERE id_keluarga = ?");
        $qFoto->bind_param("i", $id_keluarga);
        $qFoto->execute();
        $foto = $qFoto->get_result()->fetch_assoc();

        $content = "views/verifikasi/detail.php";
        include "views/layouts/app.php";
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_keluarga = (int)$_POST['id_keluarga'];
            $status_verifikasi = $_POST['status_verifikasi'];
            $catatan = trim($_POST['catatan']);
            $id_admin = $_SESSION['user']['id']; // Admin yang memverifikasi

            // 1. Simpan atau Perbarui Status Verifikasi
            $qCheck = $this->conn->prepare("SELECT id_verifikasi FROM verifikasi WHERE id_keluarga = ?");
            $qCheck->bind_param("i", $id_keluarga);
            $qCheck->execute();
            
            if ($qCheck->get_result()->num_rows > 0) {
                $upd = $this->conn->prepare("UPDATE verifikasi SET status_verifikasi=?, catatan=?, id_petugas=?, tanggal_verifikasi=NOW() WHERE id_keluarga=?");
                $upd->bind_param("ssii", $status_verifikasi, $catatan, $id_admin, $id_keluarga);
                $upd->execute();
            } else {
                $ins = $this->conn->prepare("INSERT INTO verifikasi (id_keluarga, id_petugas, catatan, status_verifikasi) VALUES (?, ?, ?, ?)");
                $ins->bind_param("iiss", $id_keluarga, $id_admin, $catatan, $status_verifikasi);
                $ins->execute();
            }

            // 2. Mesin Penalaran Otomatis (Inference Engine)
            if ($status_verifikasi == 'Valid') {
                $this->jalankanPenalaran($id_keluarga);
                $_SESSION['success'] = "Data disetujui (Valid). Sistem otomatis telah menalarkan kelayakan bansos.";
            } else {
                // Jika ditolak, hapus hasil penalaran yang lama agar tidak tampil di laporan
                $del = $this->conn->prepare("DELETE FROM hasil_penalaran WHERE id_keluarga = ?");
                $del->bind_param("i", $id_keluarga);
                $del->execute();
                $_SESSION['success'] = "Data ditandai sebagai Ditolak atau Pending.";
            }

            header("Location:?page=verifikasi");
            exit;
        }
    }

    /**
     * FUNGSI PENALARAN BERBASIS ATURAN (RULE-BASED SYSTEM)
     */
    private function jalankanPenalaran($id_keluarga)
    {
        $q = $this->conn->prepare("SELECT ekonomi_rendah, penghasilan_tetap, banyak_tanggungan, aset_bernilai FROM kondisi_keluarga WHERE id_keluarga = ?");
        $q->bind_param("i", $id_keluarga);
        $q->execute();
        $kondisi = $q->get_result()->fetch_assoc();

        if (!$kondisi) return;

        $status_hasil = 'TIDAK LAYAK';
        $alasan = '';

        // Aturan 1: Aset Bernilai menjadi faktor penggugur utama
        if ($kondisi['aset_bernilai'] == 'Ya') {
            $status_hasil = 'TIDAK LAYAK';
            $alasan = 'Keluarga memiliki aset bernilai tinggi (misal: Mobil, Tanah Besar).';
        } 
        // Aturan 2: Bukan kategori ekonomi rendah
        else if ($kondisi['ekonomi_rendah'] == 'Tidak') {
            $status_hasil = 'TIDAK LAYAK';
            $alasan = 'Perekonomian keluarga tergolong mampu / di atas rata-rata.';
        } 
        // Aturan 3: Evaluasi Gaji & Tanggungan
        else {
            if ($kondisi['penghasilan_tetap'] == 'Tidak') {
                $status_hasil = 'LAYAK';
                $alasan = 'Ekonomi rendah, tidak punya aset berharga, dan tidak memiliki pendapatan tetap.';
            } else {
                if ($kondisi['banyak_tanggungan'] == 'Ya') {
                    $status_hasil = 'LAYAK';
                    $alasan = 'Meskipun berpenghasilan tetap, namun ekonomi rendah dan tanggungan keluarga besar (>3 orang).';
                } else {
                    $status_hasil = 'TIDAK LAYAK';
                    $alasan = 'Memiliki penghasilan tetap dengan jumlah tanggungan yang sedikit.';
                }
            }
        }

        // Insert atau Update Hasil Penalaran
        $qCheck = $this->conn->prepare("SELECT id_hasil FROM hasil_penalaran WHERE id_keluarga = ?");
        $qCheck->bind_param("i", $id_keluarga);
        $qCheck->execute();
        
        if ($qCheck->get_result()->num_rows > 0) {
            $upd = $this->conn->prepare("UPDATE hasil_penalaran SET status_hasil=?, alasan=?, tanggal_hitung=NOW() WHERE id_keluarga=?");
            $upd->bind_param("ssi", $status_hasil, $alasan, $id_keluarga);
            $upd->execute();
        } else {
            $ins = $this->conn->prepare("INSERT INTO hasil_penalaran (id_keluarga, status_hasil, alasan) VALUES (?, ?, ?)");
            $ins->bind_param("iss", $id_keluarga, $status_hasil, $alasan);
            $ins->execute();
        }
    }
}
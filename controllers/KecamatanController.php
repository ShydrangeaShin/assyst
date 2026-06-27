<?php

require_once 'models/Kecamatan.php';
require_once 'models/Kota.php';
require_once 'models/Provinsi.php';

class KecamatanController
{
    private $kecamatan;
    private $kota;
    private $provinsi;

    public function __construct($db)
    {
        $this->kecamatan = new Kecamatan($db);
        $this->kota = new Kota($db);
        $this->provinsi = new Provinsi($db);
    }

    public function index()
    {
        $page_title = "Data Kecamatan";
        $breadcrumbs = ["Master Wilayah", "Kecamatan"];
        $search = $_GET['search'] ?? '';

        $result = $this->kecamatan->getAll($search);
        $kecamatan = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $row['can_delete'] = $this->kecamatan->canDelete($row['id_kecamatan']);
            $kecamatan[] = $row;
        }

        $kota = $this->kota->getAll();
        
        $content = "views/wilayah/kecamatan/index.php";
        include "views/layouts/app.php";
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['nama_kecamatan']) || empty($_POST['id_kota'])) {
                $_SESSION['error'] = "Kota/Kabupaten dan Nama Kecamatan wajib diisi.";
            } else {
                $this->kecamatan->insert($_POST);
                $_SESSION['success'] = "Data kecamatan berhasil ditambahkan.";
            }
            header("Location:?page=kecamatan");
            exit;
        }
    }

    public function detail($id)
    {
        $page_title = "Detail Kecamatan";
        $breadcrumbs = ["Master Wilayah", "Kecamatan", "Detail"];
        $kecamatan = $this->kecamatan->find($id);

        $content = "views/wilayah/kecamatan/detail.php";
        include "views/layouts/app.php";
    }

    public function edit($id)
    {
        $page_title = "Edit Kecamatan";
        $breadcrumbs = ["Master Wilayah", "Kecamatan", "Edit"];
        $kecamatan = $this->kecamatan->find($id);
        
        // Membawa data kota untuk dropdown
        $kota = $this->kota->getAll();

        $content = "views/wilayah/kecamatan/edit.php";
        include "views/layouts/app.php";
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['nama_kecamatan']) || empty($_POST['id_kota'])) {
                $_SESSION['error'] = "Semua form wajib diisi.";
                header("Location:?page=kecamatan-edit&id=" . $_POST['id_kecamatan']);
                exit;
            }

            $this->kecamatan->update($_POST);
            $_SESSION['success'] = "Data kecamatan berhasil diperbarui.";
            header("Location:?page=kecamatan");
            exit;
        }
    }

    public function delete($id)
    {
        if ($this->kecamatan->canDelete($id)) {
            $this->kecamatan->delete($id);
            $_SESSION['success'] = "Data kecamatan berhasil dihapus secara permanen.";
        } else {
            $_SESSION['error'] = "Gagal! Data kecamatan sedang digunakan oleh wilayah desa/kelurahan.";
        }

        header("Location:?page=kecamatan");
        exit;
    }
}
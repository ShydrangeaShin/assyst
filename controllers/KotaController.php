<?php

require_once 'models/Kota.php';
require_once 'models/Provinsi.php';

class KotaController
{
    private $kota;
    private $provinsi;

    public function __construct($db)
    {
        $this->kota = new Kota($db);
        $this->provinsi = new Provinsi($db);
    }

    public function index()
    {
        $page_title = "Data Kota";
        $breadcrumbs = ["Master Wilayah", "Kota"];
        $search = $_GET['search'] ?? '';
        
        $result = $this->kota->getAll($search);
        $kota = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $row['can_delete'] = $this->kota->canDelete($row['id_kota']);
            $kota[] = $row;
        }

        $provinsi = $this->provinsi->getAll();
        $content = "views/wilayah/kota/index.php";
        include "views/layouts/app.php";
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['nama_kota']) || empty($_POST['id_provinsi'])) {
                $_SESSION['error'] = "Provinsi dan Nama Kota wajib diisi.";
            } else {
                $this->kota->insert($_POST);
                $_SESSION['success'] = "Data kota/kabupaten berhasil ditambahkan.";
            }
            header("Location:?page=kota");
            exit;
        }
    }

    public function detail($id)
    {
        $page_title = "Detail Kota";
        $breadcrumbs = ["Master Wilayah", "Kota", "Detail"];
        $kota = $this->kota->find($id);
        
        $content = "views/wilayah/kota/detail.php";
        include "views/layouts/app.php";
    }

    public function edit($id)
    {
        $page_title = "Edit Kota";
        $breadcrumbs = ["Master Wilayah", "Kota", "Edit"];
        $kota = $this->kota->find($id);
        $provinsi = $this->provinsi->getAll();
        
        $content = "views/wilayah/kota/edit.php";
        include "views/layouts/app.php";
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['nama_kota']) || empty($_POST['id_provinsi'])) {
                $_SESSION['error'] = "Semua form wajib diisi.";
                header("Location:?page=kota-edit&id=" . $_POST['id_kota']);
                exit;
            }

            $this->kota->update($_POST);
            $_SESSION['success'] = "Data kota/kabupaten berhasil diperbarui.";
            header("Location:?page=kota");
            exit;
        }
    }

    public function delete($id)
    {
        if ($this->kota->canDelete($id)) {
            $this->kota->delete($id);
            $_SESSION['success'] = "Data kota berhasil dihapus secara permanen.";
        } else {
            $_SESSION['error'] = "Gagal! Data kota sedang digunakan oleh wilayah kecamatan.";
        }
        
        header("Location:?page=kota");
        exit;
    }
}
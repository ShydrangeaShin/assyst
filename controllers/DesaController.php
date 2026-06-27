<?php

require_once 'models/Desa.php';
require_once 'models/Kecamatan.php';

class DesaController
{
    private $desa;
    private $kecamatan;

    public function __construct($db)
    {
        $this->desa = new Desa($db);
        $this->kecamatan = new Kecamatan($db);
    }

    public function index()
    {
        $page_title = "Data Desa / Kelurahan";
        $breadcrumbs = ["Master Wilayah", "Desa"];
        $search = $_GET['search'] ?? '';

        $result = $this->desa->getAll($search);
        $desa = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $row['can_delete'] = $this->desa->canDelete($row['id_desa']);
            $desa[] = $row;
        }

        $kecamatan = $this->kecamatan->getAll();
        
        $content = "views/wilayah/desa/index.php";
        include "views/layouts/app.php";
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['nama_desa']) || empty($_POST['id_kecamatan'])) {
                $_SESSION['error'] = "Kecamatan dan Nama Desa wajib diisi.";
            } else {
                $this->desa->insert($_POST);
                $_SESSION['success'] = "Data desa/kelurahan berhasil ditambahkan.";
            }
            header("Location:?page=desa");
            exit;
        }
    }

    public function detail($id)
    {
        $page_title = "Detail Desa";
        $breadcrumbs = ["Master Wilayah", "Desa", "Detail"];
        $desa = $this->desa->find($id);

        $content = "views/wilayah/desa/detail.php";
        include "views/layouts/app.php";
    }

    public function edit($id)
    {
        $page_title = "Edit Desa";
        $breadcrumbs = ["Master Wilayah", "Desa", "Edit"];
        $desa = $this->desa->find($id);
        
        $kecamatan = $this->kecamatan->getAll();

        $content = "views/wilayah/desa/edit.php";
        include "views/layouts/app.php";
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['nama_desa']) || empty($_POST['id_kecamatan'])) {
                $_SESSION['error'] = "Semua form wajib diisi.";
                header("Location:?page=desa-edit&id=" . $_POST['id_desa']);
                exit;
            }

            $this->desa->update($_POST);
            $_SESSION['success'] = "Data desa/kelurahan berhasil diperbarui.";
            header("Location:?page=desa");
            exit;
        }
    }

    public function delete($id)
    {
        if ($this->desa->canDelete($id)) {
            $this->desa->delete($id);
            $_SESSION['success'] = "Data desa berhasil dihapus secara permanen.";
        } else {
            $_SESSION['error'] = "Gagal! Data desa sedang digunakan oleh data keluarga/penduduk.";
        }

        header("Location:?page=desa");
        exit;
    }
}
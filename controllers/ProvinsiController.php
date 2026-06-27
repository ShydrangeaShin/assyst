<?php

require_once "models/Provinsi.php";

class ProvinsiController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new Provinsi($db);
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
{
    $page_title = "Data Provinsi";

    $breadcrumbs = [
        "Master Wilayah",
        "Provinsi"
    ];

    if (
        isset($_GET['search']) &&
        trim($_GET['search']) != ''
    ) {

        $result = $this->model->search($_GET['search']);

    } else {

        $result = $this->model->getAll();

    }

    $provinsi = [];

    while ($row = $result->fetch_assoc()) {

        $row['can_delete'] =
            !$this->model->isUsed($row['id_provinsi']);

        $provinsi[] = $row;
    }

    $content = "views/wilayah/provinsi/index.php";

    include "views/layouts/app.php";
}

    // /*
    // |--------------------------------------------------------------------------
    // | CREATE
    // |--------------------------------------------------------------------------
    // */

    // public function create()
    // {
    //     $page_title = "Tambah Provinsi";

    //     $breadcrumbs = [
    //         "Master Wilayah",
    //         "Provinsi",
    //         "Tambah"
    //     ];

    //     $content = "views/wilayah/provinsi/create.php";

    //     include "views/layouts/app.php";
    // }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nama = trim($_POST['nama_provinsi']);

            if ($nama == '') {

                $_SESSION['error'] = "Nama provinsi wajib diisi.";

                header("Location:?page=provinsi-create");
                exit;
            }

            $this->model->insert($nama);
            $_SESSION['success'] = "Data berhasil ditambahkan.";

            header("Location:?page=provinsi");
            exit;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Detail
    |--------------------------------------------------------------------------
    */

    public function detail()
    {
        $id = $_GET['id'] ?? 0;

        $provinsi = $this->model->find($id);

        if (!$provinsi) {

            header("Location:?page=provinsi");
            exit;
        }

        $page_title = "Detail Provinsi";

        $breadcrumbs = [
            "Master Wilayah",
            "Provinsi",
            "Detail"
        ];

        $content = "views/wilayah/provinsi/detail.php";

        include "views/layouts/app.php";
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit()
    {

        $id = $_GET['id'];

        $data = $this->model->getById($id);

        $page_title = "Edit Provinsi";

        $breadcrumbs = [
            "Master Wilayah",
            "Provinsi",
            "Edit"
        ];

        $content = "views/wilayah/provinsi/edit.php";

        include "views/layouts/app.php";

    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nama = trim($_POST['nama_provinsi']);

            if ($nama == '') {

                $_SESSION['error'] = "Nama provinsi wajib diisi.";

                header("Location:?page=provinsi-edit&id=" . $_POST['id_provinsi']);
                exit;
            }

            $this->model->update($_POST['id_provinsi'], $nama);
            $_SESSION['success'] = "Data berhasil diperbarui.";

            header("Location:?page=provinsi");
            exit;
        }
    }

    

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete()
    {

        if (isset($_GET['id'])) {

            $this->model->delete($_GET['id']);

        }

        header("Location:?page=provinsi");

        exit;

    }
}
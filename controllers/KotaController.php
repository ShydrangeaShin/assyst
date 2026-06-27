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

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $page_title = "Data Kota";

        $breadcrumbs = [
            "Master Wilayah",
            "Kota"
        ];

        $search = $_GET['search'] ?? '';

        $result = $this->kota->getAll($search);

        $kota = [];

        while ($row = mysqli_fetch_assoc($result)) {

            $row['can_delete'] =
                $this->kota->canDelete(
                    $row['id_kota']
                );

            $kota[] = $row;
        }

        $provinsi = $this->provinsi->getAll();

        $content =
            "views/wilayah/kota/index.php";

        include
            "views/layouts/app.php";
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store()
    {
        $this->kota->insert($_POST);

        header("Location:?page=kota");

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Detail
    |--------------------------------------------------------------------------
    */

    public function detail($id)
    {
        $page_title = "Detail Kota";

        $breadcrumbs = [
            "Master Wilayah",
            "Kota",
            "Detail"
        ];

        $kota =
            $this->kota->find($id);

        $content =
            "views/wilayah/kota/detail.php";

        include
            "views/layouts/app.php";
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $page_title = "Edit Kota";

        $breadcrumbs = [
            "Master Wilayah",
            "Kota",
            "Edit"
        ];

        $kota =
            $this->kota->find($id);

        $provinsi =
            $this->provinsi->getAll();

        $content =
            "views/wilayah/kota/edit.php";

        include
            "views/layouts/app.php";
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update()
    {
        $this->kota->update($_POST);

        header("Location:?page=kota");

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        if ($this->kota->canDelete($id)) {

            $this->kota->delete($id);
        }

        header("Location:?page=kota");

        exit;
    }
}
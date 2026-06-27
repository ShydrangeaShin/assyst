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

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $page_title = "Data Kecamatan";

        $breadcrumbs = [
            "Master Wilayah",
            "Kecamatan"
        ];

        $search = $_GET['search'] ?? '';

        $result = $this->kecamatan->getAll($search);

        $kecamatan = [];

        while ($row = mysqli_fetch_assoc($result)) {

            $row['can_delete'] =
                $this->kecamatan->canDelete(
                    $row['id_kecamatan']
                );

            $kecamatan[] = $row;
        }

        $kota = $this->kota->getAll();
        $provinsi = $this->provinsi->getAll();

        $content =
            "views/wilayah/kecamatan/index.php";

        include
            "views/layouts/app.php";
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $page_title = "Tambah Kecamatan";

        $breadcrumbs = [
            "Master Wilayah",
            "Kecamatan",
            "Tambah"
        ];

        $kota = $this->kota->getAll();
        $provinsi = $this->provinsi->getAll();

        $content =
            "views/wilayah/kecamatan/create.php";

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
        $this->kecamatan->insert($_POST);

        header("Location:?page=kecamatan");

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Detail
    |--------------------------------------------------------------------------
    */

    public function detail($id)
    {
        $page_title = "Detail Kecamatan";

        $breadcrumbs = [
            "Master Wilayah",
            "Kecamatan",
            "Detail"
        ];

        $kecamatan =
            $this->kecamatan->find($id);

        $content =
            "views/wilayah/kecamatan/detail.php";

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
        $page_title = "Edit Kecamatan";

        $breadcrumbs = [
            "Master Wilayah",
            "Kecamatan",
            "Edit"
        ];

        $kecamatan =
            $this->kecamatan->find($id);

        $kota =
            $this->kota->getAll();

        $provinsi =
            $this->provinsi->getAll();

        $content =
            "views/wilayah/kecamatan/edit.php";

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
        $this->kecamatan->update($_POST);

        header("Location:?page=kecamatan");

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        if ($this->kecamatan->canDelete($id)) {

            $this->kecamatan->delete($id);
        }

        header("Location:?page=kecamatan");

        exit;
    }
}

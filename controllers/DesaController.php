<?php

require_once 'models/Desa.php';
require_once 'models/Kecamatan.php';
require_once 'models/Kota.php';
require_once 'models/Provinsi.php';

class DesaController
{
    private $desa;
    private $kecamatan;
    private $kota;
    private $provinsi;

    public function __construct($db)
    {
        $this->desa = new Desa($db);
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
        $page_title = "Data Desa / Kelurahan";

        $breadcrumbs = [
            "Master Wilayah",
            "Desa / Kelurahan"
        ];

        $search = $_GET['search'] ?? '';

        $result = $this->desa->getAll($search);

        $desa = [];

        while ($row = mysqli_fetch_assoc($result)) {

            $row['can_delete'] =
                $this->desa->canDelete(
                    $row['id_desa']
                );

            $desa[] = $row;
        }

        $provinsi = $this->provinsi->getAll();
        $kota = $this->kota->getAll();
        $kecamatan = $this->kecamatan->getAll();

        $content =
            "views/wilayah/desa/index.php";

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
        $page_title = "Tambah Desa / Kelurahan";

        $breadcrumbs = [
            "Master Wilayah",
            "Desa / Kelurahan",
            "Tambah"
        ];

        $provinsi = $this->provinsi->getAll();
        $kota = $this->kota->getAll();
        $kecamatan = $this->kecamatan->getAll();

        $content =
            "views/wilayah/desa/create.php";

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
        $this->desa->insert($_POST);

        header("Location:?page=desa");

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Detail
    |--------------------------------------------------------------------------
    */

    public function detail($id)
    {
        $page_title = "Detail Desa / Kelurahan";

        $breadcrumbs = [
            "Master Wilayah",
            "Desa / Kelurahan",
            "Detail"
        ];

        $desa =
            $this->desa->find($id);

        $content =
            "views/wilayah/desa/detail.php";

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
        $page_title = "Edit Desa / Kelurahan";

        $breadcrumbs = [
            "Master Wilayah",
            "Desa / Kelurahan",
            "Edit"
        ];

        $desa =
            $this->desa->find($id);

        $provinsi = $this->provinsi->getAll();
        $kota = $this->kota->getAll();
        $kecamatan = $this->kecamatan->getAll();

        $content =
            "views/wilayah/desa/edit.php";

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
        $this->desa->update($_POST);

        header("Location:?page=desa");

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        if ($this->desa->canDelete($id)) {

            $this->desa->delete($id);
        }

        header("Location:?page=desa");

        exit;
    }
}

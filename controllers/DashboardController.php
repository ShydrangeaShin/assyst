<?php

class DashboardController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Count
    |--------------------------------------------------------------------------
    */

    private function getCount($sql)
    {
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            return 0;
        }

        $row = mysqli_fetch_row($result);

        return (int)$row[0];
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard Admin
    |--------------------------------------------------------------------------
    */

    public function admin()
    {
        $page_title = "Dashboard Admin";

        $breadcrumbs = ["Dashboard"];

        $totalProvinsi  = $this->getCount("SELECT COUNT(id_provinsi) FROM provinsi");
        $totalKota      = $this->getCount("SELECT COUNT(id_kota) FROM kota");
        $totalKecamatan = $this->getCount("SELECT COUNT(id_kecamatan) FROM kecamatan");
        $totalDesa      = $this->getCount("SELECT COUNT(id_desa) FROM desa");

        $data = [

            "totalWilayah" =>
                $totalProvinsi +
                $totalKota +
                $totalKecamatan +
                $totalDesa,

            "totalPetugas" =>
                $this->getCount("
                    SELECT COUNT(id_user)
                    FROM users
                    WHERE id_role = 2
                "),

            "totalKeluarga" =>
                $this->getCount("
                    SELECT COUNT(id_keluarga)
                    FROM keluarga
                "),

            "totalLayak" =>
                $this->getCount("
                    SELECT COUNT(id_hasil)
                    FROM hasil_penalaran
                    WHERE status_hasil='LAYAK'
                "),

            "totalTidakLayak" =>
                $this->getCount("
                    SELECT COUNT(id_hasil)
                    FROM hasil_penalaran
                    WHERE status_hasil='TIDAK LAYAK'
                "),

            "totalVerifikasi" =>
                $this->getCount("
                    SELECT COUNT(id_hasil)
                    FROM hasil_penalaran
                    WHERE status_hasil='PERLU VERIFIKASI'
                ")

        ];

        extract($data);

        $content = "views/dashboard/admin.php";

        include "views/layouts/app.php";
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard Petugas
    |--------------------------------------------------------------------------
    */

    public function petugas()
    {
        $page_title = "Dashboard Petugas";

        $breadcrumbs = ["Dashboard"];

        $content = "views/dashboard/petugas.php";

        include "views/layouts/app.php";
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard Publik
    |--------------------------------------------------------------------------
    */

    public function publik()
    {

        /*
        |--------------------------------------------------------------------------
        | Dropdown Provinsi
        |--------------------------------------------------------------------------
        */

        $provinsi = mysqli_query(
            $this->conn,
            "SELECT * FROM provinsi ORDER BY nama_provinsi ASC"
        );

        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        $id_provinsi  = $_GET['id_provinsi'] ?? '';
        $id_kota      = $_GET['id_kota'] ?? '';
        $id_kecamatan = $_GET['id_kecamatan'] ?? '';
        $id_desa      = $_GET['id_desa'] ?? '';

        $where = "";

        if ($id_desa != "") {

            $where = " WHERE k.id_desa = " . (int)$id_desa;

        } elseif ($id_kecamatan != "") {

            $where = " WHERE k.id_kecamatan = " . (int)$id_kecamatan;

        } elseif ($id_kota != "") {

            $where = " WHERE k.id_kota = " . (int)$id_kota;

        } elseif ($id_provinsi != "") {

            $where = " WHERE k.id_provinsi = " . (int)$id_provinsi;

        }

        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $totalKeluarga = $this->getCount("
            SELECT COUNT(k.id_keluarga)
            FROM keluarga k
            $where
        ");

        $totalLayak = $this->getCount("
            SELECT COUNT(h.id_hasil)

            FROM hasil_penalaran h

            JOIN keluarga k
            ON h.id_keluarga = k.id_keluarga

            $where

            " . ($where == "" ? "WHERE" : "AND") . "

            h.status_hasil='LAYAK'
        ");

        $totalTidakLayak = $this->getCount("
            SELECT COUNT(h.id_hasil)

            FROM hasil_penalaran h

            JOIN keluarga k
            ON h.id_keluarga = k.id_keluarga

            $where

            " . ($where == "" ? "WHERE" : "AND") . "

            h.status_hasil='TIDAK LAYAK'
        ");

        $totalVerifikasi = $this->getCount("
            SELECT COUNT(h.id_hasil)

            FROM hasil_penalaran h

            JOIN keluarga k
            ON h.id_keluarga = k.id_keluarga

            $where

            " . ($where == "" ? "WHERE" : "AND") . "

            h.status_hasil='PERLU VERIFIKASI'
        ");

        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        $content = "views/dashboard/publik.php";

        include "views/layouts/guest.php";
    }
}
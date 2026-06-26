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
    | Dashboard Admin
    |--------------------------------------------------------------------------
    */

    public function admin()
    {
        $page_title = 'Dashboard Admin';

        $breadcrumbs = [
            'Dashboard'
        ];

        // Sementara masih dummy.
        // Nantinya diganti query database.

        $data = [
            'totalWilayah'      => 125,
            'totalPetugas'      => 25,
            'totalKeluarga'     => 500,
            'totalLayak'        => 450,
            'totalTidakLayak'   => 30,
            'totalVerifikasi'   => 20
        ];

        extract($data);

        $content = 'views/dashboard/admin.php';

        include 'views/layouts/app.php';
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard Petugas
    |--------------------------------------------------------------------------
    */

    public function petugas()
    {
        $page_title = 'Dashboard Petugas';

        $breadcrumbs = [
            'Dashboard'
        ];

        $data = [
            'totalTugas'      => 15,
            'totalSelesai'    => 10,
            'totalPending'    => 5,
            'totalPendataan'  => 50
        ];

        extract($data);

        $content = 'views/dashboard/petugas.php';

        include 'views/layouts/app.php';
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard Publik
    |--------------------------------------------------------------------------
    */

    public function publik()
    {
        $data = [
            'totalKeluarga'   => 500,
            'totalLayak'      => 350,
            'totalTidakLayak' => 100,
            'totalVerifikasi' => 50
        ];

        extract($data);

        $content = 'views/dashboard/publik.php';

        include 'views/layouts/guest.php';
    }
}
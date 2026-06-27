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

    private function getRow($sql)
    {
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            return [];
        }

        return mysqli_fetch_assoc($result);
    }

    private function buildWhereClause()
    {
        $where = [];

        if (!empty($_GET['id_provinsi'])) {
            $where[] = "k.id_provinsi=" . (int)$_GET['id_provinsi'];
        }

        if (!empty($_GET['id_kota'])) {
            $where[] = "k.id_kota=" . (int)$_GET['id_kota'];
        }

        if (!empty($_GET['id_kecamatan'])) {
            $where[] = "k.id_kecamatan=" . (int)$_GET['id_kecamatan'];
        }

        if (!empty($_GET['id_desa'])) {
            $where[] = "k.id_desa=" . (int)$_GET['id_desa'];
        }

        if(count($where)==0){
            return "";
        }

        return " WHERE ".implode(" AND ",$where);
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

        // 1. Data Referensi Dropdown Wilayah
        $provinsiResult = mysqli_query($this->conn, "SELECT * FROM provinsi ORDER BY nama_provinsi ASC");
        $provinsi = [];
        while ($row = mysqli_fetch_assoc($provinsiResult)) { $provinsi[] = $row; }

        $kotaResult = mysqli_query($this->conn, "SELECT id_kota, id_provinsi, nama_kota FROM kota ORDER BY nama_kota ASC");
        $kota = [];
        while ($row = mysqli_fetch_assoc($kotaResult)) { $kota[] = $row; }

        $kecamatanResult = mysqli_query($this->conn, "SELECT id_kecamatan, id_kota, nama_kecamatan FROM kecamatan ORDER BY nama_kecamatan ASC");
        $kecamatan = [];
        while ($row = mysqli_fetch_assoc($kecamatanResult)) { $kecamatan[] = $row; }

        $desaResult = mysqli_query($this->conn, "SELECT id_desa, id_kecamatan, nama_desa FROM desa ORDER BY nama_desa ASC");
        $desa = [];
        while ($row = mysqli_fetch_assoc($desaResult)) { $desa[] = $row; }

        // 2. Pemrosesan Parameter Filter (Request GET)
        $id_provinsi  = $_GET['id_provinsi'] ?? '';
        $id_kota      = $_GET['id_kota'] ?? '';
        $id_kecamatan = $_GET['id_kecamatan'] ?? '';
        $id_desa      = $_GET['id_desa'] ?? '';

        $where = [];
        if ($id_provinsi != '') $where[] = "k.id_provinsi=" . (int)$id_provinsi;
        if ($id_kota != '') $where[] = "k.id_kota=" . (int)$id_kota;
        if ($id_kecamatan != '') $where[] = "k.id_kecamatan=" . (int)$id_kecamatan;
        if ($id_desa != '') $where[] = "k.id_desa=" . (int)$id_desa;

        $whereSQL = "";
        if (count($where) > 0) {
            $whereSQL = " WHERE " . implode(" AND ", $where);
        }

        // 3. Statistik Global (Tetap statis/tidak terpengaruh filter)
        $totalProvinsi  = $this->getCount("SELECT COUNT(id_provinsi) FROM provinsi");
        $totalKota      = $this->getCount("SELECT COUNT(id_kota) FROM kota");
        $totalKecamatan = $this->getCount("SELECT COUNT(id_kecamatan) FROM kecamatan");
        $totalDesa      = $this->getCount("SELECT COUNT(id_desa) FROM desa");
        $totalWilayah   = $totalProvinsi + $totalKota + $totalKecamatan + $totalDesa;

        $totalPetugas = $this->getCount("SELECT COUNT(id_user) FROM users WHERE id_role = 2");

        // 4. Statistik Analitik Terfilter
        $totalKeluarga = $this->getCount("
            SELECT COUNT(k.id_keluarga)
            FROM keluarga k
            $whereSQL
        ");

        $sqlHasil = "
            SELECT 
                SUM(h.status_hasil='LAYAK') as layak, 
                SUM(h.status_hasil='TIDAK LAYAK') as tidak_layak,
                SUM(h.status_hasil='PERLU VERIFIKASI') as verifikasi
            FROM hasil_penalaran h
            JOIN keluarga k ON h.id_keluarga = k.id_keluarga
            $whereSQL
        ";
        
        $hasil = $this->getRow($sqlHasil);
        
        $totalLayak      = (int)($hasil['layak'] ?? 0);
        $totalTidakLayak = (int)($hasil['tidak_layak'] ?? 0);
        $totalVerifikasi = (int)($hasil['verifikasi'] ?? 0);

        // 5. Query Log Aktivitas Terakhir (5 Data Teratas)
        $logTerbaru = mysqli_query($this->conn, "
            SELECT 
                k.id_keluarga,
                d.nama_desa,
                h.status_hasil
            FROM keluarga k
            LEFT JOIN hasil_penalaran h ON k.id_keluarga = h.id_keluarga
            JOIN desa d ON k.id_desa = d.id_desa
            $whereSQL
            ORDER BY k.id_keluarga DESC
            LIMIT 5
        ");

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
        $page_title = "Dashboard Publik";

        /*
        |--------------------------------------------------------------------------
        | Dropdown Provinsi
        |--------------------------------------------------------------------------
        */

        $provinsiResult = mysqli_query(
            $this->conn,
            "SELECT * FROM provinsi ORDER BY nama_provinsi ASC"
        );

        $provinsi = [];

        while ($row = mysqli_fetch_assoc($provinsiResult)) {
            $provinsi[] = $row;
        }

        /*
        |--------------------------------------------------------------------------
        | Dropdown Kota
        |--------------------------------------------------------------------------
        */

        $kotaResult = mysqli_query(
            $this->conn,
            "SELECT id_kota, id_provinsi, nama_kota FROM kota ORDER BY nama_kota ASC"
        );

        $kota = [];

        while ($row = mysqli_fetch_assoc($kotaResult)) {
            $kota[] = $row;
        }

        /*
        |--------------------------------------------------------------------------
        | Dropdown Kecamatan
        |--------------------------------------------------------------------------
        */

        $kecamatanResult = mysqli_query(
            $this->conn,
            "
            SELECT
                id_kecamatan,
                id_kota,
                nama_kecamatan
            FROM kecamatan
            ORDER BY nama_kecamatan ASC
            "
        );

        $kecamatan = [];

        while ($row = mysqli_fetch_assoc($kecamatanResult)) {
            $kecamatan[] = $row;
        }

        /*
        |--------------------------------------------------------------------------
        | Dropdown Desa / Kelurahan
        |--------------------------------------------------------------------------
        */

        $desaResult = mysqli_query(
            $this->conn,
            "
            SELECT
                id_desa,
                id_kecamatan,
                nama_desa
            FROM desa
            ORDER BY nama_desa ASC
            "
        );

        $desa = [];

        while ($row = mysqli_fetch_assoc($desaResult)) {
            $desa[] = $row;
        }


        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        $id_provinsi  = $_GET['id_provinsi'] ?? '';
        $id_kota      = $_GET['id_kota'] ?? '';
        $id_kecamatan = $_GET['id_kecamatan'] ?? '';
        $id_desa      = $_GET['id_desa'] ?? '';

        $where = [];

        if ($id_provinsi != '') {
            $where[] = "k.id_provinsi=".(int)$id_provinsi;
        }

        if ($id_kota != '') {
            $where[] = "k.id_kota=".(int)$id_kota;
        }

        if ($id_kecamatan != '') {
            $where[] = "k.id_kecamatan=".(int)$id_kecamatan;
        }

        if ($id_desa != '') {
            $where[] = "k.id_desa=".(int)$id_desa;
        }

        $whereSQL = "";

        if(count($where)>0){
            $whereSQL = " WHERE ".implode(" AND ",$where);
        }

        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $totalKeluarga = $this->getCount("
            SELECT COUNT(k.id_keluarga)
            FROM keluarga k
            $whereSQL
        ");

        $sql = "

        SELECT SUM(h.status_hasil='LAYAK') layak, SUM(h.status_hasil='TIDAK LAYAK') tidak_layak,
        SUM(h.status_hasil='PERLU VERIFIKASI') verifikasi
        FROM hasil_penalaran h
        JOIN keluarga k
        ON h.id_keluarga=k.id_keluarga
        $whereSQL
        ";

    $hasil = $this->getRow($sql);

    $totalLayak = (int)($hasil['layak'] ?? 0);
        $totalTidakLayak = (int)($hasil['tidak_layak'] ?? 0);
        $totalVerifikasi = (int)($hasil['verifikasi'] ?? 0);

        // Bagian kode yang di-comment telah dihapus untuk menjaga kebersihan kode.

        $namaProvinsi = '';
        $namaKota = '';
        $namaKecamatan = '';
        $namaDesa = '';

        if($id_provinsi){

            $row = $this->getRow("
            SELECT nama_provinsi
            FROM provinsi
            WHERE id_provinsi=$id_provinsi
            ");

            $namaProvinsi=$row['nama_provinsi'];
        }

        if($id_kota){

            $row = $this->getRow("
            SELECT nama_kota
            FROM kota
            WHERE id_kota=$id_kota
            ");

            $namaKota=$row['nama_kota'];
        }

        if($id_kecamatan){

            $row = $this->getRow("
            SELECT nama_kecamatan
            FROM kecamatan
            WHERE id_kecamatan=$id_kecamatan
            ");

            $namaKecamatan=$row['nama_kecamatan'];
        }

        if($id_desa){

            $row = $this->getRow("
            SELECT nama_desa
            FROM desa
            WHERE id_desa=$id_desa
            ");

            $namaDesa=$row['nama_desa'];
        }

        $totalKeputusan =
            $totalLayak +
            $totalTidakLayak +
            $totalVerifikasi;

        $persenLayak =
            $totalKeputusan > 0
            ? round(($totalLayak / $totalKeputusan) * 100, 1)
            : 0;

        $persenTidakLayak =
            $totalKeputusan > 0
            ? round(($totalTidakLayak / $totalKeputusan) * 100, 1)
            : 0;

        $persenVerifikasi =
            $totalKeputusan > 0
            ? round(($totalVerifikasi / $totalKeputusan) * 100, 1)
            : 0;

        $whereRanking = "h.status_hasil='LAYAK'";
        if (count($where) > 0) {
            $whereRanking .= " AND " . implode(" AND ", $where);
        }

        // 1. Terapkan Filter pada Query Ranking secara aman
        $filterWilayah = '';
        if (!empty($whereSQL)) {
            // Mengubah awalan "WHERE " dari $whereSQL menjadi " AND " 
            // agar dapat digabung dengan kondisi h.status_hasil = 'LAYAK'
            $filterWilayah = str_ireplace('WHERE ', ' AND ', $whereSQL);
        }

        $ranking = mysqli_query($this->conn, "
            SELECT 
                kc.nama_kecamatan, 
                COUNT(*) as jumlah
            FROM hasil_penalaran h
            JOIN keluarga k ON h.id_keluarga = k.id_keluarga
            JOIN kecamatan kc ON kc.id_kecamatan = k.id_kecamatan
            WHERE h.status_hasil = 'LAYAK' $filterWilayah
            GROUP BY kc.id_kecamatan
            ORDER BY jumlah DESC
            LIMIT 5
        ");

        // 2. Terapkan Filter pada Query Statistik Wilayah
        $statistikWilayah = mysqli_query($this->conn, "
            SELECT 
                d.nama_desa, 
                COUNT(k.id_keluarga) as total
            FROM keluarga k
            JOIN desa d ON d.id_desa = k.id_desa
            $whereSQL
            GROUP BY d.id_desa
            ORDER BY total DESC
            LIMIT 10
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

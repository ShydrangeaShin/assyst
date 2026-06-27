<?php

class Desa
{
    private $conn;
    private $table = "desa";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /*
    |--------------------------------------------------------------------------
    | Get All
    |--------------------------------------------------------------------------
    */

    public function getAll($search = '')
    {
        $sql = "
            SELECT
                d.*,
                kc.nama_kecamatan,
                k.id_kota,
                k.nama_kota,
                p.id_provinsi,
                p.nama_provinsi,
                (
                    SELECT COUNT(*)
                    FROM keluarga kg
                    WHERE kg.id_desa = d.id_desa
                ) AS total_keluarga
            FROM {$this->table} d
            INNER JOIN kecamatan kc
                ON kc.id_kecamatan = d.id_kecamatan
            INNER JOIN kota k
                ON k.id_kota = kc.id_kota
            INNER JOIN provinsi p
                ON p.id_provinsi = k.id_provinsi
        ";

        if ($search != '') {

            $search = mysqli_real_escape_string($this->conn, $search);

            $sql .= "
                WHERE
                    d.nama_desa LIKE '%$search%'
                    OR
                    d.jenis LIKE '%$search%'
                    OR
                    kc.nama_kecamatan LIKE '%$search%'
                    OR
                    k.nama_kota LIKE '%$search%'
                    OR
                    p.nama_provinsi LIKE '%$search%'
            ";
        }

        $sql .= "
            ORDER BY
                p.nama_provinsi,
                k.nama_kota,
                kc.nama_kecamatan,
                d.jenis,
                d.nama_desa ASC
        ";

        return mysqli_query($this->conn, $sql);
    }

    /*
    |--------------------------------------------------------------------------
    | Get By ID
    |--------------------------------------------------------------------------
    */

    public function find($id)
    {
        $id = (int)$id;

        $query = mysqli_query(
            $this->conn,
            "
            SELECT
                d.*,
                kc.nama_kecamatan,
                k.id_kota,
                k.nama_kota,
                p.id_provinsi,
                p.nama_provinsi,
                (
                    SELECT COUNT(*)
                    FROM keluarga kg
                    WHERE kg.id_desa = d.id_desa
                ) AS total_keluarga
            FROM {$this->table} d
            INNER JOIN kecamatan kc
                ON kc.id_kecamatan = d.id_kecamatan
            INNER JOIN kota k
                ON k.id_kota = kc.id_kota
            INNER JOIN provinsi p
                ON p.id_provinsi = k.id_provinsi
            WHERE d.id_desa = '$id'
            "
        );

        return mysqli_fetch_assoc($query);
    }

    /*
    |--------------------------------------------------------------------------
    | Insert
    |--------------------------------------------------------------------------
    */

    public function insert($data)
    {
        $kecamatan = (int)($data['id_kecamatan'] ?? $data['kecamatan_id'] ?? 0);

        $jenis = mysqli_real_escape_string(
            $this->conn,
            $this->normalizeJenis($data['jenis'] ?? 'Desa')
        );

        $nama = mysqli_real_escape_string(
            $this->conn,
            trim($data['nama_desa'])
        );

        return mysqli_query(
            $this->conn,
            "
            INSERT INTO {$this->table}
            (
                id_kecamatan,
                jenis,
                nama_desa
            )
            VALUES
            (
                '$kecamatan',
                '$jenis',
                '$nama'
            )
            "
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update($data)
    {
        $id = (int)($data['id_desa'] ?? $data['id'] ?? 0);

        $kecamatan = (int)($data['id_kecamatan'] ?? $data['kecamatan_id'] ?? 0);

        $jenis = mysqli_real_escape_string(
            $this->conn,
            $this->normalizeJenis($data['jenis'] ?? 'Desa')
        );

        $nama = mysqli_real_escape_string(
            $this->conn,
            trim($data['nama_desa'])
        );

        return mysqli_query(
            $this->conn,
            "
            UPDATE {$this->table}
            SET
                id_kecamatan='$kecamatan',
                jenis='$jenis',
                nama_desa='$nama'
            WHERE
                id_desa='$id'
            "
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        $id = (int)$id;

        return mysqli_query(
            $this->conn,
            "
            DELETE FROM {$this->table}
            WHERE id_desa='$id'
            "
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Check Relation
    |--------------------------------------------------------------------------
    */

    public function canDelete($id)
    {
        $id = (int)$id;

        $sql = "
            SELECT COUNT(*) total
            FROM keluarga
            WHERE id_desa='$id'
        ";

        $row = mysqli_fetch_assoc(
            mysqli_query($this->conn, $sql)
        );

        return $row['total'] == 0;
    }

    private function normalizeJenis($jenis)
    {
        return $jenis === 'Kelurahan'
            ? 'Kelurahan'
            : 'Desa';
    }
}

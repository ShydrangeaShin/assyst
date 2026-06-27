<?php

class Kecamatan
{
    private $conn;
    private $table = "kecamatan";

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
                kc.*,
                k.nama_kota,
                p.nama_provinsi,
                (
                    SELECT COUNT(*)
                    FROM desa d
                    WHERE d.id_kecamatan = kc.id_kecamatan
                ) AS total_desa
            FROM {$this->table} kc
            INNER JOIN kota k
                ON k.id_kota = kc.id_kota
            INNER JOIN provinsi p
                ON p.id_provinsi = k.id_provinsi
        ";

        if ($search != '') {

            $search = mysqli_real_escape_string($this->conn, $search);

            $sql .= "
                WHERE
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
                kc.nama_kecamatan ASC
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
                kc.*,
                k.nama_kota,
                k.id_provinsi,
                p.nama_provinsi,
                (
                    SELECT COUNT(*)
                    FROM desa d
                    WHERE d.id_kecamatan = kc.id_kecamatan
                ) AS total_desa
            FROM {$this->table} kc
            INNER JOIN kota k
                ON k.id_kota = kc.id_kota
            INNER JOIN provinsi p
                ON p.id_provinsi = k.id_provinsi
            WHERE kc.id_kecamatan = '$id'
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
        $kota = (int)($data['id_kota'] ?? $data['kota_id'] ?? 0);

        $nama = mysqli_real_escape_string(
            $this->conn,
            trim($data['nama_kecamatan'])
        );

        return mysqli_query(
            $this->conn,
            "
            INSERT INTO {$this->table}
            (
                id_kota,
                nama_kecamatan
            )
            VALUES
            (
                '$kota',
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
        $id = (int)($data['id_kecamatan'] ?? $data['id'] ?? 0);

        $kota = (int)($data['id_kota'] ?? $data['kota_id'] ?? 0);

        $nama = mysqli_real_escape_string(
            $this->conn,
            trim($data['nama_kecamatan'])
        );

        return mysqli_query(
            $this->conn,
            "
            UPDATE {$this->table}
            SET
                id_kota='$kota',
                nama_kecamatan='$nama'
            WHERE
                id_kecamatan='$id'
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
            WHERE id_kecamatan='$id'
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
            FROM desa
            WHERE id_kecamatan='$id'
        ";

        $row = mysqli_fetch_assoc(
            mysqli_query($this->conn, $sql)
        );

        return $row['total'] == 0;
    }
}

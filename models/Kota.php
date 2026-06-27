<?php

class Kota
{
    private $conn;
    private $table = "kota";

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
                k.*,
                p.nama_provinsi,
                (
                    SELECT COUNT(*)
                    FROM kecamatan kc
                    WHERE kc.id_kota = k.id_kota
                ) AS total_kecamatan
            FROM kota k
            INNER JOIN provinsi p
                ON p.id_provinsi = k.id_provinsi
        ";

        if ($search != '') {

            $search = mysqli_real_escape_string($this->conn, $search);

            $sql .= "
                WHERE
                    k.nama_kota LIKE '%$search%'
                    OR
                    p.nama_provinsi LIKE '%$search%'
            ";
        }

        $sql .= "
            ORDER BY
                p.nama_provinsi,
                k.nama_kota ASC
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
                k.*,
                p.nama_provinsi,
                (
                    SELECT COUNT(*)
                    FROM kecamatan kc
                    WHERE kc.id_kota = k.id_kota
                ) AS total_kecamatan
            FROM kota k
            INNER JOIN provinsi p
                ON p.id_provinsi = k.id_provinsi
            WHERE k.id_kota = '$id'
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
        $provinsi = (int)$data['id_provinsi'];

        $nama = mysqli_real_escape_string(
            $this->conn,
            trim($data['nama_kota'])
        );

        return mysqli_query(
            $this->conn,
            "
            INSERT INTO kota
            (
                id_provinsi,
                nama_kota
            )
            VALUES
            (
                '$provinsi',
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
        $id = (int)$data['id_kota'];

        $provinsi = (int)$data['id_provinsi'];

        $nama = mysqli_real_escape_string(
            $this->conn,
            trim($data['nama_kota'])
        );

        return mysqli_query(
            $this->conn,
            "
            UPDATE kota
            SET
                id_provinsi='$provinsi',
                nama_kota='$nama'
            WHERE
                id_kota='$id'
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
            DELETE FROM kota
            WHERE id_kota='$id'
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
            FROM kecamatan
            WHERE id_kota='$id'
        ";

        $row = mysqli_fetch_assoc(
            mysqli_query($this->conn, $sql)
        );

        return $row['total'] == 0;
    }

}